<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialGroup extends Model
{
    use HasFactory;
    protected $table = 'inv_material_group';
    public $timestamps = false;
    protected $primaryKey = 'IMG_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'IMG_khname',
        'IMG_engname',
        'status'
    ];
}
