<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use App\Models\Upload;
use Response;
use Auth;
use Storage;
use Image;

class UploadController extends Controller
{
    public function index(Request $request) {

        $all_uploads = (auth()->user()->role == 3) ? Upload::where('user_id',auth()->user()->id) : Upload::query();
        $search = null;
        $sort_by = null;

        if ($request->search != null) {
            $search = $request->search;
            $all_uploads->where('file_original_name', 'like', '%'.$request->search.'%');
        }

        $sort_by = $request->sort;
        switch ($request->sort) {
            case 'newest':
                $all_uploads->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $all_uploads->orderBy('created_at', 'asc');
                break;
            case 'smallest':
                $all_uploads->orderBy('file_size', 'asc');
                break;
            case 'largest':
                $all_uploads->orderBy('file_size', 'desc');
                break;
            default:
                $all_uploads->orderBy('created_at', 'desc');
                break;
        }

        $all_uploads = $all_uploads->paginate(60)->appends(request()->query());


        return (auth()->user()->user_type == 'seller')
            ? view('frontend.user.seller.uploads.index', compact('all_uploads', 'search', 'sort_by'))
            : view('backend.filemanager.index', compact('all_uploads', 'search', 'sort_by'));
    }

    public function create(){
        return (auth()->user()->user_type == 'seller')
            ? view('frontend.user.seller.uploads.create')
            : view('backend.filemanager.create');
    }


    public function show_uploader(Request $request){
        return view('uploader.aiz-uploader');
    }

