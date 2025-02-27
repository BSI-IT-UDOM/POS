<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;
    protected $table = 'inv_income';
    public $timestamps = false;
    protected $primaryKey = 'income_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'income_name',
        'IC_id',
        'total_income',
        'Currency_id',
        'references_doc',
        'income_date',
        'status'
    ];
    public function IncomeCategory()
    {
        return $this->belongsTo(IncomeCate::class, 'IC_id', 'IC_id');
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'Currency_id', 'Currency_id');
    }
}
