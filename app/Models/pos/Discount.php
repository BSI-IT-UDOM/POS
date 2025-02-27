<?php

namespace App\Models\pos;

use App\Models\pos\DiscountDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{
    use HasFactory;
    protected $table = 'pos_discount_type';
    public $timestamps = false;
    protected $primaryKey = 'pos_discount_type_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'discount_type_name',
        'discount_type_description',
        'status'
    ];

    public function discountDetail()
    {
        return $this->hasMany(DiscountDetail::class, 'pos_discount_type_id', 'pos_discount_type_id');
    }
}

