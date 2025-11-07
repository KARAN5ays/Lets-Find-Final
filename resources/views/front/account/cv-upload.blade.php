@extends('front.layouts.app')

@section('main')

<div class="container">
    <h1>Upload CV</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Validation Error Display -->
    @if ($errors->has('cv'))
        <div class="alert alert-danger">
            {{ $errors->first('cv') }}
        </div>
    @endif

    <!-- Upload Form -->
    <form action="{{ route('upload.cv') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="cv" class="form-label">Choose CV File (PDF, DOC, DOCX, max 5MB)</label>
            <input type="file" class="form-control" id="cv" name="cv" required>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</button>
    </form>

    <!-- Display Uploaded CV -->
    @if(isset($cv))
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h5 class="card-title text-primary">Uploaded CV</h5>
                <p class="card-text">
                    <a href="{{ asset('storage/' . $cv->file_path) }}" target="_blank" class="btn btn-success">
                        <i class="fas fa-file-alt"></i> View/Download
                    </a>

                    <form action="{{ route('delete.cv', $cv->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </p>
            </div>
        </div>
    @else
        <div class="alert alert-warning mt-3">
            You have not uploaded a CV yet.
        </div>
    @endif

    <!-- Job Recommendations -->
    @if(isset($jobs) && $jobs->count())
        <div class="mt-5">
            <h2>Job Recommendations</h2>
            <ul class="list-group">
                @foreach($jobs as $job)
                    <li class="list-group-item">
                        <h5 class="text-primary">{{ $job->title }}</h5>
                        <p>{{ Str::limit($job->description, 100) }}</p>
                        <small class="text-muted">Location: {{ $job->location }}</small>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

@endsection