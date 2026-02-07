<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Team extends Model
{
    protected $guarded = ['id'];
    protected $table = 'teams';



    // ===========================  Relations
    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'team_user',
            'team_id',
            'user_id',
            'id',
            'id',
        )
            ->withPivot('role')
            ->withTimestamps();
    }


    public function boards()
    {
        return $this->hasMany(Board::class, 'team_id');
    }



    // ===========================  Helpers
    public function admins()
    {
        return $this->users()->wherePivot('role', 'admin');
    }

    public function mnagers()
    {
        return $this->users()->wherePivot('role', 'mnager');
    }
}
