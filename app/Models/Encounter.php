<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;
class Encounter extends Model
{
    use HasFactory;

    protected $table = 'encounters';

    protected $fillable = [
        'encounter_user_id',
        'skip_user_id',
        'status',
     
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function encounterUser()
    {
        return $this->belongsTo(User::class, 'encounter_user_id');
    }
}
