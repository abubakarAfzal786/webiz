<?php

namespace App\Http\Helpers;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait ImageUploadHelper
{
    /**
     * @param $file
     * @return bool
     */
    public function upload($file)
    {
        // TODO get setting from db
        $local = true;

        return $local ? $this->uploadLocal($file) : $this->uploadS3($file);
    }

    /**
     * @param $file
     * @return bool
     */
    public function uploadLocal($file)
    {
        return Storage::disk('public')->put('images', $file);
    }

    /**
     * @param $file
     * @return string
     */
    public function uploadS3($file)
    {
        return Storage::disk('s3')->put('images', $file);
    }

    /**
     * @param $url
     * @return string
     */
    public function uploadS3External($url)
    {
        $info = pathinfo($url);
        $contents = file_get_contents($url);
        $file = '/tmp/' . $info['basename'];
        file_put_contents($file, $contents);
        $file = new UploadedFile($file, $info['basename']);

        return Storage::disk('s3')->put('images', $file);
    }

    /**
     * @param string $attr
     * @return string
     */
    public function imageUrlGetter($attr)
    {
        $$attr = isset($this->$attr) && trim($this->$attr) ? $this->$attr : '';
        if ($$attr) {
            if (!filter_var($$attr, FILTER_VALIDATE_URL)) {
                return urldecode(Storage::disk('s3')->temporaryUrl($$attr, Carbon::now()->addMinutes(10)));
            }
        }
        return $$attr;
    }
}
