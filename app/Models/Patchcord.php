<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;

class Patchcord extends Model
{
    use HasFactory, SoftDeletes, Sortable;

    protected $fillable = [
        'jenis', 'konektor', 'jarak', 'tipe_kabel', 'serial_number', 'tanggal_masuk', 'bkeluar_id', 'tanggal_keluar', 'hasil'
    ];

    // public $sortable = [
    //     'jenis', 'konektor', 'jarak', 'tipe_kabel', 'tanggal_masuk', 'bkeluar_id', 'tanggal_keluar'
    // ];

    public function bkeluar()
    {
        return $this->belongsTo(BKeluar::class, 'bkeluar_id', 'id');
    }
}
