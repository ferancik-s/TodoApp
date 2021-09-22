<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_todo', function (Blueprint $table) {
            $table->id();
            $table->Biginteger('todo_id')->unsigned();
            $table->Biginteger('user_id')->unsigned();
            $table->boolean('shared');
            $table->timestamps();
            $table->foreign('todo_id')
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
        Schema::dropIfExists('user_todos');
    }
}
