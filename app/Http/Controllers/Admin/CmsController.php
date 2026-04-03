<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Cms\UpdateCmsPageRequest;
use App\Http\Requests\Admin\Cms\UpdateCmsSectionRequest;
use App\Models\CmsPage;
use App\Models\CmsSection;
use App\Services\CmsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CmsController extends Controller implements HasMiddleware
{
    public function __construct(private readonly CmsService $cmsService) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_cms', only: ['index', 'editSection', 'legalPages', 'editLegalPage']),
            new Middleware('permission:edit_cms', only: ['updateSection', 'reorder', 'toggleVisibility', 'updateLegalPage']),
        ];
    }

    /**
     * CMS dashboard — show all landing page sections.
     */
    public function index(): View
    {
        $sections = $this->cmsService->getAllSections();

        return view('admin.cms.index', compact('sections'));
    }

    /**
     * Edit a specific section.
     */
    public function editSection(CmsSection $section): View
    {
        return view('admin.cms.sections.edit', compact('section'));
    }

    /**
     * Update a section.
     */
    public function updateSection(UpdateCmsSectionRequest $request, CmsSection $section): JsonResponse
    {
        try {
            $data = $request->validated();

            // Handle image uploads
            if ($request->hasFile('image_uploads')) {
                $images = $section->images ?? [];
                foreach ($request->file('image_uploads') as $key => $file) {
                    // Delete old image if exists
                    if (isset($images[$key])) {
                        $this->cmsService->deleteSectionImage($images[$key]);
                    }
                    $images[$key] = $this->cmsService->uploadSectionImage($file, $section->section_key, $key);
                }
                $data['images'] = $images;
            }

            $this->cmsService->updateSection($section, $data);

            return response()->json([
                'status' => 'success',
                'message' => __('admin.cms.messages.success.update'),
            ]);
        } catch (\Exception $e) {
            Log::error('CMS section update failed: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => __('admin.cms.messages.failed.update'),
            ], 500);
        }
    }

    /**
     * Reorder sections via drag & drop.
     */
    public function reorder(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'order' => ['required', 'array'],
                'order.*' => ['required', 'integer', 'exists:cms_sections,id'],
            ]);

            $this->cmsService->reorderSections($request->input('order'));

            return response()->json([
                'status' => 'success',
                'message' => __('admin.cms.messages.success.reorder'),
            ]);
        } catch (\Exception $e) {
            Log::error('CMS reorder failed: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => __('admin.cms.messages.failed.reorder'),
            ], 500);
        }
    }

    /**
     * Toggle section visibility.
     */
    public function toggleVisibility(CmsSection $section): JsonResponse
    {
        try {
            $section = $this->cmsService->toggleVisibility($section);

            return response()->json([
                'status' => 'success',
                'message' => __('admin.cms.messages.success.toggle'),
                'is_visible' => $section->is_visible,
            ]);
        } catch (\Exception $e) {
            Log::error('CMS toggle visibility failed: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => __('admin.cms.messages.failed.toggle'),
            ], 500);
        }
    }

    /**
     * List all legal pages.
     */
    public function legalPages(): View
    {
        $pages = $this->cmsService->getLegalPages();

        return view('admin.cms.legal.index', compact('pages'));
    }

    /**
     * Edit a legal page.
     */
    public function editLegalPage(CmsPage $page): View
    {
        return view('admin.cms.legal.edit', compact('page'));
    }

    /**
     * Update a legal page.
     */
    public function updateLegalPage(UpdateCmsPageRequest $request, CmsPage $page): JsonResponse
    {
        try {
            $this->cmsService->updateLegalPage($page, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => __('admin.cms.messages.success.update_page'),
            ]);
        } catch (\Exception $e) {
            Log::error('CMS legal page update failed: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => __('admin.cms.messages.failed.update_page'),
            ], 500);
        }
    }
}
