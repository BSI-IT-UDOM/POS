<?php

namespace App\Models;

use App\Models\Invshop;
use App\Models\InvLocation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventory_view';
    protected $fillable = [
        'S_id',
        'L_id',
        'Material_Khname',
        'Material_Engname',
        'Category',
        'old_stock_qty',
        'old_stock_expiry_date',
        'new_stock_qty',
        'new_stock_expiry_date',
        'Total_In_Hand',
        'UOM_id',
    ];
    public function InvShop()
    {
        return $this->belongsTo(Invshop::class, 'S_id', 'S_id');
    }
    public function Location()
    {
        return $this->belongsTo(InvLocation::class, 'L_id', 'L_id');
    }
}
