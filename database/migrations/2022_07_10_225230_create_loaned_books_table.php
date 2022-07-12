<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('loaned_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id');
            $table->foreignId('client_id');
            $table->timestamp('start_date');
            $table->timestamp('return_date');
            $table->integer('late')->default(0);
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
        Schema::dropIfExists('loaned_books');
    }
};
