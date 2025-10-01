<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrganizationRequest;
use App\Http\Requests\Admin\UpdateOrganizationRequest;
use App\Models\Organization;
use App\Services\OrganizationService;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    protected $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $organizations = $this->organizationService->getAllOrganizations();
        return view('admin.organizations.index', compact('organizations'));
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
    public function store(StoreOrganizationRequest $request)
    {
        $organization = $this->organizationService->createOrganization($request->validated());

        if ($organization) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization)
    {
        return response()->json($organization);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        $updated = $this->organizationService->updateOrganization($organization->id, $request->validated());

        if ($updated) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        $deleted = $this->organizationService->deleteOrganization($organization->id);

        if ($deleted) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 500);
    }
}
