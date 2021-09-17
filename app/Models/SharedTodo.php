<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedTodo extends Model
{
    use HasFactory;

    protected $table = 'shared_todos';

    protected $primaryKey = 'id';

    protected $fillable = ['item_id', 'user_id'];
}
