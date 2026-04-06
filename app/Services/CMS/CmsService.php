<?php

namespace App\Services\CMS;

use App\Models\Cms\CmsPage;
use App\Models\Cms\CmsSection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class CmsService
{
    /**
     * Get the landing page with all visible sections ordered.
     */
    public function getLandingPage(): ?CmsPage
    {
        return CmsPage::landing()->published()->with(['sections' => function ($q) {
            $q->visible()->ordered();
        }])->first();
    }

    /**
     * Get all landing page sections (including hidden, for admin).
     */
    public function getAllSections(): Collection
    {
        $page = CmsPage::landing()->first();

        if (! $page) {
            return collect();
        }

        return $page->sections()->ordered()->get();
    }

    /**
     * Get a single section by key.
     */
    public function getSection(string $key): ?CmsSection
    {
        return CmsSection::byKey($key)->first();
    }

    /**
     * Update a section's data.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateSection(CmsSection $section, array $data): CmsSection
    {
        $updateData = [];

        if (isset($data['title'])) {
            $updateData['title'] = $data['title'];
        }

        if (isset($data['subtitle'])) {
            $updateData['subtitle'] = $data['subtitle'];
        }

        if (isset($data['content'])) {
            $updateData['content'] = $data['content'];
        }

        if (isset($data['settings'])) {
            $updateData['settings'] = array_merge($section->settings ?? [], $data['settings']);
        }

        if (isset($data['is_visible'])) {
            $updateData['is_visible'] = $data['is_visible'];
        }

        if (isset($data['images'])) {
            $updateData['images'] = array_merge($section->images ?? [], $data['images']);
        }

        $section->update($updateData);

        return $section->fresh();
    }

    /**
     * Reorder sections by an array of IDs.
     *
     * @param  array<int>  $orderedIds
     */
    public function reorderSections(array $orderedIds): void
    {
        foreach ($orderedIds as $index => $id) {
            CmsSection::where('id', $id)->update(['sort_order' => $index + 1]);
        }
    }

    /**
     * Toggle a section's visibility.
     */
    public function toggleVisibility(CmsSection $section): CmsSection
    {
        $section->update(['is_visible' => ! $section->is_visible]);

        return $section->fresh();
    }

    /**
     * Upload an image for a section.
     */
    public function uploadSectionImage(UploadedFile $file, string $sectionKey, string $imageKey): string
    {
        $path = $file->store("cms/sections/{$sectionKey}", 'public');

        return $path;
    }

    /**
     * Delete a section image from storage.
     */
    public function deleteSectionImage(string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    // ─── Legal Pages ───

    /**
     * Get all legal pages.
     */
    public function getLegalPages(): Collection
    {
        return CmsPage::legal()->get();
    }

    /**
     * Get a legal page by slug.
     */
    public function getLegalPage(string $slug): ?CmsPage
    {
        return CmsPage::legal()->bySlug($slug)->first();
    }

    /**
     * Update a legal page.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateLegalPage(CmsPage $page, array $data): CmsPage
    {
        $page->update($data);

        return $page->fresh();
    }
}
