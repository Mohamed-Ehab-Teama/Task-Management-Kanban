<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Board extends Model
{
    protected $guarded = ['id'];
    protected $table = 'boards';

    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded();
    }


    // ===========================  Relations
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function columns()
    {
        return $this->hasMany(BoardColumn::class, 'column_id')
            ->orderBy('position');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'task_id');
    }



    // ===========================  Helpers
    public function scopeActive()
    {
        return $this->where('is_archived', false);
    }
}
