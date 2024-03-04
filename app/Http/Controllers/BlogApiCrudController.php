<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\ImageFile;
use Illuminate\Http\Request;

class BlogApiCrudController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('images')->get();
        return response()->json([
            'blogs' => $blogs,
        ], 200);
    }

    // public function show($id){

    //     $blog = Blog::find($id);
    //     if(!$blog ){
    //         return response()->json(['message' => 'Blog not found'], 404);
    //     }
    //     $images = ImageFile::where('parent_id',$blog->id)->where('parent_type','App\Models\Blog')->get();

    //     return response()->json([
    //         'blog' => $blog,
    //         'images' => $images
    //     ], 200);
    // }

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
    

}
