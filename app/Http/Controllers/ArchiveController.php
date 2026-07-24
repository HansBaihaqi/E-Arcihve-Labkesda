<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArchiveRequest;
use App\Http\Requests\UpdateArchiveRequest;
use App\Models\Archive;
use App\Models\Folder;
use App\Services\ActivityLogService;
use App\Services\ArchiveService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ArchiveController extends Controller
{
    public function __construct(
        private ArchiveService $archiveService
    ) {}

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Archive::class);

        $search = $request->input('search');
        $classification = $request->input('classification');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');

        $allowedSorts = ['archive_code', 'title', 'archive_date', 'classification', 'created_at'];
        if (! in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }
        $direction = $direction === 'asc' ? 'asc' : 'desc';

        $query = Archive::with('uploader');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('archive_code', 'like', "%{$search}%")
                    ->orWhere('original_file_name', 'like', "%{$search}%");
            });
        }

        if ($classification) {
            $query->where('classification', $classification);
        }

        if ($dateFrom) {
            $query->whereDate('archive_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('archive_date', '<=', $dateTo);
        }

        $archives = $query->orderBy($sort, $direction)->paginate(10)->withQueryString();

        $classifications = ['Umum', 'Internal', 'Rahasia', 'Sangat Rahasia'];

        return view('archives.index', compact(
            'archives',
            'search',
            'classification',
            'dateFrom',
            'dateTo',
            'sort',
            'direction',
            'classifications'
        ));
    }

    public function create(): View
    {
        $this->authorize('create', Archive::class);

        $classifications = ['Umum', 'Internal', 'Rahasia', 'Sangat Rahasia'];
        $folders = Folder::orderBy('name')->get();

        return view('archives.create', compact('classifications', 'folders'));
    }

    public function store(StoreArchiveRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['archive_code'] = $this->archiveService->generateArchiveCode();
        $data['uploaded_by'] = auth()->id();

        if ($request->hasFile('file')) {
            $data = array_merge($data, $this->archiveService->handleFileUpload($request->file('file')));
        }

        unset($data['file']);

        $archive = Archive::create($data);

        ActivityLogService::log('create', 'Menambahkan arsip: '.$archive->title, $archive);

        return redirect()->route('archives.index')->with('success', 'Arsip berhasil ditambahkan.');
    }

    public function show(Archive $archive): View
    {
        $this->authorize('view', $archive);

        $archive->load('uploader');

        return view('archives.show', compact('archive'));
    }

    public function edit(Archive $archive): View
    {
        $this->authorize('update', $archive);

        $classifications = ['Umum', 'Internal', 'Rahasia', 'Sangat Rahasia'];
        $folders = Folder::orderBy('name')->get();

        return view('archives.edit', compact('archive', 'classifications', 'folders'));
    }

    public function update(UpdateArchiveRequest $request, Archive $archive): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            $this->archiveService->deleteFile($archive->file_path);
            $data = array_merge($data, $this->archiveService->handleFileUpload($request->file('file')));
        }

        unset($data['file']);

        $archive->update($data);

        ActivityLogService::log('update', 'Memperbarui arsip: '.$archive->title, $archive);

        return redirect()->route('archives.index')->with('success', 'Arsip berhasil diperbarui.');
    }

    public function destroy(Archive $archive): RedirectResponse
    {
        $this->authorize('delete', $archive);

        $title = $archive->title;
        $this->archiveService->deleteFile($archive->file_path);
        $archive->delete();

        ActivityLogService::log('delete', 'Menghapus arsip: '.$title);

        return redirect()->route('archives.index')->with('success', 'Arsip berhasil dihapus.');
    }

    public function download(Archive $archive): StreamedResponse
    {
        $this->authorize('download', $archive);

        if (! $archive->file_path || ! Storage::disk('public')->exists($archive->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download(
            $archive->file_path,
            $archive->original_file_name ?? $archive->file_name
        );
    }

    public function preview(Archive $archive): View|StreamedResponse
    {
        $this->authorize('view', $archive);

        if (! $archive->file_path || ! Storage::disk('public')->exists($archive->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        if (! $archive->isPdf()) {
            return redirect()->route('archives.download', $archive);
        }

        return view('archives.preview', compact('archive'));
    }
}
