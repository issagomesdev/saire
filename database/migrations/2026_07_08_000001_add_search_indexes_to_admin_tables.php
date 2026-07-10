<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Nenhuma coluna usada em busca/ordenacao das listagens do admin
 * (title, status, subject_type/subject_id/user_id, created_at) tinha
 * indice, em nenhuma tabela — toda busca/ordenacao "correta" ainda assim
 * forcaria table scan completo. audit_logs e a mais critica: cresce sem
 * limite (todo CRUD de 8 models gera uma linha via a trait Auditable).
 */
return new class extends Migration
{
    public function up()
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->index(['subject_type', 'subject_id']);
            $table->index('user_id');
            $table->index('created_at');
        });

        Schema::table('publications', function (Blueprint $table) {
            $table->index('title');
            $table->index('status');
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->index('title');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->index('title');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->index('title');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->index('title');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->index('title');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('name');
        });
    }

    public function down()
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropIndex(['subject_type', 'subject_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('publications', function (Blueprint $table) {
            $table->dropIndex(['title']);
            $table->dropIndex(['status']);
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->dropIndex(['title']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['title']);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropIndex(['title']);
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->dropIndex(['title']);
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropIndex(['title']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['name']);
        });
    }
};
