<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('preamble')->nullable();
            $table->text('text')->nullable();
            $table->integer('author_id')->unsigned();
            $table->integer('addressed_id')->unsigned();
            $table->integer('assigned_id')->unsigned();
            $table->integer('executor_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->integer('status_id')->unsigned();

            $table->foreign('author_id')
                ->references('id')
                ->on('users');

            $table->foreign('addressed_id')
                ->references('id')
                ->on('users');

            $table->foreign('assigned_id')
                ->references('id')
                ->on('users');

            $table->foreign('executor_id')
                ->references('id')
                ->on('users');

            $table->foreign('department_id')
                ->references('id')
                ->on('departments');


            $table->foreign('status_id')
                ->references('id')
                ->on('statuses');

            $table->dateTime('deadline')->nullable();
            $table->dateTime('real_deadline')->nullable();


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
        Schema::dropIfExists('documents');
    }
}
