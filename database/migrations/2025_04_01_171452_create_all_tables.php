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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('cpf')->unique();
            $table->string('password');
        });

        Schema::create('unit', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // AP 801
            $table->integer('id_owner'); // dono da unidade
        });

        Schema::create('unit_peoples', function (Blueprint $table) {
            $table->id();
            $table->integer('id_unit');
            $table->string('name');
            $table->date('birthdate');
        });

        Schema::create('unit_vehicles', function (Blueprint $table) {
            $table->id();
            $table->integer('id_unit');
            $table->string('title');
            $table->string('color');
            $table->string('plate');
        });

        Schema::create('unit_pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('race');
        });

        Schema::create('walls', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('body');
            $table->date('date_created');
        });

        Schema::create('wall_likes', function (Blueprint $table) {
            $table->id();
            $table->integer('id_wall');
            $table->integer('id_user');
        });

        Schema::create('docs', function (Blueprint $table) {
            $table->id();
            $table->string('tile');
            $table->string('file_url');
        });

        Schema::create('billets', function (Blueprint $table) {
            $table->id();
            $table->integer('id_unit');
            $table->string('title');
            $table->string('file_url');
        });

        Schema::create('warnings', function (Blueprint $table) {
            $table->id();
            $table->integer('id_unit');
            $table->string('title');
            $table->string('status')->default('IN_REVIEW'); // IN_REVIEW, RESOLVED
            $table->date('date_created');
            $table->text('photos'); // 'foto01.jpg
        });

        Schema::create('found_and_lost', function (Blueprint $table) {
            $table->id();
            $table->string('statis')->default('LOST'); // FOUND, LOST
            $table->string('photo');
            $table->string('description');
            $table->string('where');
            $table->date('date_created');
        });

        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->integer('allowed');
            $table->string('title');
            $table->string('cover');
            $table->string('days');
            $table->time('start_time');
            $table->time('end_time');
        });

        Schema::create('area_disabled_days', function (Blueprint $table) {
            $table->id();
            $table->integer('id_area');
            $table->date('day');
        });

        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('id_unit');
            $table->integer('id_area');
            $table->datetime('reservation_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('units');
        Schema::dropIfExists('unit_peoples');
        Schema::dropIfExists('unit_vehicles');
        Schema::dropIfExists('unit_pets');
        Schema::dropIfExists('walls');
        Schema::dropIfExists('wall_likes');
        Schema::dropIfExists('docs');
        Schema::dropIfExists('billets');
        Schema::dropIfExists('warnings');
        Schema::dropIfExists('found_and_lost');
        Schema::dropIfExists('areas');
        Schema::dropIfExists('area_disabled_days');
        Schema::dropIfExists('reservations');
    }
};
