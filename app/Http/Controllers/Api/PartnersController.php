<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Partner;

class PartnersController extends Controller
{
    public function getLittlePartnersData(): JsonResponse
    {
        // İlk 3 partneri getir
        $partners = Partner::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->select(['id', 'company_name', 'logo_url', 'alt_text', 'partner_type', 'image', 'status'])
            ->take(3) // İlk 3 partner
            ->get();

        $formattedPartners = $partners->map(function ($partner) {
            return [
                'id' => $partner->id,
                'company_name' => $partner->company_name,
                'logo_url' => $partner->logo_url,
                'alt_text' => $partner->alt_text,
                'partner_type' => $partner->partner_type,
                'image' => $partner->image,
                'status' => $partner->status,
            ];
        });

        return response()->json([
            'partners' => $formattedPartners,
        ]);
    }

    public function getAllPartnersData(): JsonResponse
    {
        // Tüm partnerleri getir
        $partners = Partner::where('status', 1)
            ->select(['id', 'company_name', 'logo_url', 'alt_text', 'partner_type', 'image', 'status'])
            ->get();

        $formattedPartners = $partners->map(function ($partner) {
            return [
                'id' => $partner->id,
                'company_name' => $partner->company_name,
                'logo_url' => $partner->logo_url,
                'alt_text' => $partner->alt_text,
                'partner_type' => $partner->partner_type,
                'image' => $partner->image,
                'status' => $partner->status,
            ];
        });

        return response()->json([
            'partners' => $formattedPartners,
        ]);
    }

    public function getOnePartnerData($id): JsonResponse
    {
        // Belirli bir partneri ID'ye göre getir
        $partner = Partner::where('status', 1)
            ->where('id', $id)
            ->select(['id', 'company_name', 'logo_url', 'alt_text', 'partner_type', 'image', 'status'])
            ->first();

        if (!$partner) {
            return response()->json(['message' => 'Partner not found'], 404);
        }

        $formattedPartner = [
            'id' => $partner->id,
            'company_name' => $partner->company_name,
            'logo_url' => $partner->logo_url,
            'alt_text' => $partner->alt_text,
            'partner_type' => $partner->partner_type,
            'image' => $partner->image,
            'status' => $partner->status,
        ];

        return response()->json(['partner' => $formattedPartner]);
    }
}
