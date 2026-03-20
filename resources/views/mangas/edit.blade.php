<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tracker Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Edit Tracker</h4>
                        <a href="{{ route('mangas.index') }}" class="btn btn-sm btn-outline-light">Back</a>
                    </div>
                    <div class="card-body p-4">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="text-center mb-4 p-3 bg-white border rounded">
                            @if($manga->image_url)
                                <img src="{{ $manga->image_url }}" class="img-thumbnail shadow mb-3" style="max-height: 250px;">
                            @endif
                            <h3 class="fw-bold">{{ $manga->title }}</h3>
                        </div>

                        <form action="{{ route('mangas.update', $manga->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label class="form-label fw-bold">Current Tracking Status</label>
                                <select name="status" class="form-select form-select-lg">
                                    @foreach(['Plan to read', 'Reading', 'On-hold', 'Completed', 'Dropped'] as $statusOption)
                                        <option value="{{ $statusOption }}" {{ $manga->status === $statusOption ? 'selected' : '' }}>
                                            {{ $statusOption }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-grid pt-2">
                                <button type="submit" class="btn btn-primary btn-lg">Save Updated Status</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
