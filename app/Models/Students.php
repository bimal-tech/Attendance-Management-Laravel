<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
    public function users(){
        return $this->belongsTo(User::class);
     }
}
