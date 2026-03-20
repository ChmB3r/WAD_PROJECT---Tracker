<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Manga to Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .search-result { cursor: pointer; transition: background 0.2s; }
        .search-result:hover { background-color: #f8f9fa; }
        .manga-cover { width: 50px; height: 75px; object-fit: cover; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Add to List</h2>
                    <a href="{{ route('mangas.index') }}" class="btn btn-outline-secondary">Back to Tracker</a>
                </div>

                <div class="card mb-4 shadow-sm border-primary">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Search Something...</h5>
                    </div>
                    <div class="card-body">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control form-control-lg" placeholder="Type a Manga, Manhwa, or Manhua title...">
                            <button class="btn btn-primary px-4" type="button" id="searchBtn">Search</button>
                        </div>
                        <div id="searchResults" class="mt-3 list-group" style="max-height: 400px; overflow-y: auto;"></div>
                    </div>
                </div>

                <div class="card shadow-sm d-none border-success" id="mangaFormCard">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Save to your Tracker</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex mb-4 p-3 bg-light rounded">
                            <img id="previewImage" src="" alt="Cover" class="img-thumbnail me-4 shadow-sm" style="max-width: 100px;">
                            <div>
                                <h4 id="previewTitle" class="fw-bold mb-1">Title</h4>
                                <span class="badge bg-secondary mb-2" id="previewType">Type</span>
                            </div>
                        </div>

                        <form action="{{ route('mangas.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="mal_id" id="mal_id">
                            <input type="hidden" name="title" id="title">
                            <input type="hidden" name="type" id="type">
                            <input type="hidden" name="image_url" id="image_url">
                            <input type="hidden" name="url" id="url">

                            <div class="mb-4">
                                <label for="status" class="form-label fw-bold">Select Tracking Status</label>
                                <select class="form-select form-select-lg" id="status" name="status" required>
                                    <option value="Plan to read">Plan to read</option>
                                    <option value="Reading">Reading</option>
                                    <option value="On-hold">On-hold</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Dropped">Dropped</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">Add to Tracker Database</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchBtn').addEventListener('click', function() {
            const query = document.getElementById('searchInput').value;
            if (query.trim().length < 3) return alert('Please enter at least 3 characters to search.');
            
            const resultsContainer = document.getElementById('searchResults');
            resultsContainer.innerHTML = '<div class="text-center p-3"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 text-muted">Querying MyAnimeList via Jikan API...</p></div>';
            document.getElementById('mangaFormCard').classList.add('d-none');

            fetch(`https://api.jikan.moe/v4/manga?q=${encodeURIComponent(query)}&limit=10`)
                .then(res => res.json())
                .then(data => {
                    resultsContainer.innerHTML = '';
                    if (!data.data || data.data.length === 0) {
                        resultsContainer.innerHTML = '<div class="list-group-item text-center py-4">No results found for that title.</div>';
                        return;
                    }
                    data.data.forEach(manga => {
                        const item = document.createElement('div');
                        item.className = 'list-group-item list-group-item-action search-result d-flex align-items-center p-2';
                        item.innerHTML = `
                            <img src="${manga.images.webp.image_url}" class="manga-cover me-3 shadow-sm">
                            <div>
                                <h6 class="mb-1 text-primary fw-bold">${manga.title}</h6>
                                <small class="text-muted"><span class="badge bg-secondary">${manga.type}</span> - Score: ${manga.score || 'N/A'}</small>
                            </div>
                        `;
                        item.addEventListener('click', () => {
                            document.getElementById('mangaFormCard').classList.remove('d-none');
                            
                            document.getElementById('previewTitle').innerText = manga.title;
                            document.getElementById('previewType').innerText = manga.type;
                            document.getElementById('previewImage').src = manga.images.webp.image_url;
                            
                            document.getElementById('mal_id').value = manga.mal_id;
                            document.getElementById('title').value = manga.title;
                            document.getElementById('type').value = manga.type;
                            document.getElementById('image_url').value = manga.images.webp.image_url;
                            document.getElementById('url').value = manga.url;
                            
                            // Scroll down
                            document.getElementById('mangaFormCard').scrollIntoView({ behavior: 'smooth' });
                        });
                        resultsContainer.appendChild(item);
                    });
                })
                .catch(err => {
                    resultsContainer.innerHTML = '<div class="list-group-item text-danger text-center">Error fetching data. Check your network or the Jikan API status.</div>';
                });
        });
        
        // Also fire search on Enter key
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('searchBtn').click();
            }
        });
    </script>
</body>
</html>
