<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = [
        'customer_name',
        'customer_email',
    ];
}
