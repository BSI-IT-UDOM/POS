<?php

namespace App\Models\pos;

use App\Models\pos\Promotion;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromotionDetail extends Model
{
    use HasFactory;
    protected $table = 'pos_promotion_detail';
    public $timestamps = false;
    protected $primaryKey = 'pos_promotion_detail_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'promotion_detail_description',
        'pos_promotion_id',
        'Menu_id',
        'start_date',
        'end_date',
        'status'
    ];
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'Menu_id', 'Menu_id');
    }
    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'pos_promotion_id', 'pos_promotion_id');
    }
}
