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
            $table->id();
            // 運用CoC, 讓 Models Books and users 產生關聯; 
            // Laravel 透過 Eloquent 提供的關聯方法(Model_id)讓兩張 tables 產生猶如 FK, PK 的關聯
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('author');
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
