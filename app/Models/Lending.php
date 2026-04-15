<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    use HasFactory;

    protected $table = 'lendings';

    protected $fillable = [
        'name',
        'borrower_type',
        'note',
        'date',
        'return_date',
        'edited_by',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }

    public function details()
    {
        return $this->hasMany(LendingDetail:: class);
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
}