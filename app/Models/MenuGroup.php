<?php

namespace App\Models;

use App\Models\invMenuCate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuGroup extends Model
{
    use HasFactory;
    protected $table = 'inv_menu_group';
    public $timestamps = false;
    protected $primaryKey = 'MenuGr_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'MenuGr_Khname',
        'MenuGr_Engname',
        'status'
    ];
    
    public function menuCate()
    {
        return $this->hasMany(invMenuCate::class, 'MenuGr_id', 'MenuGr_id');
    }
}
