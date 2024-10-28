<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assistance;
use App\Http\Requests\StoreAssistanceRequest;
use App\Http\Requests\UpdateAssistanceRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;

class AssistanceController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('view assistance'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('create assistance'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('edit assistance'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete assistance'), only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $assistances = Assistance::latest()->get();
            return DataTables::of($assistances)
                ->addIndexColumn()
                ->addColumn('action', 'admin.assistance.include.action')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.assistance.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.assistance.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssistanceRequest $request)
    {
        try {
            $attr = $request->validated();

            Assistance::create($attr);

            return redirect()->route('admin.assistance.index')->with('success', 'Data berhasil ditambah');
        } catch (\Throwable $th) {
            return redirect()->route('admin.assistance.index')->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Assistance $assistance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assistance $assistance)
    {
        return view('admin.assistance.edit', compact('assistance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssistanceRequest $request, Assistance $assistance)
    {
        try {
            $attr = $request->validated();

            $assistance->update($attr);

            return redirect()
                ->route('admin.assistance.index')
                ->with('success', __('Data Berhasil Diubah'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('admin.assistance.index')
                ->with('error', __($th->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assistance $assistance)
    {
        try {

            $assistance->delete();

            return redirect()
                ->route('admin.assistance.index')
                ->with('success', __('Data Berhasil Dihapus'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('admin.assistance.index')
                ->with('error', __($th->getMessage()));
        }
    }
}
