<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeCate extends Model
{
    use HasFactory;
    protected $table = 'inv_income_cate';
    public $timestamps = false;
    protected $primaryKey = 'IC_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'IC_Khname',
        'IC_Engname',
        'status'
    ];
}
