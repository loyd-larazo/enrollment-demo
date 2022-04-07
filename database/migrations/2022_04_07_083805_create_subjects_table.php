<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
			Schema::create('subjects', function (Blueprint $table) {
				$table->id();
				$table->foreignId('course_id');
				$table->string('subject');
				$table->string('code');
				$table->tinyInteger('units');
				$table->text('description')->nullable();
				$table->timestamps();

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
			Schema::dropIfExists('subjects');
    }
}
