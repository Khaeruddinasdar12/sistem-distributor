<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getCreatedAtAttribute()
	{
		return \Carbon\Carbon::parse($this->attributes['created_at'])
		// ->diffForHumans();
		->translatedFormat('l, d F Y, H:i');
	}
}
