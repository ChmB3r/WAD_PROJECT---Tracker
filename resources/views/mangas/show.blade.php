<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Manga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manga Details</h2>
            <a href="{{ route('mangas.index') }}" class="btn btn-secondary">Back to Tracker</a>
        </div>
        
        <div class="card shadow-sm border-0">
            <div class="row g-0">
                <div class="col-md-4 text-center p-4 bg-dark">
                    @if($manga->image_url)
                        <img src="{{ $manga->image_url }}" class="img-fluid rounded shadow" alt="Cover" style="max-height: 400px;">
                    @else
                        <div class="text-white p-5 d-flex align-items-center justify-content-center" style="height: 100%;">No image available</div>
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="card-body p-5">
                        <h2 class="card-title fw-bold mb-1">{{ $manga->title }}</h2>
                        <span class="badge bg-primary mb-4">{{ $manga->type }}</span>
                        
                        <div class="mb-4">
                            <h5 class="text-muted border-bottom pb-2">Status</h5>
                            <span class="fs-4 badge bg-success">{{ $manga->status }}</span>
                        </div>
                        
                        @if($manga->url)
                        <div class="mb-4">
                            <h5 class="text-muted border-bottom pb-2">Link</h5>
                            <a href="{{ $manga->url }}" target="_blank" class="btn btn-outline-primary">Visit on MyAnimeList</a>
                        </div>
                        @endif

                        <div class="mt-5 border-top pt-4">
                            <a href="{{ route('mangas.edit', $manga->id) }}" class="btn btn-warning me-2">Edit Status</a>
                            <form action="{{ route('mangas.destroy', $manga->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this manga?')">Delete from Tracker</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
