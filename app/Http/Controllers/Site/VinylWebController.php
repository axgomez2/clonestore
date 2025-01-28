<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\VinylMaster;
use App\Models\Style;
use App\Models\VinylSec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VinylWebController extends Controller
{
    public function index(Request $request)
    {
        $query = VinylMaster::with(['artists', 'recordLabel', 'vinylSec', 'styles', 'product', 'tracks']);

        // Apply search independently
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('artists', function ($q) use ($searchTerm) {
                      $q->where('name', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        // Apply other filters
        $query = $this->applyFilters($query, $request);

        // Apply sorting
        $query = $this->applySorting($query, $request);

        $vinyls = $query->paginate(20)->appends($request->all());

        // Transform the vinyls to include track information
        $vinyls->getCollection()->transform(function ($vinyl) {
            $vinyl->tracks->transform(function ($track) use ($vinyl) {
                $track->artist = $vinyl->artists->pluck('name')->implode(', ');
                $track->cover_url = $vinyl->cover_image_url;
                return $track;
            });
            return $vinyl;
        });

        $styles = Style::all();

        // Get min and max prices
        $priceRange = VinylSec::selectRaw('MIN(price) as min_price, MAX(price) as max_price')->first();

        return view('site.vinyls.index', compact('vinyls', 'styles', 'priceRange'));
    }

    private function applyFilters($query, $request)
    {
        // Apply style filter
        if ($request->filled('style')) {
            $query->whereHas('styles', function ($q) use ($request) {
                $q->where('name', $request->style);
            });
        }

        // Apply price filter
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereHas('vinylSec', function ($q) use ($request) {
                $q->whereBetween('price', [$request->min_price, $request->max_price]);
            });
        }

        return $query;
    }

    private function applySorting($query, $request)
    {
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        switch ($sortBy) {
            case 'price':
                $query->join('vinyl_secs', 'vinyl_masters.id', '=', 'vinyl_secs.vinyl_master_id')
                      ->orderBy('vinyl_secs.price', $sortOrder);
                break;
            case 'release_year':
                $query->orderBy('release_year', $sortOrder);
                break;
            case 'title':
                $query->orderBy('title', $sortOrder);
                break;
            default:
                $query->orderBy('created_at', $sortOrder);
                break;
        }

        return $query;
    }
}