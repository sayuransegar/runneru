<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class report extends Model
{
    use HasFactory;

    protected $fillable = [
        'runnerid',
        'userid',
        'deliveryid',
        'reporterid',
        'reportedid',
        'reason',
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

    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reportedid');
    }

    public function reportedRunner()
    {
        return $this->belongsTo(Runner::class, 'reportedid');
    }

}
