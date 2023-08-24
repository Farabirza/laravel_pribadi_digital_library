<?php

namespace App\Models;

use App\Traits\GenerateUuid;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    use HasFactory, GenerateUuid;
    protected $guarded = [ 'id' ];
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query
                ->where('title', 'like', '%'.$search.'%')
                ->orWhere('keywords', 'like', '%'.$search.'%')
                ->orWhere('author', 'like', '%'.$search.'%')
                ->orWhere('publisher', 'like', '%'.$search.'%')
                ->orWhere('publication_year', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->orWhereHas('category', function (Builder $query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                });
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function chapter()
    {
        return $this->hasMany(Chapter::class);
    }
    public function report()
    {
        return $this->hasMany(Report::class);
    }
    public function review()
    {
        return $this->hasMany(Review::class);
    }
    public function bookmark()
    {
        return $this->hasMany(Bookmark::class);
    }
    public function logVisit()
    {
        return $this->hasMany(LogVisit::class);
    }
    public function logVisitCategory()
    {
        return $this->hasMany(logVisitCategory::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
