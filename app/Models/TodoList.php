<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class TodoList extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'todo_lists';

    protected $primaryKey = 'id';

    protected $fillable = ['text', 'category_id', 'user_id', 'done'];

    public $sortable = ['category_id', 'text', 'done'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }


}
