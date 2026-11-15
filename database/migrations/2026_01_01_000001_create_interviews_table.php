<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_name');
            $table->string('role');
            $table->string('tech_stack');
            $table->text('question_text');
            $table->text('answer_text');
            $table->integer('depth_score');
            $table->string('verdict');
            $table->json('analysis_data');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
