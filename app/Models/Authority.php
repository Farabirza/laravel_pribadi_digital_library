<?php

namespace App\Models;

use App\Traits\GenerateUuid;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authority extends Model
{
    use HasFactory, GenerateUuid;
    protected $guarded = [
        'id'
    ];
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
