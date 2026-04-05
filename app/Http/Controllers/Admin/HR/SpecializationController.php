<?php

namespace App\Http\Controllers\Admin\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Specialization\StoreRequest;
use App\Http\Requests\Admin\Specialization\UpdateRequest;
use App\Models\Specialization;
use App\Services\SpecializationService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SpecializationController extends Controller implements HasMiddleware
{
    protected $specializationService;

    public function __construct(SpecializationService $specializationService)
    {
        $this->specializationService = $specializationService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_specializations', only: ['index']),
            new Middleware('permission:create_specializations', only: ['store']),
            new Middleware('permission:edit_specializations', only: ['update']),
            new Middleware('permission:delete_specializations', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specializations = $this->specializationService->getAll();

        return view('admin.HR.specializations.index', compact('specializations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $this->specializationService->store($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.HR.specializations.messages.success.add'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Specialization $specialization)
    {
        try {
            $this->specializationService->update($specialization, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.HR.specializations.messages.success.update'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialization $specialization)
    {
        try {
            $this->specializationService->delete($specialization);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.HR.specializations.messages.success.delete'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
