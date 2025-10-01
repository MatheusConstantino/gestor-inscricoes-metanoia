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
        Schema::table('organizations', function (Blueprint $table) {
            $table->enum('status', ['ativo', 'inativo'])->default('ativo')->after('slug');
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('members', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('ministries', function (Blueprint $table) {
            $table->string('slug', 120)->unique()->after('name');
            $table->enum('status', ['ativo', 'inativo'])->default('ativo')->after('slug');
            $table->softDeletes();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->string('slug', 170)->unique()->after('name');
            $table->enum('status', ['agendado', 'realizado', 'cancelado'])->default('agendado')->after('audience');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('status');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('members', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('ministries', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('status');
            $table->dropColumn('slug');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('status');
            $table->dropColumn('slug');
        });
    }
};
