@extends('front.layouts.app')

@section('main')
<section class="section-0 lazy d-flex bg-image-style dark align-items-center "  class="" data-bg="{{ asset('assets/images/banner6.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-8">
                <h1>Find Jobs According to Your Capabilities</h1>
                <p>Hundreds of jobs available.</p>
                <div class="banner-btn mt-5"><a href="#" class="btn btn-primary mb-4 mb-sm-0">Explore Now</a></div>
            </div>
        </div>
    </div>
</section>

<section class="section-1 py-5 "> 
    <div class="container">
        <div class="card border-0 shadow p-5">
            <form action="{{ route("jobs") }}" method="GET">
                <div class="row">
                    
                    <div class="col-md-4 mb-4 mb-sm-4 mb-lg-0">
                        <input type="text" class="form-control" name="location" id="location" placeholder="Location">
                    </div>
                    <div class="col-md-4 mb-4 mb-sm-4 mb-lg-0">
                        <select name="category" id="category" class="form-control">
                            <option value="">Select a Category</option>
                            @if ($newCategories->isNotEmpty())
                                @foreach ($newCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>  
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <div class=" col-md-4 mb-xs-4 mb-sm-4 mb-lg-0">
                        <div class="d-grid gap-2">
                            {{-- <a href="jobs.html" class="btn btn-primary btn-block">Search</a> --}}
                            <button type="submit" class="btn btn-primary btn-block">Search</button>
                        </div>
                        
                    </div>
                </div> 
            </form>           
        </div>
    </div>
</section>

<section class="section-2 bg-2 py-5">
    <div class="container">
        <h2>Popular Categories</h2>
        <div class="row pt-5">

            @if ($categories->isNotEmpty())
            @foreach ($categories as $category)
            <div class="col-lg-4 col-xl-3 col-md-6">
                <div class="single_catagory">
                    <a href="{{ route('jobs').'?category='.$category->id }}"><h4 class="pb-2">{{ $category->name }}</h4></a>
                    <p class="mb-0"> <span>0</span> Available position</p>
                </div>
            </div> 
            @endforeach                
            @endif
        </div>
    </div>
</section>

{{-- @auth --}}
{{-- <section class="recommended-jobs py-5">
    <div class="container">
        <h2 class="mb-4">Recommended Jobs For You</h2>
        
        @if($recommendedJobs->isNotEmpty())
            <div class="row">
                @foreach($recommendedJobs as $job)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title">{{ $job->title }}</h3>
                            <p class="text-muted">Required Skills: {{ $job->skills_required }}</p>
                            <div class="job-meta">
                                <p class="mb-1">
                                    <i class="fas fa-map-marker-alt"></i> {{ $job->location }}
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-clock"></i> {{ $job->job_type }}
                                </p>
                            </div>
                            <a href="{{ route('jobs.view', $job->id) }}" class="btn btn-primary mt-3">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">
                No recommended jobs found based on your skills. Here are some featured opportunities:
                @include('partials.featured-jobs')
            </div>
        @endif
    </div>
</section>
@endauth --}}
@if(Auth::check() && $recommendedJobs->isNotEmpty())
<section class="section-3 bg-light py-5">
    <div class="container">
        <h2>Recommended Jobs for You</h2>
        <div class="row pt-5">
            @foreach ($recommendedJobs as $job)
            <div class="col-md-4">
                <div class="card border-0 p-3 shadow mb-4">
                    <div class="card-body">
                        <h3 class="border-0 fs-5 pb-2 mb-0">{{ $job->title }}</h3>
                        <p>{{ Str::limit(strip_tags($job->description), 100) }}</p>
                        <div class="bg-light p-3 border">
                            <p class="mb-0">
                                <i class="fa fa-map-marker"></i> {{ $job->location }}
                            </p>
                            <p class="mb-0">
                                <i class="fa fa-clock-o"></i> {{ $job->jobType->name ?? 'N/A' }}
                            </p>
                            @if ($job->salary)
                            <p class="mb-0">
                                <i class="fa fa-usd"></i> {{ $job->salary }}
                            </p>
                            @endif
                        </div>
                        <div class="d-grid mt-3">
                            <a href="{{ route('jobDetail', $job->id) }}" class="btn btn-primary btn-lg">Details</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif


 <section class="section-3  py-5">
    <div class="container">
        <h2>Featured Jobs</h2>
        <div class="row pt-5">
            <div class="job_listing_area">                    
                <div class="job_lists">
                    <div class="row">
                        @if ($featuredJobs->isNotEmpty())
                            @foreach ($featuredJobs as $featuredJob)
                            <div class="col-md-4">
                                <div class="card border-0 p-3 shadow mb-4">
                                    <div class="card-body">
                                        <h3 class="border-0 fs-5 pb-2 mb-0">{{ $featuredJob->title }}</h3>
                                        
                                        <p>{{ Str::words(strip_tags($featuredJob->description), 5) }}</p>

                                        <div class="bg-light p-3 border">
                                            <p class="mb-0">
                                                <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                <span class="ps-1">{{ $featuredJob->location }}</span>
                                            </p>
                                            <p class="mb-0">
                                                <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                <span class="ps-1">{{ $featuredJob->jobType->name }}</span>
                                            </p>
                                            @if (!is_null($featuredJob->salary))
                                            <p class="mb-0">
                                                <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                <span class="ps-1">{{ $featuredJob->salary }}</span>
                                            </p>
                                            @endif                                            
                                        </div>
    
                                        <div class="d-grid mt-3">
                                            <a href="{{ route('jobDetail',$featuredJob->id) }}" class="btn btn-primary btn-lg">Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 

<section class="section-3 bg-2 py-5">
    <div class="container">
        <h2>Latest Jobs</h2>
        <div class="row pt-5">
            <div class="job_listing_area">                    
                <div class="job_lists">
                    <div class="row">
                        @if ($latestJobs->isNotEmpty())
                            @foreach ($latestJobs as $latestJob)
                            <div class="col-md-4">
                                <div class="card border-0 p-3 shadow mb-4">
                                    <div class="card-body">
                                        <h3 class="border-0 fs-5 pb-2 mb-0">{{ $latestJob->title }}</h3>
                                        
                                        <p>{{ Str::words(strip_tags($latestJob->description), 5) }}</p>

                                        <div class="bg-light p-3 border">
                                            <p class="mb-0">
                                                <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                <span class="ps-1">{{ $latestJob->location }}</span>
                                            </p>
                                            <p class="mb-0">
                                                <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                <span class="ps-1">{{ $latestJob->jobType->name }}</span>
                                            </p>
                                            @if (!is_null($latestJob->salary))
                                            <p class="mb-0">
                                                <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                <span class="ps-1">{{ $latestJob->salary }}</span>
                                            </p>
                                            @endif                                            
                                        </div>
    
                                        <div class="d-grid mt-3">
                                            <a href="{{ route('jobDetail',$latestJob->id) }}" class="btn btn-primary btn-lg">Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif                                                 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection