<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class DeployDiagnosticsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $checks = [
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug'),
            'db_connection' => config('database.default'),
            'settings_table' => false,
            'trainings_table' => false,
            'sessions_table' => false,
            'db_ok' => false,
        ];

        try {
            DB::connection()->getPdo();
            $checks['db_ok'] = true;
            $checks['settings_table'] = Schema::hasTable('settings');
            $checks['trainings_table'] = Schema::hasTable('trainings');
            $checks['sessions_table'] = Schema::hasTable('sessions');
        } catch (Throwable $exception) {
            $checks['db_error'] = $exception->getMessage();
        }

        return response()->json($checks);
    }
}
