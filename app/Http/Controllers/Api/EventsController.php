<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Event;

class EventsController extends Controller
{
    public function getLittleEventsData(): JsonResponse
    {
        // Etkinlikleri getir
        $events = Event::where('status', 1)
            ->orderBy('published_at', 'desc')
            ->select(['id', 'title', 'slug', 'content', 'event_paths', 'published_at', 'event_type'])
            ->take(3) // İlk 3 etkinlik
            ->get();

        $formattedEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'slug' => $event->slug,
                'content' => $event->content,
                'event_paths' => json_decode($event->event_paths, true), // JSON array formatı
                'published_at' => $event->published_at,
                'event_type' => $event->event_type,
            ];
        });

        return response()->json(['events' => $formattedEvents]);
    }

    public function getAllEventsData(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 9);

        // Etkinlikleri getir
        $events = Event::where('status', 1)
            ->select(['id', 'title', 'slug', 'content', 'author_id', 'event_paths', 'status', 'published_at', 'event_type'])
            ->paginate($perPage);

        $formattedEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'slug' => $event->slug,
                'content' => $event->content,
                'author_id' => $event->author_id,
                'event_paths' => json_decode($event->event_paths, true), // JSON array formatı
                'published_at' => $event->published_at,
                'event_type' => $event->event_type,
                'status' => $event->status,
            ];
        });

        return response()->json([
            'events' => $formattedEvents,
            'pagination' => [
                'total' => $events->total(),
                'current_page' => $events->currentPage(),
                'per_page' => $events->perPage(),
                'last_page' => $events->lastPage(),
                'from' => $events->firstItem(),
                'to' => $events->lastItem(),
            ]
        ]);
    }

    public function getOneEventData($slug): JsonResponse
    {
        // Etkinliği slug'a göre getir
        $event = Event::where('status', 1)
            ->where('slug', $slug)
            ->select(['id', 'title', 'slug', 'content', 'author_id', 'event_paths', 'status', 'published_at', 'event_type'])
            ->first();

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $formattedEvent = [
            'id' => $event->id,
            'title' => $event->title,
            'slug' => $event->slug,
            'content' => $event->content,
            'author_id' => $event->author_id,
            'event_paths' => json_decode($event->event_paths, true), // JSON array formatı
            'published_at' => $event->published_at,
            'event_type' => $event->event_type,
            'status' => $event->status,
        ];

        return response()->json(['post' => $formattedEvent]);
    }
}
