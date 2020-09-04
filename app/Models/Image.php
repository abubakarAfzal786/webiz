<?php

namespace App\Models;

use App\Http\Helpers\ImageUploadHelper;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use ImageUploadHelper;

    protected $fillable = [
        'title',
        'path',
        'size',
        'main',
    ];

    protected $appends = [
        'url'
    ];

    /**
     * @return string
     */
    public function getUrlAttribute()
    {
        return $this->imageUrlGetter('path');
    }

    /**
     * @return MorphTo
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * @return bool|void|null
     * @throws Exception
     */
    public function delete()
    {
        $this->deleteImage($this->getAttribute('path'));
        parent::delete();
    }
}
