<?php
namespace App\Models;

use App\Models\Menu;
use App\Models\InvShop;
use App\Models\InvLocation;
use App\Models\Addon;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sale extends Model
{
    use HasFactory;
    protected $table = 'inv_sales';
    public $timestamps = false;
    protected $primaryKey = 'Sale_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'S_id',
        'L_id',
        'Menu_id',
        'Addon_id',
        'Qty',
        'price',
        'Currency_id',
        'Sale_date',
    ];
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'Menu_id', 'Menu_id');
    }
    public function shop()
    {
        return $this->belongsTo(InvShop::class, 'S_id', 'S_id');
    }
    public function location()
    {
        return $this->belongsTo(InvLocation::class, 'L_id', 'L_id');
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'Currency_id', 'Currency_id');
    }
    public function addon()
    {
        return $this->belongsTo(Addon::class, 'Addon_id', 'Addon_id');
    }

}

