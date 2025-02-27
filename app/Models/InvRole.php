<?php

namespace App\Models;

use App\Models\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvRole extends Model
{
    use HasFactory;
    protected $table = 'inv_role';
    public $timestamps = false;
    protected $primaryKey = 'R_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'S_id',
        'R_type',
        'status'
    ];

    public function modules()
    {
        return $this->hasMany(Module::class, 'R_id', 'R_id');
    }
}
