<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;
class UsersLikes extends Model
{
    use HasFactory;

    protected $table = 'user_likes';

    protected $fillable = [
        'liked_user_id',
        'user_id',
        'status',
     
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likedUser()
    {
        return $this->belongsTo(User::class, 'liked_user_id');
    }
}