<?php

namespace App\Models\pos;

use App\Models\pos\Discount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiscountDetail extends Model
{
    use HasFactory;
    protected $table = 'pos_discount_detail';
    public $timestamps = false;
    protected $primaryKey = 'pos_discount_detail_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'pos_discount_type_id',
        'discount_percentage',
        'expiry_date',
        'status'
    ];
    public function discount()
    {
        return $this->belongsTo(Discount::class, 'pos_discount_type_id', 'pos_discount_type_id');
    }
}
