<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'blogs';
    protected $guarded = ['id'];
    protected $fillable = ['title' , 'body' , 'sub_title', 'status' , 'user_id'];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function images()
    {
        return $this->morphMany(ImageFile::class, 'parent');
    }
 
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

}