    public function upload(Request $request){
        $type = array(
            "jpg"=>"image",
            "jpeg"=>"image",
            "png"=>"image",
            "svg"=>"image",
            "webp"=>"image",
            "gif"=>"image",
            "mp4"=>"video",
            "mpg"=>"video",
            "mpeg"=>"video",
            "webm"=>"video",
            "ogg"=>"video",
            "avi"=>"video",
            "mov"=>"video",
            "flv"=>"video",
            "swf"=>"video",
            "mkv"=>"video",
            "wmv"=>"video",
            "wma"=>"audio",
            "aac"=>"audio",
            "wav"=>"audio",
            "mp3"=>"audio",
            "zip"=>"archive",
            "rar"=>"archive",
            "7z"=>"archive",
            "doc"=>"document",
            "txt"=>"document",
            "docx"=>"document",
            "pdf"=>"document",
            "csv"=>"document",
            "xml"=>"document",
            "ods"=>"document",
            "xlr"=>"document",
            "xls"=>"document",
            "xlsx"=>"document",
            "glb" => "cad",
            "gltf" => "cad",
            "usdz" => "cad",
            "3dm" => "Rhinoceros",
            "stl" => "Stereolithography"
        );

        if($request->hasFile('file')){
            $upload = new Upload;
            $extension = strtolower($request->file('file')->getClientOriginalExtension());

            if(isset($type[$extension])){
                $upload->file_original_name = null;
                $arr = explode('.', $request->file('file')->getClientOriginalName());
                for($i=0; $i < count($arr)-1; $i++){
                    if($i == 0){
                        $upload->file_original_name .= $arr[$i];
                    }
                    else{
                        $upload->file_original_name .= ".".$arr[$i];
                    }
                }

                //$path = $request->file('aiz_file')->store('uploads/all', 'local');
                $hash = Str::random(40);
                $extension = $request->file('file')->getClientOriginalExtension();



                $size = $request->file('file')->getSize();
                $path = $request->file('file')->move(
                    public_path('uploads/all'), $hash . '.' . $extension
                );
                // Return MIME type ala mimetype extension
                $finfo = finfo_open(FILEINFO_MIME_TYPE);

                // Get the MIME type of the file
                $file_mime = finfo_file($finfo,$path);

                if($type[$extension] == 'image'){
                    try {
                        $img = Image::make($request->file('file')->getRealPath())->encode();
                        $height = $img->height();
                        $width = $img->width();
                        if($width > $height && $width > 1500){
                            $img->resize(1500, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }elseif ($height > 1500) {
                            $img->resize(null, 800, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }
                        $img->save(base_path('public/').$path);
                        clearstatcache();
                        $size = $img->filesize();

                    } catch (\Exception $e) {
                        //dd($e);
                    }
                }

                if (env('FILESYSTEM_DRIVER') == 's3') {
                    Storage::disk('s3')->put(
                        $path,
                        file_get_contents(base_path('public/').$path),
                        [
                            'visibility' => 'public',
                            'ContentType' =>  $extension == 'svg' ? 'image/svg+xml' : $file_mime
                        ]
                    );
                    if($arr[0] != 'updates') {
                        unlink(base_path('public/').$path);
                    }
                }

                $upload->extension = $extension;
                $upload->file_name = $hash . '.' . $extension;
                $upload->user_id = Auth::user()->id;
                $upload->type = $type[$upload->extension];
                $upload->file_size = $size;
                $upload->save();
            }
            return redirect()->route('backend.filemanager.list');
        }
    }

    public function ajaxupload(Request $request){
        $type = array(
            "jpg"=>"image",
            "jpeg"=>"image",
            "png"=>"image",
            "svg"=>"image",
            "webp"=>"image",
            "gif"=>"image",
            "mp4"=>"video",
            "mpg"=>"video",
            "mpeg"=>"video",
            "webm"=>"video",
            "ogg"=>"video",
            "avi"=>"video",
            "mov"=>"video",
            "flv"=>"video",
            "swf"=>"video",
            "mkv"=>"video",
            "wmv"=>"video",
            "wma"=>"audio",
            "aac"=>"audio",
            "wav"=>"audio",
            "mp3"=>"audio",
            "zip"=>"archive",
            "rar"=>"archive",
            "7z"=>"archive",
            "doc"=>"document",
            "txt"=>"document",
            "docx"=>"document",
            "pdf"=>"document",
            "csv"=>"document",
            "xml"=>"document",
            "ods"=>"document",
            "xlr"=>"document",
            "xls"=>"document",
            "xlsx"=>"document",
            "glb" => "cad",
            "gltf" => "cad",
            "usdz" => "cad",
            "3dm" => "Rhinoceros",
            "stl" => "Stereolithography"
        );

        if($request->hasFile('file')){

            $upload = new Upload;
            $extension = strtolower($request->file('file')->getClientOriginalExtension());

            if(isset($type[$extension])){

                $upload->file_original_name = null;
                $arr = explode('.', $request->file('file')->getClientOriginalName());
                for($i=0; $i < count($arr)-1; $i++){
                    if($i == 0){
                        $upload->file_original_name .= $arr[$i];
                    }
                    else{
                        $upload->file_original_name .= ".".$arr[$i];
                    }
                }

                //$path = $request->file('aiz_file')->store('uploads/all', 'local');
                $hash = Str::random(40);
                $extension = $request->file('file')->getClientOriginalExtension();

                $size = $request->file('file')->getSize();

                $path = $request->file('file')->move(
                    public_path('uploads/all'), $hash . '.' . $extension
                );

                // the image will be replaced with an optimized version which should be smaller
                // ImageOptimizer::optimize(public_path('uploads/all/') . $hash . '.' . $extension);
                // ImageOptimizer::optimize(public_path('uploads/all/') . $hash . '.' . $extension, public_path('uploads/optimize/1.jpg'));

                // Return MIME type ala mimetype extension
                $finfo = finfo_open(FILEINFO_MIME_TYPE);

                // Get the MIME type of the file
                $file_mime = finfo_file($finfo, $path);

                if($type[$extension] == 'image') {
                    try {
                        $image = Image::make(public_path('uploads/all/') . $hash . '.' . $extension);

                        // if($width > $height && $width > 1500) {
                        //     $image->resize(1500, null, function ($constraint) {
                        //         $constraint->aspectRatio();
                        //     });
                        // }elseif ($height > 1500) {
                        //     $image->resize(null, 800, function ($constraint) {
                        //         $constraint->aspectRatio();
                        //     });
                        // }

                        $thumbnailWidth = Config::get('constants.product_thumbnail_size.width');
                        $thumbnailHeight = Config::get('constants.product_thumbnail_size.height');
                        $suffix = Config::get('constants.product_thumbnail_suffix');

                        $image->resize($thumbnailWidth, $thumbnailHeight);

                        $image->save(public_path('uploads/all/') . $hash . $suffix . '.' . $extension, 80);
                        clearstatcache();

                    } catch (\Exception $e) {
                    }
                }

                if (env('FILESYSTEM_DRIVER') == 's3') {
                    Storage::disk('s3')->put(
                        $path,
                        file_get_contents(base_path('public/').$path),
                        [
                            'visibility' => 'public',
                            'ContentType' =>  $extension == 'svg' ? 'image/svg+xml' : $file_mime
                        ]
                    );
                    if($arr[0] != 'updates') {
                        unlink(base_path('public/').$path);
                    }
                }

                $upload->extension = $extension;
                $upload->file_name = $hash . '.' . $extension;
                $upload->user_id = Auth::user()->id;
                $upload->type = $type[$upload->extension];
                $upload->file_size = $size;
                $upload->save();
            }

            $product = $request->is_product == 1 ? true : false;
            $model = $request->is_model == 1 ? true : false;
            $uploads = Upload::orderBy('id', 'DESC')->where('user_id', Auth::user()->id);
            return view('backend.filemanager.partials.components.list', [
                'files' =>  $uploads->paginate(60)->appends(request()->query()),
                'is_product' => $product,
                'is_model' => $model,
                'selected' => explode(",", $request->seleted)
            ]);
        }
    }


    public function apiUpload(Request $request){
        $type = array(
            "jpg"=>"image",
            "jpeg"=>"image",
            "png"=>"image",
            "svg"=>"image",
            "webp"=>"image",
            "gif"=>"image",
            "mp4"=>"video",
            "mpg"=>"video",
            "mpeg"=>"video",
            "webm"=>"video",
            "ogg"=>"video",
            "avi"=>"video",
            "mov"=>"video",
            "flv"=>"video",
            "swf"=>"video",
            "mkv"=>"video",
            "wmv"=>"video",
            "wma"=>"audio",
            "aac"=>"audio",
            "wav"=>"audio",
            "mp3"=>"audio",
            "zip"=>"archive",
            "rar"=>"archive",
            "7z"=>"archive",
            "doc"=>"document",
            "txt"=>"document",
            "docx"=>"document",
            "pdf"=>"document",
            "csv"=>"document",
            "xml"=>"document",
            "ods"=>"document",
            "xlr"=>"document",
            "xls"=>"document",
            "xlsx"=>"document",
            "glb" => "cad",
            "gltf" => "cad",
            "usdz" => "cad",
            "3dm" => "Rhinoceros",
            "stl" => "Stereolithography"
        );
        $upload = '';
        if($request->hasFile('file')){
            $upload = new Upload;
            $extension = strtolower($request->file('file')->getClientOriginalExtension());

            if(isset($type[$extension])){
                $upload->file_original_name = null;
                $arr = explode('.', $request->file('file')->getClientOriginalName());
                for($i=0; $i < count($arr)-1; $i++){
                    if($i == 0){
                        $upload->file_original_name .= $arr[$i];
                    }
                    else{
                        $upload->file_original_name .= ".".$arr[$i];
                    }
                }

                //$path = $request->file('aiz_file')->store('uploads/all', 'local');
                $hash = Str::random(40);
                $extension = $request->file('file')->getClientOriginalExtension();



                $size = $request->file('file')->getSize();
                $path = $request->file('file')->move(
                    public_path('uploads/all'), $hash . '.' . $extension
                );
                // Return MIME type ala mimetype extension
                $finfo = finfo_open(FILEINFO_MIME_TYPE);

                // Get the MIME type of the file
                $file_mime = finfo_file($finfo,$path);

                if($type[strtolower($extension)] == 'image'){
                    try {
                        $img = Image::make($request->file('file')->getRealPath())->encode();
                        $height = $img->height();
                        $width = $img->width();
                        if($width > $height && $width > 1500){
                            $img->resize(1500, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }elseif ($height > 1500) {
                            $img->resize(null, 800, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }
                        $img->save(base_path('public/').$path);
                        clearstatcache();
                        $size = $img->filesize();

                    } catch (\Exception $e) {
                        //dd($e);
                    }
                }

                if (env('FILESYSTEM_DRIVER') == 's3') {
                    Storage::disk('s3')->put(
                        $path,
                        file_get_contents(base_path('public/').$path),
                        [
                            'visibility' => 'public',
                            'ContentType' =>  $extension == 'svg' ? 'image/svg+xml' : $file_mime
                        ]
                    );
                    if($arr[0] != 'updates') {
                        unlink(base_path('public/').$path);
                    }
                }

                $upload->extension = $extension;
                $upload->file_name = $hash . '.' . $extension;
                $upload->user_id = Auth::user()->id;
                $upload->type = $type[strtolower($upload->extension)];
                $upload->file_size = $size;
                $upload->save();
            }
            return $upload;
        }
    }


    public function getUploadedFile(Request $request) {
        $uploads = Upload::orderBy('id', 'DESC')->where('user_id', Auth::user()->id);

        if ($request->search != null) {
            $uploads->where('file_original_name', 'like', '%'.$request->search.'%');
        }

        return [
            'files' =>  $uploads->get()
        ];
    }

    public function getUploadedAssetsId(Request $request) {
        return Upload::where('type', '!=', 'image')->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->first()->id;
    }

    public function get_filemanager(Request $request)
    {
        $uploads = Upload::orderBy('id', 'DESC')->where('user_id', Auth::user()->id);
        if ($request->search != null) {
            $uploads->where('file_original_name', 'like', '%'.$request->search.'%');
        }
        if ($request->sort != null) {
            switch ($request->sort) {
                case 'newest':
                    $uploads->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $uploads->orderBy('created_at', 'asc');
                    break;
                case 'smallest':
                    $uploads->orderBy('file_size', 'asc');
                    break;
                case 'largest':
                    $uploads->orderBy('file_size', 'desc');
                    break;
                default:
                    $uploads->orderBy('created_at', 'desc');
                    break;
            }
        }
        if($request->selected)
        {
            $selections = explode(",", $request->seleted);
        }
        else
        {
            $selections = [];
        }
        $product = $request->is_product ? true : false;
        $model = $request->is_model ? true : false;
        $asset = $request->is_asset ? true : false;
        return (string) view('backend.filemanager.partials.modals.call-manager', [
            'files' =>  $uploads->paginate(60)->appends(request()->query()),
            'is_product' => $product,
            'is_asset' => $asset,
            'is_model' => $model,
            'selected' => explode(",", $request->seleted)
        ]);
    }

    public function destroy(Request $request,$id)
    {
        $upload = Upload::findOrFail($id);

        if(auth()->user()->user_type == 'seller' && $upload->user_id != auth()->user()->id){
            flash(translate("You don't have permission for deleting this!"))->error();
            return back();
        }
        try{
            if(env('FILESYSTEM_DRIVER') == 's3'){
                Storage::disk('s3')->delete($upload->file_name);
                if (file_exists(public_path().'/'.$upload->file_name)) {
                    unlink(public_path().'/'.$upload->file_name);
                }
            }
            else{
                unlink(public_path().'/'.$upload->file_name);
            }
            $upload->delete();
            flash(translate('File deleted successfully'))->success();
        }
        catch(\Exception $e){
            $upload->delete();
            flash(translate('File deleted successfully'))->success();
        }
        return back();
    }

    public function get_preview_files(Request $request){
        $ids = explode(',', $request->ids);
        $files = Upload::whereIn('id', $ids)->get();
        return $files;
    }

    //Download project attachment
    public function attachment_download($id)
    {
        $project_attachment = Upload::find($id);

        try{
           $file_path = public_path($project_attachment->file_name);
            return Response::download($file_path);
        }catch(\Exception $e){
            flash(translate('File does not exist!'))->error();
            return back();
        }

    }
    public function downloadFile($id)
    {
        $project_attachment = Upload::find(base64_decode($id));
        try{
            $file_path = public_path("uploads/all/".$project_attachment->file_name);
            return Response::download($file_path);
        }catch(\Exception $e){
            return back();
        }

    }
    //Download project attachment
    public function file_info(Request $request)
    {
        $file = Upload::findOrFail($request['id']);

        return (auth()->user()->user_type == 'seller')
            ? view('frontend.user.seller.uploads.info',compact('file'))
            : view('backend.filemanager.info',compact('file'));
    }

}
