<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Añade la columna role_id después de id y crea la FK
            $table->foreignId('role_id')
                  ->after('id')
                  ->constrained('roles')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Deshace primero la FK y luego la columna
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
}

