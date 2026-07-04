<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Concerns\ValidatesUploadedImage;
use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    use ValidatesUploadedImage;

    public function index(): View
    {
        $galleries = auth()->user()
            ->galleries()
            ->latest()
            ->get();

        $stats = [
            'total' => $galleries->count(),
            'latest' => $galleries->first()?->updated_at,
        ];

        $uploadMaxLabel = $this->imageUploadMaxMegabytesLabel();

        return view('dashboard.gallery', compact('galleries', 'stats', 'uploadMaxLabel'));
    }

    public function store(StoreGalleryRequest $request): RedirectResponse
    {
        auth()->user()->galleries()->create(
            $this->buildGalleryAttributes($request)
        );

        return redirect()
            ->route('dashboard.gallery.index')
            ->with('success', 'Gallery item created successfully.');
    }

    public function update(UpdateGalleryRequest $request, Gallery $gallery): RedirectResponse
    {
        $this->authorizeGallery($gallery);

        $gallery->update(
            $this->buildGalleryAttributes($request, $gallery)
        );

        return redirect()
            ->route('dashboard.gallery.index')
            ->with('success', 'Gallery item updated successfully.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        $this->authorizeGallery($gallery);

        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return redirect()
            ->route('dashboard.gallery.index')
            ->with('success', 'Gallery item deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function buildGalleryAttributes(StoreGalleryRequest|UpdateGalleryRequest $request, ?Gallery $gallery = null): array
    {
        $attributes = [
            'title' => $request->string('title')->toString(),
        ];

        if ($request->hasFile('image')) {
            if ($gallery?->image) {
                Storage::disk('public')->delete($gallery->image);
            }

            $attributes['image'] = $request->file('image')->store('galleries/images', 'public');
        }

        return $attributes;
    }

    private function authorizeGallery(Gallery $gallery): void
    {
        abort_if($gallery->user_id !== auth()->id(), 403);
    }
}
