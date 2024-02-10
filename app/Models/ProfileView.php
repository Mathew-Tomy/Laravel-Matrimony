<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\User;
class ProfileView extends Model
{
    use HasFactory;

    protected $table = 'profile_view';

    protected $fillable = [
        'visitor_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'visitor_id');
    }
    public function notifications()
    {
        return $this->hasmany(Notification::class);
    }
    public function viewer()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

}