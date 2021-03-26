<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaporanHarian extends Model
{
	protected $table = 'laporan_harians';

    public function distribusi()
    {
        return $this->belongsTo('App\Distribusi', 'distribusi_id');
    }

    public function getCreatedAtAttribute()
	{
		return \Carbon\Carbon::parse($this->attributes['created_at'])
		// ->diffForHumans();
		->translatedFormat('l, d F Y');
	}
}
