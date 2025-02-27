<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    protected $table = 'inv_position';
    public $timestamps = false;
    protected $primaryKey = 'position_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'position_name',
        'position_alias',
        'status',
    ];
}
