<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ['label', 'color'];

    public function Project()
    {
        return $this->hasMany(Project::class);
    }
}
