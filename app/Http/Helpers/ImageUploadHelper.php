<?php

namespace App\Http\Helpers;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait ImageUploadHelper
{
    /**
     * @return string
     */
    private function getDisk()
    {
        return Setting::getValue('storage_disk', 'gcs');
    }

    /**
     * @param $file
     * @return string
     */
    public function uploadImage($file)
    {
        return Storage::disk($this->getDisk())->put('images', $file);
    }

    /**
     * @param $url
     * @return string
     */
    public function uploadExternalUrl($url)
    {
        $info = pathinfo($url);
        $contents = file_get_contents($url);
        $file = '/tmp/' . $info['basename'];
        file_put_contents($file, $contents);
        $file = new UploadedFile($file, $info['basename']);

        return Storage::disk($this->getDisk())->put('images', $file);
    }

    /**
     * @param string $attr
     * @return string
     */
    public function imageUrlGetter(string $attr)
    {
        $$attr = isset($this->$attr) && trim($this->$attr) ? $this->$attr : '';
        if ($$attr) {
            if (!filter_var($$attr, FILTER_VALIDATE_URL)) {
                if ($this->getDisk() == 'gcs') {
                    return Storage::disk('gcs')->url($$attr);
                } else {
                    return urldecode(Storage::disk('s3')->temporaryUrl($$attr, Carbon::now()->addMinutes(10)));
                }
            }
        }
        return $$attr;
    }

    /**
     * @param $path
     * @return bool
     */
    public function deleteImage($path)
    {
        return Storage::disk($this->getDisk())->delete($path);
    }
}
