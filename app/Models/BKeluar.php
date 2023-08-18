<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class BKeluar extends Model
{
    use HasFactory, Sortable;

    protected $table = 'barang_keluars';

    protected $fillable = [
        'kebutuhan', 'instansi_pemberi', 'nama_pemberi', 'nik_pemberi', 'instansi_penerima', 'nama_penerima', 'nik_penerima', 'hasil', 'tanggal_keluar'
    ];

    public $sortable = [
        'kebutuhan', 'instansi_pemberi', 'nama_pemberi', 'nik_pemberi', 'instansi_penerima', 'nama_penerima', 'nik_penerima', 'hasil', 'tanggal_keluar'
    ];

    public $sortableAs = ['sfps_count', 'patchcords_count', 'moduls_count'];

    public function sfps()
    {
        return $this->hasMany(Sfp::class, 'bkeluar_id', 'id');
    }

    public function patchcords()
    {
        return $this->hasMany(Patchcord::class, 'bkeluar_id', 'id');
    }

    public function moduls()
    {
        return $this->hasMany(Modul::class, 'bkeluar_id', 'id');
    }
}
