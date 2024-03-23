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
        // Check if user_id is provided
        if (!$request->has('user_id')) {
            return response()->json(['success' => false, 'message' => 'user_id is required'], 404);
        }
    
        // Retrieve the user with the provided user_id
        $user = User::with('favorites.blog.images', 'favorites.blog.user')->find($request->user_id);
    
        // If user not found, return error
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }
    
        // Extract blog details from favorites
        $blogs = $user->favorites->map(function ($favorite) {
            return $favorite->blog;
        });
    
        return response()->json(['blogs' => $blogs]);
    }
    
}
