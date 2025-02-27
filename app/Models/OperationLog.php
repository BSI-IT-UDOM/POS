<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationLog extends Model
{
    use HasFactory;
    protected $table = 'inv_operation_log';
    public $timestamps = false;
    protected $fillable = [
        'table_name',
        'operation_name',
        'column_name',
        'old_value_str',
        'old_value_num',
        'new_value_str',
        'new_value_num',
        'log_date'
    ];
}
