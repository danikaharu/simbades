<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Http\Requests\StoreInformationRequest;
use App\Http\Requests\UpdateInformationRequest;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInformationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Information $information)
    {
        //    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Information $information)
    {
        return view('admin.information.edit', compact('information'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInformationRequest $request, Information $information)
    {
        try {
            $attr = $request->validated();

            $information->update($attr);

            return redirect()
                ->back()
                ->with('success', __('Data Berhasil Diubah'));
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->with('error', __($th->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Information $information)
    {
        //
    }
}
