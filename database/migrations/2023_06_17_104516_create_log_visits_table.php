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
        Schema::create('log_visits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('ip_address')->nullable();
            $table->string('role')->default('student');
            $table->integer('grade')->nullable();
            $table->string('grade_level')->nullable();
            $table->foreignUuid('user_id')->default(0);
            $table->foreignUuid('book_id');
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
        Schema::dropIfExists('log_visits');
    }
};
