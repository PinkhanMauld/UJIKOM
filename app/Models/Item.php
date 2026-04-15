<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = [
        'category_id',
        'name',
        'total',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }

    public function lendingDetails()
    {
        return $this->hasMany(LendingDetail::class, 'item_id');
    }
}