<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class FFileManagerController extends Controller
{
    private $fileTypes = array(
        "jpg" => "image",
        "jpeg" => "image",
        "png" => "image",
        "svg" => "image",
        "webp" => "image",
        "gif" => "image",
        "mp4" => "video",
        "mpg" => "video",
        "mpeg" => "video",
        "webm" => "video",
        "ogg" => "video",
        "avi" => "video",
        "mov" => "video",
        "flv" => "video",
        "swf" => "video",
        "mkv" => "video",
        "wmv" => "video",
        "wma" => "audio",
        "aac" => "audio",
        "wav" => "audio",
        "mp3" => "audio",
        "zip" => "archive",
        "rar" => "archive",
        "7z" => "archive",
        "doc" => "document",
        "txt" => "document",
        "docx" => "document",
        "pdf" => "document",
        "csv" => "document",
        "xml" => "document",
        "ods" => "document",
        "xlr" => "document",
        "xls" => "document",
        "xlsx" => "document",
        "glb" => "cad",
        "gltf" => "cad",
        "usdz" => "cad",
        "3dm" => "Rhinoceros",
        "stl" => "Stereolithography",
    );

    private $fileUploadPath = '';

    private $fileManagerThumbnailWidth = 100;
    private $fileManagerThumbnailSuffix = '';

    public function __construct()
    {
        $this->fileUploadPath = Config::get('constants.file_upload_path');
        $this->fileManagerThumbnailSuffix = Config::get('constants.file_manager_thumbnail_suffix');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filename = $request->has('filename') ? $request->filename : '';

        $query = Upload::where('file_original_name', 'LIKE', '%' . $filename . '%');

        if ($request->has('filesize') && $request->filesize) {
            $query->where('file_size', '<=', $request->filesize);
        }

        if ($request->has('filetype_image') && $request->filetype_image) {
            $query->image();
        }

        if ($request->has('filetype_asset') && $request->filetype_asset) {
            $query->asset();
        }

        $files = $query->orderBy('id', 'desc')->paginate(16);

        $minFileSize = Upload::min('file_size');
        $maxFileSize = Upload::max('file_size');

        return view('file-manager.index', compact('files', 'minFileSize', 'maxFileSize'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->hasFile('file')) {
            return false;
        }

        $upload = new Upload;
        $extension = strtolower($request->file('file')->getClientOriginalExtension());

        if (!isset($this->fileTypes[$extension])) {
            return false;
        }

        $upload->file_original_name = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);

        $hash = Str::random(40);
        $size = $request->file('file')->getSize();
        $fileName = $hash . '.' . $extension;

        $request->file('file')->move(public_path($this->fileUploadPath), $fileName);

        $upload->extension = $extension;
        $upload->file_name = $hash . '.' . $extension;
        $upload->user_id = Auth::user()->id;
        $upload->type = $this->fileTypes[$extension];
        $upload->file_size = $size;
        $upload->save();

        return $upload;
    }

    public function store_origin_image(Request $request)
    {
        if (!$request->hasFile('file')) {
            return false;
        }

        $upload = new Upload;
        $extension = strtolower($request->file('file')->getClientOriginalExtension());

        if (!isset($this->fileTypes[$extension]) || $this->fileTypes[$extension] != 'image') {
            return false;
        }

        $upload->file_original_name = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);

        $hash = Str::random(40);
        $size = $request->file('file')->getSize();
        $fileName = $hash . '.' . $extension;

        $request->file('file')->move(public_path($this->fileUploadPath), $fileName);

        $upload->extension = $extension;
        $upload->file_name = $hash . '.' . $extension;
        $upload->user_id = Auth::user()->id;
        $upload->type = $this->fileTypes[$extension];
        $upload->file_size = $size;
        $upload->save();

        return $upload;
    }

    public function store_thumb_image(Request $request)
    {
        if (!$request->hasFile('file')) {
            return false;
        }

        $upload = new Upload;
        $extension = strtolower($request->file('file')->getClientOriginalExtension());

        if (!isset($this->fileTypes[$extension]) || $this->fileTypes[$extension] != 'image') {
            return false;
        }

        $upload->file_original_name = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
        $size = $request->file('file')->getSize();

        $hash = Str::random(40);
        $path = $request->file('file')->move(
            public_path('uploads/all'), $hash . '.' . $extension
        );

        $image = Image::make(public_path('uploads/all/') . $hash . '.' . $extension);

        $thumbnailWidth = Config::get('constants.product_thumbnail_size.width');
        $thumbnailHeight = Config::get('constants.product_thumbnail_size.height');
        $suffix = Config::get('constants.product_thumbnail_suffix');

        $image->resize($thumbnailWidth, $thumbnailHeight);
        $image->save(public_path('uploads/all/') . $hash . $suffix . '.' . $extension, 80);

        $upload->extension = $extension;
        $upload->file_name = $hash . $suffix . '.' . $extension;
        $upload->user_id = Auth::user()->id;
        $upload->type = $this->fileTypes[$extension];
        $upload->file_size = $size;
        $upload->save();

        return $upload;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $search = $request->has('search') ? $request->search : '';

        $files = Upload::where('user_id', auth()->id())->where('file_original_name', 'LIKE', '%' . $search . '%')->orderby('id', 'desc')->paginate(16);

        if ($request->ajax() && $request->has('page')) {
            return view('file-manager.modal.files-pagination', ['files' => $files]);
        }

        return view('file-manager.modal.container-modal', ['files' => $files]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Upload::destroy($id);

        return true;
    }
}