<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Contracts\Services\Post\PostServiceInterface;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{   

    private $postInterface;

    public function __construct(PostServiceInterface $postInterface){

        $this->postInterface = $postInterface;
    }

    public function detail(){
        $postList = $this->postInterface->getPostList();
        return view('posts.post-list',[
            'posts' => $postList
        ]);
    }

    public function create( ){
        return view('posts.create-post');
    }

    public function insert(Request $request){
       
        $this->postInterface->insertPost($request);
        return redirect('/posts');

    }

    public function delete($id){
       
        $this->postInterface->deletePost($id);
        return redirect('/posts');

    }

    public function add( ){
        return view('posts.add-post');
    }

    public function confirmPost(Request $request){

        $validator = validator(request()->all(),[
            'title' =>'required',
            'description' => 'required',
        ]);
        
        if($validator->fails()){
            return back()->withErrors($validator);
        }

        return view('posts.create-post-confirmation',[
            'posts' => $request
        ]);
    }

    public function update(){
        return view('posts.update-post');
    }
}
