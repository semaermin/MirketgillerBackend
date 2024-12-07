<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasTable('permissions')) {
            Schema::create('permissions', function (Blueprint $table) {
                $table->id();
                $table->string('name', 191);
                $table->string('guard_name', 191);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the permissions table if it exists
        if (Schema::hasTable('permissions')) {
            Schema::drop('permissions');
        }

        // You can add similar checks for other related tables if necessary
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        if (Schema::hasTable($tableNames['role_has_permissions'])) {
            Schema::drop($tableNames['role_has_permissions']);
        }

        if (Schema::hasTable($tableNames['model_has_roles'])) {
            Schema::drop($tableNames['model_has_roles']);
        }

        if (Schema::hasTable($tableNames['model_has_permissions'])) {
            Schema::drop($tableNames['model_has_permissions']);
        }

        if (Schema::hasTable($tableNames['roles'])) {
            Schema::drop($tableNames['roles']);
        }
    }
};
