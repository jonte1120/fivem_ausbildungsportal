<?php

namespace App\Http\Controllers;

use App\DTO\TrainingGroupDTO;
use App\DTO\TrainingViewData;
use App\Models\Training;
use App\Policies\GeneralPolicy;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Throwable;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): mixed
    {
        try {
            $is_trainer = Gate::check('isTrainer', GeneralPolicy::class);

            $trainings = Training::getUpcomingTrainings($is_trainer ? false : true)
                ->map(fn(Training $training): TrainingViewData => TrainingViewData::fromModel($training, config('settings.enroll_deadline', 0)))
                ->groupBy('date')
                ->map(fn(Collection $items): TrainingGroupDTO => new TrainingGroupDTO(
                    $items->first()?->day_of_week . ' ' . $items->first()?->date_output,
                    $items,
                ));
        } catch (Throwable $exception) {
            Log::error('Unable to load home trainings', [
                'message' => $exception->getMessage(),
                'exception' => $exception,
            ]);

            $trainings = collect();
        }

        return view('home', [
            'trainings' => $trainings,
        ]);
    }
}
