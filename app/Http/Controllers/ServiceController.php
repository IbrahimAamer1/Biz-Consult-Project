<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::paginate(10);
        return view('admin.services.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $service = Service::create($request->all());
        if ($service) {
            return redirect()->route('admin.services.index')->with('success', __('keywords.service_created_successfully'));
        } else {
            return redirect()->route('admin.services.index')->with('error', __('keywords.service_creation_failed'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view('admin.services.show', get_defined_vars());
    }
 
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service = Service::find($service->id);
        $service->update($request->all());
        if ($service) {
            return redirect()->route('admin.services.index')->with('message', __('keywords.service_updated_successfully'));
        } else {
            return redirect()->route('admin.services.index')->with('something_went_wrong', __('keywords.service_update_failed'));
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        if ($service) {
            return redirect()->route('admin.services.index')->with('message', __('keywords.service_deleted_successfully'));
        } else {
            return redirect()->route('admin.services.index')->with('something_went_wrong', __('keywords.service_deletion_failed'));
        }
    }
}
