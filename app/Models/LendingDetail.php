<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LendingDetail extends Model
{
    use HasFactory;

    protected $table = 'lending_details';

    protected $fillable = [
        'lending_id',
        'item_id',
        'total',
    ];

    public function lending()
    {
        return $this->belongsTo(Lending::class, 'lending_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}