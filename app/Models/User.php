<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    // ===========================  Relations
    public function teams()
    {
        return $this->belongsToMany(
            Team::class,
            'team_user',
            'user_id',
            'team_id',
            'id',
            'id',
        )
            ->withPivot('role')
            ->withTimestamps();
    }



    public function assignedTasks()
    {
        return $this->belongsToMany(
            Task::class,
            'task_assignments',
            'user_id',
            'task_id',
            'id',
            'id',
        )->withTimestamps();
    }


    public function activityLogs()
    {
        return $this->hasMany(ActivityLogger::class, 'causer_id');
    }



    // ===========================  Helpers
    public function roleInTeam(Team $team)
    {
        return $this->teams()
            ->where('team_id', $team->id)
            ->first()?->pivot?->role;
    }
}
