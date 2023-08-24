<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->nullable();
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->integer('publication_year')->nullable();
            $table->string('isbn')->nullable();
            $table->text('summary')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('url')->nullable();
            $table->string('keywords')->nullable();
            $table->string('source')->nullable();
            $table->string('access')->default('limited');
            $table->string('status')->default('active');
            $table->foreignUuid('user_id');
            $table->foreignUuid('category_id');
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
        Schema::dropIfExists('books');
    }
};
