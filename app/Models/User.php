<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasUuids, Notifiable;

    protected $with = ['link', 'stats'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'slug',
        'title',
        'description',
    ];

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
        'password' => 'hashed',
    ];

    public function link(): HasOne
    {
        return $this->hasOne(UserLink::class);
    }

    public function userFavorites(): MorphMany
    {
        return $this->morphMany(UserFavorite::class, 'favoriteable');
    }

    public function stats(): HasOne
    {
        return $this->hasOne(UserStat::class);
    }

    public function facts(): HasMany
    {
//        return $this->hasManyThrough(Fact::class, UserFavorite::class, 'user_id', 'id', 'id', 'favoriteable_id')
//            ->where('favoriteable_type', '=', Fact::class);
        return $this->hasMany(Fact::class);
    }

    public function factsCount(): int
    {
        return $this->facts()->count();
    }

    public function likes()
    {
        return $this->facts()->get()->map(function ($fact) {
            return $fact->likes();
        });
    }

    public function likesCount()
    {
        return $this->likes()->map(function ($like) {
            return $like->get()->filter(function ($like) {
                return $like->is_like;
            })->count();
        })->sum();
    }

}
