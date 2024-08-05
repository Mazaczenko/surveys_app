<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->text('text')->nullable();  // For textarea input
            $table->integer('numeric')->nullable(); // For numeric input like ratings
            $table->foreignId('option_id')->nullable()->constrained('options')->onDelete('cascade'); // For select input
            $table->enum('type', ['text', 'numeric', 'option']); // To define the type of the answer, should be foreign here, but it's a simple form
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('answers');
    }
};
