<?php

namespace App\Models\pos;

use App\Models\Invshop;
use App\Models\InvLocation;
use App\Models\pos\Table;
use App\Models\pos\DiscountDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class POSOrder extends Model
{
    use HasFactory;
    protected $table = 'pos_order';
    public $timestamps = false;
    protected $primaryKey = 'pos_order_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'S_id',
        'L_id',
        'order_number',
        'pos_table_id',
        'order_date',
        'sub_total',
        'pos_discount_detail_id',
        'discount_amount',
        'grand_total',
        'status'
    ];
    public function table()
    {
        return $this->belongsTo(Table::class, 'pos_table_id', 'pos_table_id');
    }
    public function discountDetail()
    {
        return $this->belongsTo(DiscountDetail::class, 'pos_discount_detail_id', 'pos_discount_detail_id');
    }
    public function shop()
    {
        return $this->belongsTo(Invshop::class, 'S_id', 'S_id');
    }
    public function location()
    {
        return $this->belongsTo(InvLocation::class, 'L_id', 'L_id');
    }
}
