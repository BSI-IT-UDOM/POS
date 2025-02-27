<?php

namespace App\Models;

use App\Models\Invshop;
use App\Models\InvLocation;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'inv_employee';
    public $timestamps = false;
    protected $primaryKey = 'emp_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'employee_id',
        'emp_title',
        'emp_fullname',
        'emp_contact',
        'emp_address',
        'emp_photo',
        'S_id',
        'L_id',
        'position_id',
        'status'
    ];
    public function shop()
    {
        return $this->belongsTo(Invshop::class, 'S_id', 'S_id');
    }
    public function location()
    {
        return $this->belongsTo(InvLocation::class, 'L_id', 'L_id');
    }
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'position_id');
    }
}
