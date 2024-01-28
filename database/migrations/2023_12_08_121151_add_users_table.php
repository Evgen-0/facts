<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('photo', 128)->nullable();
            $table->string('name', 20)->change();
            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->id();
            $table->dropColumn([
                'photo',
            ]);
            $table->string('name', 255)->change();
            $table->dropUnique('users_name_unique');
        });
    }
};
