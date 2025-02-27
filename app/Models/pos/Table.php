<?php

namespace App\Models\pos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends Model
{
    use HasFactory;
    protected $table = 'pos_table';
    public $timestamps = false;
    protected $primaryKey = 'pos_table_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'table_name',
        'table_number',
        'table_location',
        'status'
    ];
}
