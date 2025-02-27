<?php

namespace App\Models;

use App\Models\MaterialGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialCategory extends Model
{
    use HasFactory;
    protected $table = 'inv_material_cate';
    public $timestamps = false;
    protected $primaryKey = 'Material_Cate_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'Material_Cate_Khname',
        'Material_Cate_Engname',
        'IMG_id',
        'status'
    ];
    public function materialGroup()
    {
        return $this->hasMany(MaterialGroup::class, 'IMG_id', 'IMG_id');
    }
}
