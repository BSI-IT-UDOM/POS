<?php

namespace App\Models\pos;

use App\Models\Menu;
use App\Models\Addon;
use App\Models\invSize;
use App\Models\pos\POSOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class POSOrderDetail extends Model
{
    use HasFactory;
    protected $table = 'pos_order_detail';
    public $timestamps = false;
    protected $primaryKey = 'pos_order_detail_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'pos_order_id',
        'Menu_id',
        'Qty',
        'Addons_id',
        'Size_id',
        'price',
    ];
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'Menu_id', 'Menu_id');
    }
    public function posOrder()
    {
        return $this->belongsTo(POSOrder::class, 'pos_order_id', 'pos_order_id');
    }
    public function addons()
    {
        return $this->belongsTo(Addon::class, 'Addons_id', 'Addons_id');
    }
    public function size()
    {
        return $this->belongsTo(invSize::class, 'Size_id', 'Size_id');
    }
}
