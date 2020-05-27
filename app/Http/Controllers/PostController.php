<?php

namespace App\Http\Controllers;

use App\Post;
use App\Image;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

// CONTROLLER FUNCTIONS => POLICY FUNCTIONS MAPPING
// https://laravel.com/docs/7.x/authorization#via-controller-helpers
// [
//     'index' => 'viewAny',
//     'show' => 'view',
//     'create' => 'create',
//     'store' => 'create',
//     'edit' => 'update',
//     'update' => 'update',
//     'destroy' => 'delete',
// ]

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
            //->except('');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // CACHING 
        $mostCommented = Cache::remember('mostCommented', now()->addHours(1), function(){
            return Post::mostCommented()->take(5)->get();
        });

        //return view('posts.index', ['posts' => Post::all()]);
        //comments_count included for every post
        //latest() is scopeLatest defined in Model
        return view('posts.index', [
        //    'posts' => Post::withCount('comments')->get()
            'posts' => Post::latest()->withCount('comments')->get(),

            // USE with('{modelRelation}') for each relationship 
            // (if you are calling them in the view) to minimize DB calls
            //'posts' => Post::latest()
                // ->withCount('comments')
                // ->with('user')
                // ->with('tags')
                // ->get(),

            //'mostCommented' => Post::mostCommented()->take(5)->get(),
            //'mostActive' => User::withMostPosts()->take(5)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // AUTHORIZATION USING POLICY
        // $this->authorize('posts.create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //public function store(Request $request)
    public function store(StorePost $request)
    {
        // MOVED TO \app\http\requests\StorePost.php
        // $validatedData = $request->validate([
        //     'title' => 'bail|min:5|required|max:100',
        //     'content' => 'required'
        // ]);
        
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;
        //assumes input names match database fields
        $post = Post::create($validatedData); 

        // $post = new Post();
        // $post->title = $request->input('title');
        // $post->content = $request->input('content');
        // $post->save();
        
        // FILE STORAGE
        // if($request->hasFile('thumbnail')){
        //     $file = $request->file('thumbnail');

        //     $file->store('thumbnails');
        //     Storage::disk('public')->putFile('thumbnails', $file);
        //     $name1 = $file->storeAs('thumbnails', $post->id . '.' . $file->guessExtension());
        //     $name2 = Storage::putFileAs('thumbnails', $file, $post->id . '.' . $file->guessExtension());

        //     Storage::url($name1);
        //     Storage::disk('public')->url($name2);
        //     $fileName = $request->file('thumbnail')->store('thumbnails');
        //     $post->image()->save(
        //         Image::make(['path' => $fileName])
        //     );
        // }
        
        //FLASH MESSAGE
        $request->session()->flash('status', 'Post created!');

        //return redirect()->route('posts.index');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //SHOW FLASH ADDITIONAL TIME
        //$request->sesion()->reflash();

        // return view('posts.show', [
        //     'post' => Post::findOrFail($id)
        // ]);

        // return view('posts.show', [
        //     'post' => Post::with('comments')->findOrFail($id)
        // ]);

        // CACHING POST
        // $post = Cache::remember("post-{$id}", 60, function () use ($id) {
        //     return Post::with(['comments' => function ($query){
        //         return $query->latest();
        //     }])->with('user')->with('tags')->findOrFail($id);
        // });

        // USING LOCAL QUERY SCOPE scopeLatest() on COMMENTS MODEL
        return view('posts.show', [
            'post' => Post::with(['comments' => function ($query){
                return $query->latest();
            }])->findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        // AUTHORIZE is equivalent to Gate
        // As long as the Gate is defined in AUTHSERVICEPROVIDER
        $this->authorize('update-post', $post);

        // if(Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit posts you didn't create!");
        // };

        // GATE DEFINED IN APP\PROVIDERS\AUTHSERVICEPROVIDER boot()
        // Gate::define('update-post', function($user, $post) {
        //     return $user->id == $post->user_id;
        // });

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = Post::findOrFail($id);

        if(Gate::denies('update-post', $post)) {
            abort(403, "You can't edit posts you didn't create!");
        };

        $validatedData = $request->validated();
        $post->fill($validatedData);

        if($request->hasFile('thumbnail'))
        {
            $fileName = $request->file('thumbnail')->store('thumbnails');
            if($post->image)
            {
                Storage::delete($post->image->path);
                $post->image->path = $fileName;
                $post->image->save();
            } else {
                $post->image()->save(
                    Image::make(['path' => $fileName])
                );
            }
        }
        

        $post->save();

        //FLASH MESSAGE
        $request->session()->flash('status', 'Post updated!');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if(Gate::denies('delete-post', $post)) {
            abort(403, "You can't delete posts you didn't create!");
        };

        $post->delete();
        //Post::destroy($id);

        //FLASH MESSAGE
        $request->session()->flash('status', 'Post Deleted!');
        return redirect()->route('posts.index');
    }
}
