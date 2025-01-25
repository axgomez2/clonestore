<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\VinylMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Primeiro, vamos contar quantos VinylMasters existem
        $totalVinyls = VinylMaster::count();

        // Agora, vamos contar quantos têm um produto associado
        $vinylsWithProduct = VinylMaster::whereHas('product')->count();

        // Vamos pegar alguns VinylMasters para debug
        $sampleVinyls = VinylMaster::take(5)->get();

        // Agora vamos buscar os produtos relacionados a esses VinylMasters
        $relatedProducts = Product::whereIn('productable_id', $sampleVinyls->pluck('id'))
            ->where('productable_type', VinylMaster::class)
            ->get();

        // Finalmente, vamos buscar os vinis para exibição
        $latestVinyls = VinylMaster::with(['artists', 'recordLabel', 'vinylSec', 'product'])
            ->whereHas('vinylSec')
            ->whereHas('product')
            ->latest()
            ->take(8)
            ->get();

        // Passamos todas essas informações para a view
        return view('site.index', compact('latestVinyls', 'totalVinyls', 'vinylsWithProduct', 'sampleVinyls', 'relatedProducts'));
    }
}
