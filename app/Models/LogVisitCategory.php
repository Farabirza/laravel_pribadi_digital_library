<?php

namespace App\Models;

use App\Traits\GenerateUuid;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogVisitCategory extends Model
{
    use HasFactory, GenerateUuid;
    protected $guarded = [ 'id' ];
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
