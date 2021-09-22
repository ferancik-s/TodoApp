<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTodo extends Model
{
    use HasFactory;

    protected $table = 'user_todo';

    protected $primaryKey = 'id';

    protected $fillable = ['user_id', 'todo_id', 'shared'];

}
