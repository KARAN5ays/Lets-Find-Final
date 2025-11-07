<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Skill;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // This method will show our home page
    public function index() {
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->take(8)->get();
        $newCategories = Category::where('status', 1)->orderBy('name', 'ASC')->get();

        $featuredJobs = Job::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->with('jobType')
            ->where('isFeatured', 1)
            ->take(6)
            ->get();

        $latestJobs = Job::where('status', 1)
            ->with('jobType')
            ->orderBy('created_at', 'DESC')
            ->take(4)
            ->get();
            
            $recommendedJobs = collect(); // Default empty collection

            if (Auth::check()) {
                $user = Auth::user();
                $userSkills = !empty($user->skills) ? explode(',', $user->skills) : []; // Convert to array
            
                if (!empty($userSkills)) {
                    $recommendedJobs = Job::where(function ($query) use ($userSkills) {
                        foreach ($userSkills as $skill) {
                            $query->orWhere('skills_required', 'LIKE', '%' . trim($skill) . '%');
                        }
                    })
                    ->with('jobType')
                    ->orderBy('created_at', 'DESC')
                    ->take(6)
                    ->get();
                }
            }
    
        return view('front.home', [
            'categories' => $categories,
            'featuredJobs' => $featuredJobs,
            'latestJobs' => $latestJobs,
            'recommendedJobs' => $recommendedJobs,
            'newCategories' => $newCategories,
        ]);
    }
}