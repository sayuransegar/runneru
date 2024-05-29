<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'runnerid',
        'userid',
        'deliveryid',
        'itemprice',
        'servicecharge',
        'receipt'
    ];

    public function runner()
    {
        return $this->belongsTo(Runner::class, 'runnerid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'deliveryid');
    }
}
