<?php

namespace App\Http\Controllers\Admin;
use App\post;
use App\Category;
use App\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    protected $validate = [
        'title'=>'required|string|max:300',
        'content'=>'required|max:2000',
        'img'=>'nullable|image|mimes:jpg,png,jpeg',
        'category'=>'nullable',
        'tags'=>'nullable|exists:tags,id'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validate);
        $data = $request->all();
        if (isset($data['img'])) {
            $img_path = Storage::put('uploads',$data ['img']);
            $data['img'] = $img_path;
        };
        //slug restituisce una URL più leggibile sostituendo gli spazi con dei '-'
        $slug = Str::slug($data['title']);
        //controllo di slug
        $single = 1;
        while (post::where('slug', $slug)->first()){
             $slug = Str::slug($data['title']).'-'.$single;
             $single ++;
        }
        $data['slug']=$slug;
        $newPost = new post();
        $newPost->fill($data);
        $newPost->save();
        $newPost ->tags()->sync(isset($data['tags'])? $data['tags']:[]);
        return redirect()->route('admin.posts.show', $newPost->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(post $post)
    {
        $categories = Category::all();
        $tags= Tag::all();
        return view('admin.posts.edit', compact('post','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, post $post)
    {
        $request->validate($this->validate);
        $data = $request->all();
        if ($post->tilte == $data['title']){
            $slug= $post->slug;
        }else{
            //slug restituisce una URL più leggibile sostituendo gli spazi con dei '-'
        $slug = Str::slug($data['title']);
        //controllo di slug
        $single = 1;
        while (post::where('slug', $slug)->where('id', '!=' , '$post->id')->first()){
             $slug = Str::slug($data['title']).'-'.$single;
             $single ++;
        }
        }
        $data['slug']=$slug;
        $post->update($data);
        $post->tags()->sync(isset($data['tags']) ? $data['tags'] : [] );
        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
