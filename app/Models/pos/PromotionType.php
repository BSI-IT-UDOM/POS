<?php

namespace App\Models\pos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromotionType extends Model
{
    use HasFactory;
    protected $table = 'pos_promotion_type';
    public $timestamps = false;
    protected $primaryKey = 'pos_promotion_type_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'promotion_type_name',
        'promotion_type_description',
        'status'
    ];
}
