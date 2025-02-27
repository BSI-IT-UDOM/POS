<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginInfo extends Model
{
    use HasFactory;

    protected $table = 'login_info';
    public $timestamps = false;
    protected $primaryKey = 'login_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'U_id',
        'public_ip',
        'mac_add',
        'login_datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'U_id', 'U_id'); 
    }
}
