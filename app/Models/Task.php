<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Task extends Model
{
    use HasFactory;
    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded();
    }


    protected $guarded = ['id'];
    protected $table = 'tasks';
    protected $casts = [
        'due_date' => 'datetime',
        'is_archived' => 'boolean',
    ];


    // ===========================  Relations
    public function column()
    {
        return $this->belongsTo(BoardColumn::class, 'column_id', 'id');
    }

    public function board()
    {
        return $this->belongsTo(Board::class, 'board_id');
    }

    public function creator()
    {
        return $this->belongsTo(user::class, 'created_by');
    }



    public function assignees()
    {
        return $this->belongsToMany(
            User::class,
            'task_assignments',
            'task_id',
            'user_id',
            'id',
            'id'
        )
            ->withTimestamps();
    }



    public function comments()
    {
        return $this->hasMany(Comment::class, 'task_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'task_id');
    }


    // ===========================  Helpers
    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeOverdue($query)
    {
        return $query->whereNotNull('due_date')
            ->where('due_date', '<', now());
    }

    public function isOverDue()
    {
        return $this->due_date !== null
            && $this->due_date->isPast();
    }
}
