<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentCate extends Model
{
    use HasFactory;
    protected $table = 'inv_payment_method_category';
    public $timestamps = false;
    protected $primaryKey = 'PMCate_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'PMCate_Khname',
        'PMCate_Engname',
        'status'
    ];
}