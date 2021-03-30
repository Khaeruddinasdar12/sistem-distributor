<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaporanPanen extends Model
{
    protected $table = 'laporan_panens';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function getCreatedAtAttribute()
	{
		return \Carbon\Carbon::parse($this->attributes['created_at'])
		// ->diffForHumans();
		->translatedFormat('l, d F Y');
	}
}
