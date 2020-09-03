<?php

namespace App\Models;

use App\Http\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use ImageUploadHelper;

    protected $fillable = [
        'title',
        'path',
        'size',
        'main',
        'relation_id',
        'model',
    ];
    
    public function getUrlAttribute()
    {
        return $this->imageUrlGetter('image');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'relation_id', 'id')->where('model', Member::class);
    }
}
