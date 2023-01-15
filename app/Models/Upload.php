<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;

class Upload extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_original_name',
        'file_name',
        'file_size',
        'extension',
        'type',
    ];

    private $fileUploadPath = '';
    private $fileManagerThumbnailWidth = 100;
    private $fileManagerThumbnailSuffix = '';
    const UPLOAD_PATH = "/uploads/all/";
    public function __construct()
    {
        $this->fileUploadPath = Config::get('constants.file_upload_path');
        $this->fileManagerThumbnailSuffix = Config::get('constants.file_manager_thumbnail_suffix');
    }

    public function getFileFullPath()
    {
        return asset($this->fileUploadPath) . '/' . $this->file_name;
    }

    public function getOriginalFileFullName()
    {
        return $this->file_original_name . "." . $this->extension;
    }

    public function getImageOptimizedFullName($width = 0, $height = 0)
    {
        //default width
        if($width == "0" || $width =="")
        {
            $width = "100";
        }

        $filename = str_replace("." . $this->extension, "", $this->file_name) . "-" . $width . "-" . $height . "." . $this->extension;
        if (file_exists(public_path($this->fileUploadPath . "/" . $filename))) {
            return asset($this->fileUploadPath . "/" . $filename);
        }

        if (file_exists(public_path($this->fileUploadPath) . $this->file_name) && $this->type == 'image') {
            $image = Image::make(public_path($this->fileUploadPath) . "/" . $this->file_name);

            if($height == "0" || $height =="")
            {
                $ratio = $image->width() / $image->height();
                $height = floor($width / $ratio);
                $image->resize($width, $height);
            }
            else
            {
                $image->fit($width, $height);
            }

            $image->save(public_path($this->fileUploadPath) . $filename, 80);
            clearstatcache();
        } else {
            $filename = 'none.png';
        }
        return asset($this->fileUploadPath) . '/' . $filename;
    }

    // public function getImageCacheFullName($width = 0) {
    //     return asset('/imagecache/image/' . $this->file_name . '?width=' . $width );
    // }

    public function getFileManagerThumbnailPath()
    {
        $filename = str_replace('.' . $this->extension, Config::get('constants.file_manager_thumbnail_suffix') . '.' . $this->extension, $this->file_name);

        if (!file_exists(public_path($this->fileUploadPath) . '/' . $filename) && $this->type == 'image') {
            // this is for the file manager thumbnail
            $image = Image::make(public_path($this->fileUploadPath) . $this->file_name);

            $height = $this->fileManagerThumbnailWidth * $image->height() / $image->width();

            $image->resize($this->fileManagerThumbnailWidth, $height);

            $image->save(public_path($this->fileUploadPath) . '/' . $filename, 80);
            clearstatcache();
        }

        return asset($this->fileUploadPath) . '/' . $filename;
    }

    public function scopeImage($query)
    {
        return $query->whereOr('type', 'image');
    }

    public function scopeAsset($query)
    {
        return $query->where('type', '!=', 'image');
    }
}
