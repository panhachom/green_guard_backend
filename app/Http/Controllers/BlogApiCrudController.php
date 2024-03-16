<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeRequest;
use App\Models\Blog;
use App\Models\ImageFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogApiCrudController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('images')->get();
        return response()->json([
            'blogs' => $blogs,
        ], 200);
    }

    public function show($idOrTitle) {
        // Check if the provided parameter is numeric (ID) or a string (title)
        if (is_numeric($idOrTitle)) {
            $blog = Blog::find($idOrTitle);
        } else {
            $blog = Blog::where('title', $idOrTitle)->first();
        }

        // Check if the blog is found
        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        // Retrieve images related to the blog
        $images = ImageFile::where('parent_id', $blog->id)
                            ->where('parent_type', 'App\Models\Blog')
                            ->get();

        // Return the blog and its images
        return response()->json([
            'blog' => $blog,
            'images' => $images
        ], 200);
    }

    public function store(Request $request, $id = null)
    {
        $params = request()->all();

        if (!$request->user_id) {
            return response()->json(['success' => false, 'message' => 'user_id is required!']);
        }
        if (!User::find($request->user_id)) {
            return response()->json(['success' => false, 'message' => 'User not found!']);
        }

        if($id){
            $blog = Blog::where('id', $id)->first();
            $blog->title        = $params['title'];
            $blog->sub_title    = $params['sub_title'];
            $blog->status       = 0;
            $blog->body         = $params['body'];
            $blog->update();
            if(isset($params['images'])){
                foreach ($params['images'] as $image){
                    $imageName = $image->getClientOriginalName();
                    $imagePath = $image->store('images', 'public');
                    $imageUrl = Storage::disk('public')->url($imagePath);

                    ImageFile::create([
                        'parent_id' => $params['id'],
                        'parent_type' => 'App\Models\Blog',
                        'file_name' => $imageName,
                        'file_path' => $imagePath,
                        'file_url' => $imageUrl,
                    ]);
                }
            }
        }

        $blog = new Blog([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'sub_title' => $request->input('sub_title'),
            'status' => $request->input('status'),
            'user_id' => $request->input('user_id'),
        ]);

        $blog->save();

        foreach ($request->file('images') as $image) {

            $imageName = $image->getClientOriginalName();
            $imagePath = $image->store('images', 'public');
            $imageUrl = Storage::disk('public')->url($imagePath);
            // dd($image);
            ImageFile::create([
                'parent_id' => $blog->id,
                'parent_type' => 'App\Models\Blog',
                'file_name' => $imageName,
                'file_path' => $imagePath,
                'file_url' => $imageUrl,
            ]);
        }


        // Return success response
        return response()->json(['message' => 'Blog created successfully'], 201);
    }

    public function uploadImages(){

    }



}
