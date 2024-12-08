<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Partner;
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

        // Partner verilerini getir
        $partners = Partner::where('status', 1)
            ->orderBy('id', 'asc')
            ->select(['id', 'company_name', 'logo_url', 'alt_text', 'status', 'image', 'partner_type'])
            ->take(6) //ilk 6
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
            'events' => $formattedEvents,
            'partners' => $formattedPartners,
        ]);
    }
}
