<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Post;

class PostsController extends Controller
{
    public function getLittlePostsData(): JsonResponse
    {
        // Son 3 blog yazısını getir
        $posts = Post::where('status', 1)
            ->orderBy('published_at', 'desc') // Yayınlanma tarihine göre azalan sırayla sıralıyoruz
            ->select(['id', 'title', 'slug', 'content', 'image', 'author_id', 'published_at', 'status'])
            ->take(3) // İlk 3 yazıyı alıyoruz
            ->get();

        $formattedPosts = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'content' => $post->content,
                'image' => $post->image,
                'author_id' => $post->author_id,
                'published_at' => $post->published_at,
                'status' => $post->status,
            ];
        });

        return response()->json([
            'posts' => $formattedPosts,
        ]);
    }

    public function getAllPostsData(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 9);
        $posts = Post::where('status', 1)
            ->select(['id', 'title', 'slug', 'content', 'image', 'author_id', 'published_at', 'status'])
            ->paginate($perPage);

        // Sayfalanmış sonuçları düzenle
        $formattedPosts = $posts->getCollection()->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'content' => $post->content,
                'image' => $post->image,
                'author_id' => $post->author_id,
                'published_at' => $post->published_at,
                'status' => $post->status,
            ];
        });

        return response()->json([
            'posts' => $formattedPosts,
            'pagination' => [
                'total' => $posts->total(),
                'current_page' => $posts->currentPage(),
                'per_page' => $posts->perPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem(),
            ]
        ]);
    }

    public function getOnePostData($slug): JsonResponse
    {
        // Sluga göre tek bir blog yazısını getir
        $post = Post::where('status', 1)
            ->where('slug', $slug)
            ->select(['id', 'title', 'slug', 'content', 'image', 'author_id', 'published_at', 'status'])
            ->first();

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $formattedPost = [
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'content' => $post->content,
            'image' => $post->image,
            'author_id' => $post->author_id,
            'published_at' => $post->published_at,
            'status' => $post->status,
        ];

        return response()->json(['post' => $formattedPost]);
    }


}
