<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    
    protected $fillable =  ['title', 'is_completed', 'user_id', 'description'];
    
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
