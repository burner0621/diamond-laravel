<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Upload;
use Illuminate\Support\Facades\Config;

class UriController extends Controller
{
/**
     * Show the page for the given slug.
     *
     * @param  string  $request uri
     * @return Response
     */
    public function __invoke(Request $request)
    {

        $request_path = $request->path();

        // $request_path_array = explode('/', $request_path);
        $page = Page::where('url', $request_path)->first();
        if ($page != NULL) {
            $post = $page->post;

            preg_match('/\[3d_viewer id=\d+\]/', $post, $matches, PREG_OFFSET_CAPTURE);

            if (count($matches)) {
                foreach ($matches as $match) {
                    preg_match('/\d+$/', substr($match[0], 0, strlen($match[0]) - 1), $subMatches, PREG_OFFSET_CAPTURE);
                    $uploadId = $subMatches[0][0];
                    $upload = Upload::find($uploadId);

                    if ($upload) {
                        $post = preg_replace('/\[3d_viewer id=' . $uploadId . '\]/', '<div class="model-box border rounded h-500px p-2"><model-viewer class="model-full-hw" alt="This is CAD Preview"
                        src="' . asset(Config::get('constants.file_upload_path') . '/' . $upload->file_name) . '"
                        ar-scale="auto" poster="assets/img/placeholder.jpg" loading="lazy" ar
                        ar-modes="webxr scene-viewer quick-look" shadow-intensity="0" camera-controls
                        auto-rotate></model-viewer></div>', $post);
                    }
                }
            }

            $page->post = $post;
        }

        if ($page) {
            return view('page')->with('page', $page);
        } else {
            return view('errors.404');
        }
    }
}
