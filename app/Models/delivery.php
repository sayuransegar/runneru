<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class delivery extends Model
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
         'runnerid',
         'item',
         'addinstruct',
         'price',
         'shoplocation',
         'shoplat',
         'shoplng',
         'deliverylocation',
         'deliverylat',
         'deliverylng',
         'status',
     ];


     public function user()
     {
         return $this->belongsTo(User::class, 'userid', '_id');
     }
 
     public function runner()
     {
         return $this->belongsTo(Runner::class, 'runnerid', '_id');
     }

     public function payment()
     {
         return $this->hasOne(Payment::class, 'deliveryid');
     }
}
