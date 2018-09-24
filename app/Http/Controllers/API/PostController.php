<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;

class PostController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $success['posts'] = Post::where('title', 'like', '%' . $request->search . '%')->get();
        return response()->json(['success'=>$success], $this->successStatus);
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
        $request->validate([
            'title'     =>  'required|max:100',
            'content'   =>  'required|max:500'
        ]);

        $post = new Post;
        $success['posts'] = $post->create($request->all());

        return response()->json(['success'=>$success], $this->successStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $success['posts'] = Post::find($id);
        return response()->json(['success'=>$success], $this->successStatus);
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
        $request->validate([
            'title'     =>  'max:100',
            'content'   =>  'max:500'
        ]);

        $post = Post::find($id);

        if (empty($post)) {
            return response()->json([
                'message'   =>  'No data is found',
                'errors'    =>  [
                    'posts' =>  $post
                ]
            ]);
        }
        $post->update($request->all());
        $success['posts'] = $post;

        return response()->json(['success'=>$success], $this->successStatus);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if (empty($post)) {
            return response()->json([
                'message'   =>  'No data is found',
                'errors'    =>  [
                    'posts' =>  $post
                ]
            ]);
        }

        $post->delete();

        return response()->json(['success'=>'The post is deleted']);
    }
}
