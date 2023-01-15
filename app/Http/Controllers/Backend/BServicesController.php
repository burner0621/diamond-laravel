<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\ServicePackageRequest;
use App\Models\ServiceCategorie;
use App\Models\ServicePackage;
use App\Models\ServicePost;
use App\Models\ServicePostCategorie;
use App\Models\ServicePostTag;
use App\Models\ServiceTags;
use Auth;
use Illuminate\Http\Request;

class BServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.service.services.list', [
            'services' => ServicePost::where('status', '!=', 4)->with(['categories', 'postauthor'])->orderBy('id', 'DESC')->get(),
        ]);
    }

    public function archive()
    {
        return view('backend.service.services.archive', [
            'services' => ServicePost::where('status', 4)->orderBy('id', 'DESC')->get(),
        ]);
    }

    public function get()
    {
        return datatables()->of(ServicePost::query())
            ->addIndexColumn()
            ->editColumn('cover_image', function ($row) {
                return "<img src='" . $row->cover_image . "'>";
            })
            ->addColumn('action', function ($row) {

                $btn = '<a href="' . route('backend.services.edit', $row->id) . '"  class="edit btn btn-info btn-sm">Edit</a>';
                $btn = $btn . '<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Delete</a>';

                return $btn;
            })
            ->rawColumns(['action', 'cover_image'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $step
     * @return \Illuminate\Http\Response
     */
    public function create($step = 0, $post_id = 0)
    {
        // $step = 1;
        return view('backend.service.services.create', [
            'categories' => ServiceCategorie::all(),
            'tags' => ServiceTags::all(),
            'step' => $step,
            'post_id' => $post_id,
        ]);
    }

    private function generateSlug($string)
    {
        return str_replace(' ', '-', $string);
    }

    private function registerNewTag($tag)
    {
        $servicetag = ServiceTags::create([
            'name' => $tag,
            'slug' => $this->slugify($tag),
        ]);
        return $servicetag->id;
    }
    public function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {
        $slug_count = ServicePost::whereName($request->name)->count();
        $step = $request->step + 1;
        $suffix = ($slug_count == 0) ? '' : '-' . (string) $slug_count + 1;
        $tags = (array) $request->input('tags');
        $categories = (array) $request->input('categories');
        $service = new ServicePost();
        $data = $request->input();
        $data['user_id'] = Auth::id();

        if (ServicePost::where('slug', $this->slugify($request->name))->count()) {
            $data['slug'] = $this->slugify($request->name) . "-1";
        } else {
            $data['slug'] = $this->slugify($request->name);
        }

        $post_id = $service->create($data)->id;
        foreach ($tags as $tag) {
            $id_tag = (!is_numeric($tag)) ? $this->registerNewTag($tag) : $tag;
            ServicePostTag::create([
                'id_tag' => $id_tag,
                'id_service' => $post_id,
            ]);

        }

        foreach ($categories as $categorie) {
            ServicePostCategorie::create([
                'id_category' => $categorie,
                'id_post' => $post_id,
            ]);
        }

        return redirect()->route('backend.services.create', ['step' => $step, 'post_id' => $post_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function package(ServicePackageRequest $request)
    {
        $servicepackage = new ServicePackage();
        $data = $request->input();
        $step = $data['step'] + 1;
        $post_id = $data['service_id'];
        $names = $request->input('name');

        for ($i = 0; $i < count($names); $i++) {
            if ($names[$i]) {
                $temp['name'] = $data['name'][$i];
                $temp['service_id'] = $data['service_id'];
                $temp['description'] = $data['description'][$i];
                $temp['price'] = $data['price'][$i];
                $temp['revisions'] = $data['revisions'][$i];
                $temp['delivery_time'] = $data['delivery_time'][$i];
                $servicepackage->create($temp);
            }
        }

        return redirect()->route('backend.services.create', ['step' => $step, 'post_id' => $post_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('backend.service.services.edit', [
            'service' => ServicePost::whereId($id)->with(['tags', 'categories', 'uploads', 'postauthor'])->firstOrFail(),
            'categories' => ServiceCategorie::all(),
            'tags' => ServiceTags::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostStoreRequest $request, $id)
    {
        $slug_count = ServicePost::whereName($request->name)->count();
        $suffix = ($slug_count == 0) ? '' : '-' . (string) $slug_count + 1;

        $tags = (array) $request->input('tags');
        $categories = (array) $request->input('categories');

        $service = ServicePost::findOrFail($id);
        $data = $request->input();
        $data['user_id'] = Auth::id();
        $slug = $request->slug;

        if ($slug == '') {
            $slug = $request->name;
        }

        if (ServicePost::where('id', '!=', $id)->where('slug', $this->slugify($slug))->count()) {
            $data['slug'] = $this->slugify($slug) . "-1";
        } else {
            $data['slug'] = $this->slugify($slug);
        }

        $service->name = $data['name'];
        $service->slug = $data['slug'];
        $service->status = $data['status'];
        $service->thumbnail = $data['thumbnail'];
        $service->published_at = date('Y-m-d H:i:s');

        $service->update();

        ServicePostTag::where('id_service', $service->id)->delete();
        ServicePostCategorie::where('id_post', $service->id)->delete();

        foreach ($tags as $tag) {
            $id_tag = (!is_numeric($tag)) ? $this->registerNewTag($tag) : $tag;
            ServicePostTag::create([
                'id_tag' => $id_tag,
                'id_post' => $service->id,
            ]);
        }

        foreach ($categories as $categorie) {
            ServicePostCategorie::create([
                'id_category' => $categorie,
                'id_post' => $service->id,
            ]);
        }
        return redirect()->route('backend.services.edit', $service->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = ServicePost::find($id);
        $service->status = 4;
        $service->save();
        return redirect()->route('backend.services.list');

    }

    public function recover($id)
    {
        $service = ServicePost::where('status', 4)->find($id);
        if ($service) {
            $service->status = 3;
            $service->save();
        }
        return redirect()->route('backend.services.archive');
    }
}
