<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Partner;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class LandingPageController extends Controller
{
    public function getLandingPageData(): JsonResponse
    {
        // Etkinlikleri getir
        $events = Event::where('status', 1)
            ->select(['id', 'title', 'slug', 'content', 'author_id','event_paths','status', 'published_at', 'event_type'])
            ->take(3)//ilk 3ü
            ->get();

        $formattedEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'slug' => $event->slug,
                'content' => $event->content,
                'author_id'=> $event->author_id,
                'event_paths' => $event->event_paths,
                'published_at' => $event->published_at,
                'event_type' => $event->event_type,
                'status'=> $event->status,
            ];
        });

        // Blog getir
        $posts = Post::where('status', 1)
        ->select(['id','title','slug','content','image','author_id','published_at','status',])
        ->take(3)//ilk 3ü
        ->get();

        $formattedPosts = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'content' => $post->content,
                'author_id'=> $post->author_id,
                'image' => $post->image,
                'published_at' => $post->published_at,
                'status'=> $post->status,
            ];
        });

        // Partner verilerini getir
        $partners = Partner::where('status', 1)
            ->orderBy('id', 'asc')
            ->select(['id', 'company_name', 'logo_url', 'alt_text', 'status', 'image', 'partner_type'])
            ->get();

        $formattedPartners = $partners->map(function ($partner) {
            return [
                'id' => $partner->id,
                'company_name' => $partner->company_name,
                'logo_url' => $partner->logo_url,
                'alt_text' => $partner->alt_text,
                'partner_type' => $partner->partner_type,
                'status'=> $partner->status,
                'image'=>$partner->image,
            ];
        });

        // Verileri birleştir ve döndür
        return response()->json([
            'partners' => $formattedPartners,
            'events' => $formattedEvents,
            'posts'=> $formattedPosts,
        ]);
    }
}
