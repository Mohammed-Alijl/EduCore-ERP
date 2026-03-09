<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AcademicYear\StoreRequest;
use App\Http\Requests\Admin\AcademicYear\UpdateRequest;
use App\Models\AcademicYear;
use App\Services\AcademicYearService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AcademicYearController extends Controller implements HasMiddleware
{

    public function __construct(protected AcademicYearService $academic_year) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_years', only: ['index']),
            new Middleware('permission:create_years', only: ['store']),
            new Middleware('permission:edit_years', only: ['update']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $academicYears = $this->academic_year->getAll();
        return view('admin.academic_years.index', compact('academicYears'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $this->academic_year->store($request->validated());
            return response()->json([
                'status' => 'success',
                'message' => __('admin.academic_years.messages.success.add')
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?? __('admin.academic_years.messages.failed.add')
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, AcademicYear $academicYear)
    {
        try {
            $this->academic_year->update($academicYear, $request->validated());
            return response()->json([
                'status' => 'success',
                'message' => __('admin.academic_years.messages.success.update')
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?? __('admin.academic_years.messages.failed.update')
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
