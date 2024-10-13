<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PersonExport;
use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Models\HouseCondition;
use App\Models\Village;
use App\Models\Work;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PersonController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('view person'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('create person'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('edit person'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete person'), only: ['destroy']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('export person'), only: ['export']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $persons = Person::with('village')->latest()->get();
            return DataTables::of($persons)
                ->addIndexColumn()
                ->addColumn('gender', function ($row) {
                    return  $row->gender();
                })
                ->addColumn('income_month', function ($row) {
                    return 'Rp ' . number_format($row->income_month, 0, ',', '.');
                })
                ->addColumn('village', function ($row) {
                    return $row->village ? $row->village->name : '-';
                })
                // ->addColumn('work', function ($row) {
                //     return $row->work ? $row->work->name : '-';
                // })
                ->addColumn('action', 'admin.person.include.action')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.person.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $villages = Village::latest()->get();
        // $works = Work::latest()->get();
        return view('admin.person.create', compact('villages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonRequest $request)
    {
        try {
            DB::beginTransaction();

            $attr = $request->validated();

            $person = Person::create($attr);

            HouseCondition::create([
                'person_id' => $person->id,  // Menghubungkan dengan ID dari person yang baru dibuat
                'house_type' => $request->house_type,
                'building_area' => $request->building_area,
                'floor_material' => $request->floor_material,
                'wall_material' => $request->wall_material,
                'electricity_source' => $request->electricity_source,
                'electricity_capacity' => $request->electricity_capacity,
                'water_source' => $request->water_source,
                'cooking_fuel' => $request->cooking_fuel,
                'sanitation_facility' => $request->sanitation_facility,
            ]);

            DB::commit();

            return redirect()->route('admin.person.index')->with('success', 'Data berhasil ditambah');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->route('admin.person.index')->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Person $person)
    {
        $villages = Village::latest()->get();
        // $works = Work::latest()->get();
        return view('admin.person.edit', compact('person', 'villages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonRequest $request, Person $person)
    {
        try {
            DB::beginTransaction();

            $attr = $request->validated();

            $person->update($attr);

            $houseCondition = HouseCondition::where('person_id', $person->id)->first();

            $houseCondition->update([
                'building_area' => $request->building_area,
                'floor_material' => $request->floor_material,
                'wall_material' => $request->wall_material,
                'electricity_source' => $request->electricity_source,
                'electricity_capacity' => $request->electricity_capacity,
                'water_source' => $request->water_source,
                'cooking_fuel' => $request->cooking_fuel,
                'sanitation_facility' => $request->sanitation_facility,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.person.index')
                ->with('success', __('Data Berhasil Diubah'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()
                ->route('admin.person.index')
                ->with('error', __($th->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        try {

            // Mulai transaksi
            DB::beginTransaction();

            // Hapus data di tabel HouseCondition terlebih dahulu
            $houseCondition = HouseCondition::where('person_id', $person->id)->first();

            if ($houseCondition) {
                $houseCondition->delete();
            }

            $person->delete();

            DB::commit();

            return redirect()
                ->route('admin.person.index')
                ->with('success', __('Data Berhasil Dihapus'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()
                ->route('admin.person.index')
                ->with('error', __($th->getMessage()));
        }
    }

    public function exportAll()
    {
        return (new PersonExport(false, 'Data Kependudukan'))->download('Data Kependudukan.xlsx');
    }

    public function exportLowIncome()
    {
        return (new PersonExport(true, 'Data Masyarakat Kurang Mampu'))->download('Data Masyarakat Kurang Mampu.xlsx');
    }
}
