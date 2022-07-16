<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('phone_books', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('phone')->unique();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('image')->nullable();
            $table->float('long')->nullable();
            $table->float('lat')->nullable();
            $table->integer('nid')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('phone_books');
    }
};
