<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sfp extends Model
{
    use HasFactory, SoftDeletes, Sortable;

    protected $fillable = [
        'jenis', 'vendor', 'bandwidth', 'lambda', 'jarak', 'serial_number', 'tanggal_masuk', 'bkeluar_id', 'tanggal_keluar', 'hasil'
    ];

    // public $sortable = [
    //     'jenis', 'vendor', 'bandwidth', 'lambda', 'jarak', 'serial_number', 'tanggal_masuk', 'bkeluar_id', 'tanggal_keluar'
    // ];

    public function bkeluar()
    {
        return $this->belongsTo(BKeluar::class, 'bkeluar_id', 'id');
    }
}
