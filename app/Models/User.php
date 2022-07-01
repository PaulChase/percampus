<?php

namespace App\Models;

use App\Notifications\Auth\QueuedVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends \TCG\Voyager\Models\User implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    const STUDENT = 1;
    const BUSINESS_OWNER = 2;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new QueuedVerifyEmail());
    }

    // connectiong the users to all the posts added by the user

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referer');
    }

    public function postViews()
    {
        return $this->hasManyThrough(PostView::class, Post::class, 'user_id', 'viewable_id');
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }
}
