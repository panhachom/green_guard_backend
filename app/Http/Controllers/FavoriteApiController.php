<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;

class FavoriteApiController extends Controller

{

    public function checkFavorite(Request $request, Blog $blog)
    {
        if (!User::find($request->user_id)) {
            return response()->json(['success' => false, 'message' => 'user_id is required'], 404);
        }

        // Check if the user has already favorited the blog
        $favorite = $blog->favorites()->where('user_id', $request->user_id)->exists();

        return response()->json(['is_favorite' => $favorite]);
    }
    
    public function favorite(Request $request, Blog $blog)
    {
        if (!User::find($request->user_id)) {
            return response()->json(['success' => false, 'message' => 'user_id is required'], 404);
        }

        // Check if the user has already liked the post
        $favorite = $blog->favorites()->where('user_id', $request->user_id)->first();
        if ($favorite) {
            $blog->favorites()->where('user_id', $request->user_id)->delete();

            return response()->json(['message' => 'Blog is Unliked!'], 200);
        }

        $newFavorite = new Favorite();
        $newFavorite->user_id = $request->user_id;
        $blog->favorites()->save($newFavorite);

        return response()->json(['favorite' => $newFavorite], 201);
    }

    public function listFavorites(Request $request)
    {

        if (!User::find($request->user_id)) {
            return response()->json(['success' => false, 'message' => 'user_id is required'], 404);
        }
        $user = User::find($request->user_id);
        
        // Get all favorite blogs for the user
        $favorites = $user->favorites()->with('blog')->get();

        // Extract blog details from favorites
        $blogList = $favorites->map(function ($favorite) {
            return $favorite->blog;
        });

        return response()->json(['blogs' => $blogList]);
    }
}
