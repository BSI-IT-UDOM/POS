<?php

namespace App\Models\pos;

use App\Models\pos\PromotionType;;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promotion extends Model
{
    use HasFactory;
    protected $table = 'pos_promotion';
    public $timestamps = false;
    protected $primaryKey = 'pos_promotion_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'promotion_name',
        'pos_promotion_type_id',
        'status'
    ];
    public function promotionType()
    {
        return $this->belongsTo(PromotionType::class, 'pos_promotion_type_id', 'pos_promotion_type_id');
    }
}
