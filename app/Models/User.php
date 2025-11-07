<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Skill;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function cvs()
    {
        return $this->hasMany(CV::class);
    }
    // public function skills()
    // {
    //     return $this->belongsToMany(Skill::class, 'user_skills');
    // }
    // public function getRecommendedJobs()
    // {
    //     $userSkills = json_decode($this->skills, true) ?? []; // Ensure it's an array
    
    //     return Job::where(function ($query) use ($userSkills) {
    //         foreach ($userSkills as $skill) {
    //             $query->orWhereJsonContains('skills_required', $skill);
    //         }
    //     })->get();
    // }
    public function skills() {
        return $this->belongsToMany(Skill::class, 'user_skills');
    }

}