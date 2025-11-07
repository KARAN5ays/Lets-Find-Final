<div class="card border-0 shadow mb-4 p-3">
    <div class="s-body text-center mt-3">
        
        @if (Auth::user()->image != '')
            <img src="{{ asset('profile_pic/thumb/'.Auth::user()->image) }}" alt="avatar"  class="rounded-circle img-fluid" style="width: 150px;">
        @else
            <img src="{{ asset('assets/images/banner-1.jpg') }}" alt="avatar"  class="rounded-circle img-fluid" style="width: 150px;">
        @endif

        <h5 class="mt-3 pb-0">{{ Auth::user()->name }}</h5>
        <p class="text-muted mb-1 fs-6">{{ Auth::user()->designation }}</p>
        <div class="d-flex justify-content-center mb-2">
            <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary">Change Profile Picture</button>
        </div>
    </div>
</div>
<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush ">
            <li class="list-group-item d-flex justify-content-between p-3">
                <a href="{{ route('account.profile') }}">Account Settings</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('account.createJob') }}">Post a Job</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('account.myJobs') }}">My Jobs</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('account.myJobApplications') }}">Jobs Applied</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('account.savedJobs') }}">Saved Jobs</a>
            </li> 
            <li li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('upload.cv.form') }}">Upload CV</a>
            </li>
      
              <!-- Show My CV if the user has uploaded one -->
            @if(Auth::check() && Auth::user()->cvs()->exists())
                @php
                    $cv = Auth::user()->cvs()->latest()->first();
                @endphp
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="{{ asset('storage/' . $cv->file_path) }}" target="_blank">My CV</a>
                    <form action="{{ route('delete.cv', $cv->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </li>
            @endif
        </ul>
    </div>
</div>