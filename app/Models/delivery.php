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
}
