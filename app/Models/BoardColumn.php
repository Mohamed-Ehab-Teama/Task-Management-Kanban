<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class BoardColumn extends Model
{
    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded();
    }
    
    protected $guarded = ['id'];
    protected $table = 'columns';

    // ===========================  Relations
    public function board()
    {
        return $this->belongsTo(Board::class, 'column_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'column_id')
            ->where('is_archived', false)
            ->orderBy('position');
    }

    // ===========================  Helpers
    public function isWIPExceeded()
    {
        return $this->wip_limit !== null 
            &&
            $this->tasks()->count() >= $this->wip_limit;
    }
}
