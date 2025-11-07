<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CV extends Model
{
    
    use HasFactory;

    protected $table='cvs';

    protected $fillable=['user_id','cv'];// allow mass assignement
    public function user(){
        return$this->belongsTo(User::class);
    }
    }
