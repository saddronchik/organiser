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
            $table->integer('author_id')->unsigned()->nullable();
            $table->integer('addressed_id')->unsigned()->nullable();
            $table->integer('executor_id')->unsigned()->nullable();
            $table->integer('department_id')->unsigned()->nullable();
            $table->string('status',16);
            $table->string('status_color')->nullable();

            $table->foreign('author_id')
                ->references('id')
                ->on('users');

            $table->foreign('addressed_id')
                ->references('id')
                ->on('users');

            $table->foreign('executor_id')
                ->references('id')
                ->on('users');

            $table->foreign('department_id')
                ->references('id')
                ->on('departments');


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
        Schema::dropIfExists('assignments');
    }
}
