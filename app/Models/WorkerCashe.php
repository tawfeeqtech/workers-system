<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerCashe extends Model
{
    use HasFactory;
    protected $fillable = ['post_id', 'client_id', 'total'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
