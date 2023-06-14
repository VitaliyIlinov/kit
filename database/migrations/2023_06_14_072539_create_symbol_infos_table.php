<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSymbolInfosTable extends Migration
{

    public function up(): void
    {
        Schema::create('symbols', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('code')->unique();
            $table->string('symbol');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('symbols');
    }
}
