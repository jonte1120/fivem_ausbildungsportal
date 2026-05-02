<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE documents_link DROP CONSTRAINT IF EXISTS documents_link_link_type_check');
            DB::statement("ALTER TABLE documents_link ADD CONSTRAINT documents_link_link_type_check CHECK (link_type IN ('QUALIFICATION', 'OTHER', 'ACCOUNT'))");

            return;
        }

        Schema::table('documents_link', function (Blueprint $table) {
            $table->enum('link_type', ['QUALIFICATION', 'OTHER', 'ACCOUNT'])
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE documents_link DROP CONSTRAINT IF EXISTS documents_link_link_type_check');
            DB::statement("ALTER TABLE documents_link ADD CONSTRAINT documents_link_link_type_check CHECK (link_type IN ('QUALIFICATION', 'OTHER'))");

            return;
        }

        Schema::table('documents_link', function (Blueprint $table) {
            $table->enum('link_type', ['QUALIFICATION', 'OTHER'])
                ->change();
        });
    }
};
