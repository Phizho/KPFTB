<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\lampiran;

class Surat extends Model
{
    protected $dates = ['tanggal_kirim'];

    public function lampiran() {
        return this.hasMany('App\lampiran','nomor_surat','nomor_surat');
    } 
}

