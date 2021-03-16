<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distribusi extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function pakan()
    {
        return $this->belongsTo('App\Pakan', 'pakan_id');
    }

    public function obat()
    {
        return $this->belongsTo('App\Obat', 'obat_id');
    }
}
