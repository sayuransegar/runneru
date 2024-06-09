<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $connection = 'mongodb';
    protected $fillable = [
        'name',
        'email',
        'phonenum',
        'studid',
        'usertype',
        'blocked',
        'password',
    ];

    protected $attributes = [
        'blocked' => false,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            $user->runners()->delete();
            $user->deliveries()->delete();
            $user->payments()->delete();
            $user->reports()->delete();
        });
    }

    public function runners()
    {
        return $this->hasMany(Runner::class, 'userid');
    }

    public function isRunner()
    {
        return Runner::where('userid', $this->id)->exists();
    }
    
    public function isCustomer()
    {
        return $this->usertype === 'customer';
    }

        /**
     * Get the selected role from the session.
     */
    public function selectedRole()
    {
        return session('selected_role');
    }

    public function runner()
    {
        return $this->hasOne(Runner::class, 'userid', '_id');
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'userid');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'userid');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'userid');
    }
}
