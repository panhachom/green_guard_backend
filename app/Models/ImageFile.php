<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageFile extends Model
{
    use HasFactory;

    protected $table = 'image_files';
    protected $guarded = ['id'];
    protected $fillable = [
        'parent_id',
        'parent_type',
        'file_name',
        'file_path',
        'file_url',
    ];

}
