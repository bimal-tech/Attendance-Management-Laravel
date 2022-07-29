<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;
    protected $fillable = [
        'class',
        'roll_no',
        'user_id',
        'fee_structure_id',
        'scholarship_type_id'

    ];
}
