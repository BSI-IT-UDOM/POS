<?php

namespace App\Models\pos;

use App\Models\PaymentMethod;
use App\Models\Currency;
use App\Models\pos\POSOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class POSCheckBill extends Model
{
    use HasFactory;
    protected $table = 'pos_check_bill';
    public $timestamps = false;
    protected $primaryKey = 'pos_bill_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'pos_order_id',
        'IPM_id',
        'Currency_id',
        'status'
    ];
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'IPM_id', 'IPM_id');
    }
    public function posOrder()
    {
        return $this->belongsTo(POSOrder::class, 'pos_order_id', 'pos_order_id');
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'Currency_id', 'Currency_id');
    }
}
