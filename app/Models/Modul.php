<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;

class Modul extends Model
{
    use HasFactory, SoftDeletes, Sortable;

    protected $fillable = [
        'vendor', 'tipe_board', 'serial_number', 'tanggal_masuk', 'bkeluar_id', 'tanggal_keluar', 'hasil'
    ];

    // public $sortable = [
    //     'vendor', 'tipe_board', 'serial_number', 'tanggal_masuk', 'bkeluar_id', 'tanggal_keluar'
    // ];

    public function bkeluar()
    {
        return $this->belongsTo(BKeluar::class, 'bkeluar_id', 'id');
    }
}
