<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Arsip extends Model
{
    use HasFactory, SoftDeletes, Sortable;

    protected $fillable = [
        'jenis', 'judul', 'vendor', 'nomor_arsip', 'file_arsip', 'tanggal_arsip'
    ];

    public $sortable = [
        'jenis', 'judul', 'vendor', 'nomor_arsip', 'file_arsip', 'tanggal_arsip'
    ];
}
