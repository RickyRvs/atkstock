<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    protected $table = 'instansi';

    protected $fillable = ['kode', 'nama', 'tipe', 'parent_id'];

    public function children()
    {
        return $this->hasMany(Instansi::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Instansi::class, 'parent_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'instansi_user');
    }
}