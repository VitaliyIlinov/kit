<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('from');
            $table->unsignedInteger('to');
            $table->unsignedDecimal('best_rate', 25, 10);
            $table->timestamps();

            $table->foreign('from')->references('code')->on('symbols')->cascadeOnDelete();
            $table->foreign('to')->references('code')->on('symbols')->cascadeOnDelete();
            $table->unique(['from', 'to']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
}
