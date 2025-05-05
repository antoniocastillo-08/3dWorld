<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModel3dRequest;
use App\Http\Requests\UpdateModel3dRequest;
use App\Models\Model3d;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Model3dController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Model3d::all(); // O usa paginación si es necesario
        return Inertia::render('Modelos3d', [
            'models' => $models
        ]);
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
    public function store(StoreModel3dRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Model3d $model3d)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Model3d $model3d)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModel3dRequest $request, Model3d $model3d)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Model3d $model3d)
    {
        //
    }
}
