<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AssistanceExport;
use App\Exports\DetailAssistanceExport;
use App\Http\Controllers\Controller;
use App\Models\Assistance;
use App\Models\DetailAssistance;
use App\Http\Requests\StoreDetailAssistanceRequest;
use App\Http\Requests\UpdateDetailAssistanceRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class DetailAssistanceController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('view detail assistance'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('create detail assistance'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('edit detail assistance'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete detail assistance'), only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $detailAssistances = DetailAssistance::latest()->get();
            return DataTables::of($detailAssistances)
                ->addIndexColumn()
                ->addColumn('assistance', function ($row) {
                    return $row->assistance ? $row->assistance->name : '';
                })
                ->addColumn('type', function ($row) {
                    return $row->type();
                })
                ->addColumn('action', 'admin.detail_assistance.include.action')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.detail_assistance.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assistances = Assistance::latest()->get();
        return view('admin.detail_assistance.create', compact('assistances'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDetailAssistanceRequest $request)
    {
        try {
            $attr = $request->validated();

            DetailAssistance::create([
                'assistance_id' => $attr['assistance_id'],
                'input_date' => $attr['input_date'],
                'type' => $attr['type'],
                'additional_data' => json_encode($attr['additional_data']),
            ]);

            return redirect()->route('admin.detailAssistance.index')->with('success', 'Data berhasil ditambah');
        } catch (\Throwable $th) {
            return redirect()->route('admin.detailAssistance.index')->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailAssistance $detailAssistance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailAssistance $detailAssistance)
    {
        $assistances = Assistance::latest()->get();
        return view('admin.detail_assistance.edit', compact('assistances', 'detailAssistance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDetailAssistanceRequest $request, DetailAssistance $detailAssistance)
    {
        try {
            $attr = $request->validated();

            $detailAssistance->update([
                'assistance_id' => $attr['assistance_id'],
                'input_date' => $attr['input_date'],
                'type' => $attr['type'],
                'additional_data' => json_encode($attr['additional_data']),
            ]);

            return redirect()
                ->route('admin.detailAssistance.index')
                ->with('success', __('Data Berhasil Diubah'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('admin.detailAssistance.index')
                ->with('error', __($th->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailAssistance $detailAssistance)
    {
        try {

            $detailAssistance->delete();

            return redirect()
                ->route('admin.detailAssistance.index')
                ->with('success', __('Data Berhasil Dihapus'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('admin.detailAssistance.index')
                ->with('error', __($th->getMessage()));
        }
    }

    public function export()
    {
        return Excel::download(new AssistanceExport(), 'Data Bantuan.xlsx');
    }
}
