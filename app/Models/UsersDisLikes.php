<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;
class UsersDisLikes extends Model
{
    use HasFactory;
    protected $table = 'user_dislikes';

    protected $fillable = [
        'dislike_user_id',
        'user_id',
        'status',
     
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dislikeUser()
    {
        return $this->belongsTo(User::class, 'dislike_user_id');
    }
}
