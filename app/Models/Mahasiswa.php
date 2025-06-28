<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
 use HasFactory;
    protected $table = 'mahasiswas';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'nim',
        'nama',
        'jk',
        'tgl_lahir',
        'jurusan',
        'alamat'
    ];
 
}
