<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\VinylMaster;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Style;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\RecordLabel;
use App\Models\Track;
use App\Models\Weight;
use App\Models\Dimension;
use App\Models\VinylSec;
use App\Models\Media;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

use Illuminate\Support\Facades\Log;

class VinylController extends Controller
{
    public function index()
    {
        $vinyls = VinylMaster::with(['artists', 'genres', 'recordLabel', 'vinylSec'])
                            ->orderBy('created_at', 'desc')
                            ->paginate(30);
        return view('admin.vinyls.index', compact('vinyls'));
    }

    public function show($id)
    {
        $vinyl = VinylMaster::with(['artists', 'genres', 'styles', 'recordLabel', 'tracks'])
                            ->findOrFail($id);
        return view('admin.vinyls.show', compact('vinyl'));
    }

    public function edit($id)
    {
        $vinyl = VinylMaster::with(['artists', 'genres', 'styles', 'recordLabel', 'tracks'])
                            ->findOrFail($id);
        return view('admin.vinyls.edit', compact('vinyl'));
    }

    public function create(Request $request)
    {
        $searchResults = [];
        $query = $request->input('query');
        $selectedRelease = null;

        if ($query) {
            $searchResults = $this->searchDiscogs($query);
        }

        $releaseId = $request->input('release_id');
        if ($releaseId) {
            $selectedRelease = $this->getDiscogsRelease($releaseId);
        }

        return view('admin.vinyls.create', compact('searchResults', 'query', 'selectedRelease'));
    }

