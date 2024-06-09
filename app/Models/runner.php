<?php

namespace App\Models;

use App\Models\Payment as ModelsPayment;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Spatie\FlareClient\Report;

class Runner extends Model
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
         'cardmatric',
         'approval',
         'status',
         'blocked',
     ];

     public function user()
     {
         return $this->belongsTo(User::class, 'userid');
     }

     public function payments()
     {
         return $this->hasMany(Payment::class, 'runnerid');
     }

     public function reports()
     {
         return $this->hasMany(Report::class, 'runnerid');
     }
     
}
