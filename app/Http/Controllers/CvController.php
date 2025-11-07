<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CV;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CVController extends Controller
{
    // Show CV upload form
    public function showForm()
    {
        $cv = Auth::user()->cvs()->latest()->first(); // Fetch latest CV
        $jobs = Job::inRandomOrder()->limit(5)->get(); // Fetch random job recommendations

        return view('front.account.cv-upload', compact('cv', 'jobs'));
    }

    // Handle CV upload
    public function uploadCV(Request $request)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf,doc,docx|max:5120', // Allow up to 5MB
        ]);

        $user = Auth::user();

        // Check if user already has a CV
        $existingCV = $user->cvs()->latest()->first();
        if ($existingCV) {
            return back()->with('error', 'You already have an uploaded CV. Please delete it before uploading a new one.');
        }

        if ($request->hasFile('cv')) {
            // Generate unique filename
            $fileName = time() . '_' . $user->id . '.' . $request->cv->extension();
            $filePath = $request->cv->storeAs('public/cvs', $fileName);

            // Save to database
            $cv = new CV();
            $cv->user_id = $user->id;
            $cv->file_path = 'cvs/' . $fileName; // Store in 'storage/app/public/cvs/'
            $cv->save();

            return back()->with('success', 'CV uploaded successfully.');
        }

        return back()->with('error', 'Failed to upload CV.');
    }

    // View CV
    public function viewCV($id)
    {
        $cv = CV::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        return response()->file(storage_path("app/public/{$cv->file_path}"));
    }

    // Delete CV
    public function deleteCV($id)
    {
        $cv = CV::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if (Storage::disk('public')->exists($cv->file_path)) {
            Storage::disk('public')->delete($cv->file_path);
        }

        $cv->delete();

        return redirect()->route('upload.cv.form')->with('success', 'CV deleted successfully.');
    }
}