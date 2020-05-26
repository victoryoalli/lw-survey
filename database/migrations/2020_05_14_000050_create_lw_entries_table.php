<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLwEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('lw-survey.database.tables.entries'), function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id');
            $table->foreignId('user_id')->nullable();
            $table->unsignedInteger('max_points')->default(0);
            $table->unsignedInteger('points')->default(0);
            $table->decimal('percentage',18,2)->default(0);
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('lw-survey.database.tables.entries'));
    }
}
