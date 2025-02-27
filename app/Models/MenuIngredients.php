<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuIngredients extends Model
{
    use HasFactory;
    protected $table = 'view_menu_ingredient';
    public $timestamps = false;
    protected $fillable = [
        'Menu_id',
        'Material_id',
        'Menu_ENGName',
        'Menu_KHName',
        'IIQ_name',
        'IIQ_name_kh',
        'Menu_Category_ENG',
        'Menu_Category_KH',
        'Material_ENGName',
        'Material_KHName',
        'Qty',
        'UOM',
    ];
    public function material()
    {
        return $this->belongsTo(Material::class, 'Material_id');
    }
}

