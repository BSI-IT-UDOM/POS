<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class invSize extends Model
{
    use HasFactory;

    protected $table = 'inv_size';
    public $timestamps = false;
    protected $primaryKey = 'Size_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'Size_name',
        'Size_abb',
        'status'
    ];
}