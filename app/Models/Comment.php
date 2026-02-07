<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Comment extends Model
{
    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded();
    }

    
    protected $guarded = ['id'];
    protected $table = 'comments';



    // ===========================  Relations
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
