<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Folder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Arr;

class FolderController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Folder::class);

        $folders = Folder::whereNull('parent_id')->with('parent')->orderBy('name')->get();

        return view('folders.index', compact('folders'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Folder::class);

        $folders = Folder::orderBy('name')->get();
        $parentId = $request->query('parent_id');

        return view('folders.create', compact('folders', 'parentId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Folder::class);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'exists:folders,id'],
        ]);

        $data['created_by'] = auth()->id();

        Folder::create($data);

        return redirect()->route('folders.index')->with('success', 'Folder berhasil dibuat.');
    }

    public function show(Request $request, Folder $folder): View
    {
        $this->authorize('viewAny', Folder::class);

        $folder->load(['parent', 'children', 'creator']);
        $subfolders = $folder->children()->orderBy('name')->get();
        $archives = Archive::where('folder_id', $folder->id)->orderBy('title')->get();
        $search = $request->query('search');

        $availableArchivesQuery = Archive::whereNull('folder_id');
        if ($search) {
            $availableArchivesQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('archive_code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $availableArchives = $availableArchivesQuery->orderBy('title')->get();

        return view('folders.show', compact('folder', 'subfolders', 'archives', 'availableArchives', 'search'));
    }

    public function assignArchives(Request $request, Folder $folder): RedirectResponse
    {
        $this->authorize('create', Folder::class);

        $request->validate([
            'archive_ids' => ['nullable', 'array'],
            'archive_ids.*' => ['exists:archives,id'],
        ]);

        $archiveIds = Arr::wrap($request->input('archive_ids', []));

        if (! empty($archiveIds)) {
            Archive::whereIn('id', $archiveIds)->update(['folder_id' => $folder->id]);
        }

        return redirect()->route('folders.show', $folder)->with('success', 'Arsip berhasil dimasukkan ke folder.');
    }
}
