<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\JsonResponse;

class AboutController extends Controller
{
    public function getAbout(): JsonResponse
    {
        // Hakkımızda bilgilerini getir (En son yayımlanan)
        $about = About::orderBy('created_at', 'desc')->first();

        return response()->json([
            'about' => $about,
        ]);
    }
}
