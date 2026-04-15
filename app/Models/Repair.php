<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $table = 'repairs';

    protected $fillable = [
        'item_id',
        'total',
        'note',
        'date',
        'return_date',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}