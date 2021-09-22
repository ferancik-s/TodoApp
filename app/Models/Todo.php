<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Todo extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'todos';

    protected $primaryKey = 'id';

    protected $fillable = ['text', 'category_id', 'user_id', 'done'];

    public $sortable = ['category_id', 'text', 'done'];


    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function users() {
        return $this->belongsToMany(User::class, 'user_todo')->withPivot('shared');
    }
}