    public function store(Request $request)
    {
        $releaseId = $request->input('release_id');
        $releaseData = $this->getDiscogsRelease($releaseId);

        if (!$releaseData) {
            return response()->json(['status' => 'error', 'message' => 'Failed to fetch release data from Discogs.'], 400);
        }

        // Check if the vinyl is already in the database
        $existingVinyl = VinylMaster::where('discogs_id', $releaseData['id'])->first();
        if ($existingVinyl) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Este disco já está cadastrado.',
                'vinyl_id' => $existingVinyl->id
            ]);
        }

        DB::beginTransaction();

        try {
            $vinylMaster = $this->createOrUpdateVinylMaster($releaseData);
            $this->syncArtists($vinylMaster, $releaseData['artists']);
            $this->syncGenres($vinylMaster, $releaseData['genres']);
            $this->syncStyles($vinylMaster, $releaseData['styles'] ?? []);
            $this->associateRecordLabel($vinylMaster, $releaseData['labels'][0] ?? null);
            $this->createOrUpdateTracks($vinylMaster, $releaseData['tracklist']);
            $this->createOrUpdateProduct($vinylMaster, $releaseData);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Disco salvo com sucesso.',
                'vinyl_id' => $vinylMaster->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saving vinyl data: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while saving the vinyl data: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }



    private function searchDiscogs($query)
    {
        $response = Http::get('https://api.discogs.com/database/search', [
            'q' => $query,
            'type' => 'release',
            'token' => config('services.discogs.token'),
        ]);

        return $response->json()['results'] ?? [];
    }

    private function getDiscogsRelease($releaseId)
    {
        $response = Http::get("https://api.discogs.com/releases/{$releaseId}", [
            'token' => config('services.discogs.token'),
        ]);

        return $response->successful() ? $response->json() : null;
    }

    private function createOrUpdateVinylMaster($releaseData)
    {
        $coverImagePath = null;
        if (!empty($releaseData['images'][0]['uri'])) {
            $coverImageUrl = $releaseData['images'][0]['uri'];
            $coverImageContents = Http::get($coverImageUrl)->body();
            $coverImageName = 'vinyl_covers/' . $releaseData['id'] . '_' . Str::random(10) . '.jpg';
            Storage::disk('public')->put($coverImageName, $coverImageContents);
            $coverImagePath = $coverImageName; // Armazena apenas o caminho relativo
        }



        return VinylMaster::updateOrCreate(
            ['discogs_id' => $releaseData['id']],
            [
                'title' => $releaseData['title'],
                'release_year' => $releaseData['year'],
                'country' => $releaseData['country'],
                'description' => $releaseData['notes'] ?? null,
                'cover_image' => $coverImagePath,
                'discogs_url' => $releaseData['uri'] ?? null,
            ]
        );
    }
    private function syncArtists($vinylMaster, $artists)
    {
        $artistIds = collect($artists)->map(function ($artistData) {
            $artist = Artist::updateOrCreate(
                ['name' => $artistData['name']],
                ['slug' => Str::slug($artistData['name'])]
            );
            return $artist->id;
        });

        $vinylMaster->artists()->sync($artistIds);
    }

    private function syncGenres($vinylMaster, $genres)
    {
        $genreIds = collect($genres)->map(function ($genreName) {
            $genre = Genre::updateOrCreate(
                ['name' => $genreName],
                ['slug' => Str::slug($genreName)]
            );
            return $genre->id;
        });

        $vinylMaster->genres()->sync($genreIds);
    }

    private function syncStyles($vinylMaster, $styles)
    {
        $styleIds = collect($styles)->map(function ($styleName) {
            $style = Style::updateOrCreate(
                ['name' => $styleName],
                ['slug' => Str::slug($styleName)]
            );
            return $style->id;
        });

        $vinylMaster->styles()->sync($styleIds);
    }

    private function associateRecordLabel($vinylMaster, $labelData)
    {
        if ($labelData) {
            $label = RecordLabel::updateOrCreate(
                ['name' => $labelData['name']],
                ['slug' => Str::slug($labelData['name'])]
            );
            $vinylMaster->recordLabel()->associate($label);
            $vinylMaster->save();
        }
    }

    private function createOrUpdateTracks($vinylMaster, $tracklist)
    {
        foreach ($tracklist as $trackData) {
            if (!empty($trackData['title'])) {
                Track::updateOrCreate(
                    [
                        'vinyl_master_id' => $vinylMaster->id,
                        'name' => $trackData['title'],
                    ],
                    [
                        'duration' => $trackData['duration'] ?? null,
                    ]
                );
            }
        }
    }

    private function createOrUpdateProduct($vinylMaster, $releaseData)
    {
        $productType = ProductType::where('slug', 'vinyl')->firstOrFail();

        $product = Product::updateOrCreate(
            [
                'productable_id' => $vinylMaster->id,
                'productable_type' => 'App\\Models\\VinylMaster',
            ],
            [
                'name' => $releaseData['title'],
                'slug' => Str::slug($releaseData['title']),
                'description' => $releaseData['notes'] ?? null,
                'product_type_id' => $productType->id,
            ]
        );



        return $product;
    }

    public function complete($id)
    {
        $vinylMaster = VinylMaster::findOrFail($id);
        $weights = Weight::all();
        $dimensions = Dimension::all();
        $tracks = $vinylMaster->tracks;
        return view('admin.vinyls.complete', compact('vinylMaster', 'weights', 'dimensions', 'tracks'));
    }

    public function storeComplete(Request $request, $id)
    {
        $vinylMaster = VinylMaster::findOrFail($id);

        $validatedData = $request->validate([
            'cover_status' => 'nullable|in:mint,near_mint,very_good,good,fair,poor',
            'midia_status' => 'nullable|in:mint,near_mint,very_good,good,fair,poor',
            'catalog_number' => 'nullable|string',
            'barcode' => 'nullable|string',
            'weight_id' => 'required|exists:weights,id',
            'dimension_id' => 'required|exists:dimensions,id',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'format' => 'nullable|string',
            'num_discs' => 'required|integer|min:1',
            'speed' => 'nullable|string',
            'edition' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_new' => 'required|boolean',
            'buy_price' => 'nullable|numeric|min:0',
            'promotional_price' => 'nullable|numeric|min:0',
            'is_promotional' => 'required|boolean',
            'in_stock' => 'required|boolean',
            'track_youtube_urls' => 'nullable|array',
            'track_youtube_urls.*' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $vinylSec = $vinylMaster->vinylSec ?? new VinylSec();
            $vinylSec->fill($validatedData);
            $vinylMaster->vinylSec()->save($vinylSec);

            $tracks = $vinylMaster->tracks;
            if (isset($validatedData['track_youtube_urls'])) {
                foreach ($validatedData['track_youtube_urls'] as $trackId => $youtubeUrl) {
                    $track = $tracks->find($trackId);
                    if ($track) {
                        $track->youtube_url = $youtubeUrl ?: null;
                        $track->save();
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.vinyls.index')->with('success', 'Vinyl record completed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error completing vinyl record: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return back()->withInput()->with('error', 'An error occurred while completing the vinyl record: ' . $e->getMessage());
        }
    }

    public function destroy($id)
{
    $vinyl = VinylMaster::findOrFail($id);

    try {
        DB::beginTransaction();

        // Delete related records
        $vinyl->artists()->detach();
        $vinyl->genres()->detach();
        $vinyl->styles()->detach();
        $vinyl->tracks()->delete();

        // Delete VinylSec if it exists
        if ($vinyl->vinylSec) {
            $vinyl->vinylSec->delete();
        }

        // Delete associated product if it exists
        if ($vinyl->product) {
            $vinyl->product->delete();
        }

        // Delete cover image if it exists
        if ($vinyl->cover_image) {
            Storage::disk('public')->delete($vinyl->cover_image);
        }

        // Delete any additional images associated with the vinyl
        foreach ($vinyl->media as $media) {
            Storage::disk('public')->delete($media->file_path);
            $media->delete();
        }

        // Finally, delete the vinyl master record
        $vinyl->delete();

        DB::commit();

        return redirect()->route('admin.vinyls.index')->with('success', 'Disco excluído com sucesso.');
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Error deleting vinyl: ' . $e->getMessage());
        return redirect()->route('admin.vinyls.index')->with('error', 'Ocorreu um erro ao excluir o disco. Por favor, tente novamente.');
    }
}
    }





