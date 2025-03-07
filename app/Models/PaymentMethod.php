<?php

namespace App\Models;

use App\Models\PaymentCate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $table = 'inv_payment_method';
    public $timestamps = false;
    protected $primaryKey = 'IPM_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'IPM_fullname',
        'IPM_alias',
        'PMCate_id',
        'image',
        'status'
    ];
    public function paymentCate()
    {
        return $this->belongsTo(PaymentCate::class, 'PMCate_id', 'PMCate_id');
    }
}