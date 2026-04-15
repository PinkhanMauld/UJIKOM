<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'division_id'
    ];

    public function items()
    {
        return $this->hasMany(Item::class); 
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }
}