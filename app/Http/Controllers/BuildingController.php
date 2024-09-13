<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\BuildingType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Exceptions\Exception;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws Exception
     * @throws \Exception
     */
    public function index()
    {

        if (\request()->ajax()) {
            $data = Building::query()->with('buildingType');
            return datatables()->eloquent($data)
                ->addColumn('action', function (Building $building) {
                    return view('buildings.action', compact('building'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $buildingTypes = BuildingType::all();
        return view('buildings.index', compact('buildingTypes'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => ['nullable'],
            'name' => ['required'],
            'building_type_id' => ['required', 'exists:building_types,id'],
            'floors' => ['nullable', 'numeric'],
            'rooms' => ['nullable', 'numeric'],
            'address' => ['required'],
            'intended_use' => ['required'],
            'description' => ['nullable'],
            'status' => ['required'],
        ]);

        if (!$data['id']) {
            $data['slug'] = Str::slug($data['name'] . '-' . Str::random(5));
        }

        Building::query()->updateOrCreate(['id' => $data['id']], $data);

        return response()->json(['success' => 'Building saved successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building)
    {
        $building->load('buildingType');
        return response()->json($building);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building)
    {
        $building->delete();
        return response()->json(['success' => 'Building deleted successfully']);
    }
}
