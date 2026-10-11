<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChuTro extends Model
{
    use HasFactory;

    protected $table = 'chu_tro';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'dia_chi',
        'bank_code',
        'account_no',
        'account_name',
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'id');
    }
    public function dayTro()
    {
        return $this->hasMany(DayTro::class, 'chu_tro_id');
    }
}
