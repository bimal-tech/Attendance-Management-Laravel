<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Staffs extends Model
{
    use HasFactory;
    protected $fillable = [
        'salary',
        'user_id',
        'incentives',
        'post'
    ];
    public function users(){
        return $this->belongsTo(User::class);
     }
}
