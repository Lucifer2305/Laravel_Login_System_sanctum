<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Notifications\InvoicePaid;
use Laravel\Sanctum\HasApiTokens;
use Sagalbot\Encryptable\Encryptable;

class contactForm extends Model
{
    use HasApiTokens, HasFactory, Notifiable, Encryptable;

    protected $fillable = [
        'name',
        'dateofbirth',
        'email',
        'SSN'
    ];


    protected $encryptable = ['email'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'SSN'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'Sent_at' => 'datetime',
    ];

}
