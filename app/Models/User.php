<?php

namespace App\Models;

use App\Traits\GenerateUuid;
use App\Models\Authority;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, GenerateUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [ 'id' ];
    
    // get 'user' authority_id
    public function get_authority_user() {
        if(!Authority::where('name', 'admin')->first()) {
            $authority = Authority::create(['name' => 'superadmin']);
            $authority = Authority::create(['name' => 'admin']);
        }
        if(!Authority::where('name', 'user')->first()) {
            $create_authority = Authority::create(['name'=>'user']);
        }
        $authority = Authority::where('name', 'user')->first();
        return $authority->id;      
    }

    // boot function
    protected static function boot() {
        parent::boot();

        static::creating( function($model) {
            $model->authority_id = ($model->authority_id != null) ? $model->authority_id : $model->get_authority_user();
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function authority()
    {
        return $this->belongsTo(Authority::class, 'authority_id');
    }
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function report()
    {
        return $this->hasMany(Report::class);
    }
    public function notification()
    {
        return $this->hasMany(Notification::class);
    }
    public function review()
    {
        return $this->hasMany(Review::class);
    }
    public function book()
    {
        return $this->hasMany(Book::class);
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
        return $this->hasMany(LogVisitCategory::class);
    }
}
