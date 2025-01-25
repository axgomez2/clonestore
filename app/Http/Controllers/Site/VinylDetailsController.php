<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\VinylMaster;
use Illuminate\Http\Request;

class VinylDetailsController extends Controller
{
    public function show($artistSlug, $titleSlug)
    {
        $vinyl = VinylMaster::whereHas('artists', function ($query) use ($artistSlug) {
                $query->where('slug', $artistSlug);
            })
            ->where('slug', $titleSlug)
            ->with(['artists', 'recordLabel', 'vinylSec', 'genres', 'tracks'])
            ->firstOrFail();

        return view('site.vinyls.details', compact('vinyl'));
    }


}
