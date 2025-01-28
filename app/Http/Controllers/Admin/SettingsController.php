<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Weight;
use App\Models\Dimension;
use App\Models\Brand;
use App\Models\EquipmentCategory;

class SettingsController extends Controller
{
    public function index()
    {
        $weights = Weight::all();
        $dimensions = Dimension::all();
        $brands = Brand::all();
        $equipmentCategories = EquipmentCategory::all();

        return view('admin.settings.index', compact('weights', 'dimensions', 'brands', 'equipmentCategories'));
    }

    public function storeWeight(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|numeric',
            'unit' => 'required|string|max:50',
        ]);

        Weight::create($validatedData);

        return redirect()->route('admin.settings.index')->with('success', 'Weight added successfully.');
    }

    public function storeDimension(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'height' => 'required|numeric',
            'width' => 'required|numeric',
            'depth' => 'required|numeric',
            'unit' => 'required|string|max:50',
        ]);

        Dimension::create($validatedData);

        return redirect()->route('admin.settings.index')->with('success', 'Dimension added successfully.');
    }

    public function storeBrand(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        Brand::create($validatedData);

        return redirect()->route('admin.settings.index')->with('success', 'Brand added successfully.');
    }

    public function storeEquipmentCategory(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:equipment_categories,id',
            'description' => 'nullable|string',
        ]);

        EquipmentCategory::create($validatedData);

        return redirect()->route('admin.settings.index')->with('success', 'Equipment Category added successfully.');
    }
}
