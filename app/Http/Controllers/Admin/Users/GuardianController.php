<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Guardian\StoreRequest;
use App\Http\Requests\Admin\Guardian\UpdateRequest;
use App\Models\Users\Guardian;
use App\Services\Users\GuardianService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class GuardianController extends Controller implements HasMiddleware
{
    public function __construct(protected GuardianService $guardianService)
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_guardians', only: ['index']),
            new Middleware('permission:create_guardians', only: ['store']),
            new Middleware('permission:edit_guardians', only: ['update']),
            new Middleware('permission:delete_guardians', only: ['destroy']), // Soft Delete
            new Middleware('permission:view-archived_guardians', only: ['archive']),
            new Middleware('permission:restore_guardians', only: ['restore']),
            new Middleware('permission:force-delete_guardians', only: ['forceDelete']),
        ];
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $guardians = $this->guardianService->getAll();
            $lookups = $this->guardianService->getLookups();
            return view('admin.Users.guardians.index', array_merge(
                compact('guardians'),
                $lookups
            ));
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
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
    public function store(StoreRequest $request)
    {
        try {
            $this->guardianService->store($request->validated());
            return response()->json([
                'status' => 'success',
                'message' => __('admin.Users.guardians.messages.success.add')
            ], 200);

        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Guardian $guardian)
    {
        try {
            $this->guardianService->update($guardian, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => __('admin.Users.guardians.messages.success.update')
            ], 200);

        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => __('admin.Users.guardians.messages.failed.update')
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guardian $guardian)
    {
        try {
            $this->guardianService->delete($guardian);

            return response()->json([
                'status' => 'success',
                'message' => __('admin.Users.guardians.messages.success.archive')
            ], 200);

        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function archive()
    {
        try {
            $guardians = $this->guardianService->archive();
            return view('admin.Users.guardians.archived', compact('guardians'));

        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => __('admin.Users.guardians.messages.failed.archive')
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $this->guardianService->restore($id);
            return response()->json([
                'status' => 'success',
                'message' => __('admin.Users.guardians.messages.success.restore')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('admin.Users.guardians.messages.failed.restore')
            ], 404);
        }
    }


    public function forceDelete($id)
    {
        try {
            $this->guardianService->forceDelete($id);

            return response()->json([
                'status' => 'success',
                'message' => __('admin.Users.guardians.messages.success.delete')
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }

}
