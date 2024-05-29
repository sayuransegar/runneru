<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class runner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $connection = 'mongodb';

     protected $fillable = [
         'userid',
         'hostel',
         'reason',
         'qrcode',
         'approval',
         'status',
     ];

     public function user()
     {
         return $this->belongsTo(User::class, 'userid');
     }

     public function payments()
     {
         return $this->hasMany(Payment::class, 'runnerid');
     }
     
}
