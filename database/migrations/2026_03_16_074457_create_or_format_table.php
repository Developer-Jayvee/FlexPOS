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
        Schema::create('or_format', function (Blueprint $table) {
            $table->id();
            $table->string("prefix");
            $table->boolean("has_date");
            $table->string("date_format")->default("YY/MM/DD");
            $table->integer("number_length")->default(4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('or_format');
    }
};
