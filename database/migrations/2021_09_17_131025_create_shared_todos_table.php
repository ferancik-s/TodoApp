<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharedTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shared_todos', function (Blueprint $table) {
            $table->id();
            $table->Biginteger('item_id')->unsigned();
            $table->Biginteger('user_id')->unsigned();
            $table->timestamps();
            $table->foreign('item_id')
                ->references('id')
                ->on('todos')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shared_todos');
    }
}
