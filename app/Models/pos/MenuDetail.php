<?php
namespace App\Models\pos;

use App\Models\invSize;
use App\Models\Menu;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuDetail extends Model
{
    use HasFactory;
    protected $table = 'pos_menu_detail';
    public $timestamps = false;
    protected $primaryKey = 'pos_menu_detail_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'menu_detail_description',
        'Menu_id',
        'Size_id',
        'price',
        'Currency_id',
        'status'
    ];
    public function size()
    {
        return $this->belongsTo(invSize::class, 'Size_id', 'Size_id');
    }
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'Menu_id', 'Menu_id');
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'Currency_id', 'Currency_id');
    }
}
