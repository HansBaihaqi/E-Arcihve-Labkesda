<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Preview - {{ $archive->title }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Inter, system-ui, sans-serif; background: #1e293b; }
        .toolbar { display: flex; align-items: center; justify-content: space-between; padding: 12px 20px; background: #0f172a; color: white; }
        .toolbar h1 { font-size: 14px; font-weight: 500; truncate: ellipsis; overflow: hidden; white-space: nowrap; max-width: 60%; }
        .toolbar a { color: white; text-decoration: none; font-size: 13px; padding: 6px 14px; background: #4f46e5; border-radius: 8px; }
        iframe { width: 100%; height: calc(100vh - 52px); border: none; }
    </style>
</head>
<body>
    <div class="toolbar">
        <h1>{{ $archive->title }}</h1>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('archives.download', $archive) }}">Download</a>
            <a href="{{ route('archives.show', $archive) }}" style="background:#334155;">Kembali</a>
        </div>
    </div>
    <iframe src="{{ asset('storage/' . $archive->file_path) }}"></iframe>
</body>
</html>
