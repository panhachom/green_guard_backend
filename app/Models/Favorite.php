<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites';

    protected $guarded = ['id'];
    protected $fillable = ['blog_id', 'user_id'];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
