<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapThe extends Model
{
    protected $table = 'cap_the';

    protected $fillable = [
        'ten',               
        'diem_toi_thieu',    
        'ti_le_tich_diem', 
        'uu_dai',          
    ];

    public $timestamps = true;

    public function nguoiDungs()
    {
        return $this->hasMany(NguoiDung::class, 'cap_the_id');
    }
}
