<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';
    protected $primaryKey = 'id';
   protected $fillable = ['email', 'namaTugas', 'gambar', 'deskripsiTugas'];

   public $timestamps = false;

    public function getGambarUrlAttribute()
    {
        return asset('storage/' . $this->gambar);
    }
}
