<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrolledUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
			Schema::create('enrolled_users', function (Blueprint $table) {
				$table->id();
				$table->foreignId('school_year_id');
				$table->foreignId('user_id');
				$table->foreignId('course_id');
				$table->tinyInteger('year_level');
				$table->timestamps();

				$table->foreign('school_year_id')->references('id')->on('school_years')->onDelete('cascade');
				$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
				$table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
			});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
			Schema::dropIfExists('enrolled_users');
    }
}
