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
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('cover_image')->nullable();
            $table->string('full_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('role')->default('student');
            $table->string('grade')->nullable();
            $table->string('year_join')->nullable();
            $table->string('address_street')->nullable();
            $table->string('address_city')->nullable();
            $table->integer('address_zip')->nullable();
            $table->string('languange')->nullable();
            $table->string('interest')->nullable();
            $table->text('biodata')->nullable();
            $table->string('email')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('threads')->nullable();
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('whatsapp')->nullable();
            $table->foreignUuid('user_id');
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
        Schema::dropIfExists('profiles');
    }
};
