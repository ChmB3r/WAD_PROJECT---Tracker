<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga Tracker List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-0 fw-bold">Monarch’s Archive</h1>
                <div class="text-muted fw-bold">The Tracker</div>
                <p class="text-muted mt-2">Tracking {{ $allMangasCount ?? 0 }} total entries.</p>
            </div>
            <a href="{{ route('mangas.create') }}" class="btn btn-primary">Add New Manga</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="mb-4 d-flex gap-2">
            <a href="{{ route('mangas.index') }}" class="btn {{ !$status ? 'btn-dark' : 'btn-outline-dark' }}">All</a>
            @php $statuses = ['Plan to read', 'Reading', 'On-hold', 'Completed', 'Dropped']; @endphp
            @foreach($statuses as $s)
                <a href="{{ route('mangas.index', ['status' => $s]) }}" 
                   class="btn {{ $status === $s ? 'btn-dark' : 'btn-outline-dark' }}">
                    {{ $s }}
                </a>
            @endforeach
        </div>

        @forelse($mangas as $statusGroup => $items)
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-light">
                    <h5 class="mb-0 fw-bold">{{ $statusGroup }}</h5>
                    <span class="badge bg-secondary rounded-pill px-3">{{ $items->count() }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 80px;" class="ps-4">Cover</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $manga)
                                    <tr>
                                        <td class="ps-4">
                                            @if($manga->image_url)
                                                <img src="{{ $manga->image_url }}" alt="Cover" class="img-thumbnail" style="height: 75px; width: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary text-white text-center d-flex align-items-center justify-content-center img-thumbnail" style="height: 75px; width: 50px; font-size: 10px;">No<br>IMG</div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('mangas.show', $manga->id) }}" class="text-decoration-none fw-bold text-dark fs-5">
                                                {{ $manga->title }}
                                            </a>
                                            @if($manga->url)
                                                <div class="mt-1">
                                                    <a href="{{ $manga->url }}" target="_blank" class="badge bg-primary text-decoration-none"><small>View on MyAnimeList</small></a>
                                                </div>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-info text-dark">{{ $manga->type ?? 'Unknown' }}</span></td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('mangas.edit', $manga->id) }}" class="btn btn-sm btn-warning">Update</a>
                                            <form action="{{ route('mangas.destroy', $manga->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remove this manga from tracker?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5 bg-light rounded text-muted">
                <h4>No mangas found in your tracker.</h4>
                <p>Use the 'Add New Manga' button above to start building your list.</p>
            </div>
        @endforelse
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>