<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'price',
        'status',
        'rejected_reason',
        'worker_id',
    ];

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    public function reviews()
    {
        return $this->hasMany(WorkerReview::class);
    }
}
