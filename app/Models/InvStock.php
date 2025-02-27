<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvStock extends Model
{
    use HasFactory;
    protected $table = 'inv_stock';
    public $timestamps = false;
    protected $primaryKey = 'Stock_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'S_id',
        'L_id',
        'Material_id',
        'OldQty',
        'old_expiry_date',
        'OrderQty',
        'order_date',
        'NewQty',
        'new_expiry_date',
        'UOM_id',
    ];
}