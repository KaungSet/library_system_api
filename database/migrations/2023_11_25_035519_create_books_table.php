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
            $table->string('title')->unique()->index();
            $table->string('isbn', 20)->unique()->comment('International Standard Book Number');
            $table->unsignedBigInteger('price')->nullable()->default(0);
            $table->unsignedBigInteger('rent_fees')->nullable()->default(0);
            $table->unsignedBigInteger('quantity')->default(1);
            $table->unsignedBigInteger('author_id');
            $table->date('published_date');
            $table->enum('is_available', [0, 1])->default(1)->comment('0: Inactive, 1: Active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('authors')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
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
