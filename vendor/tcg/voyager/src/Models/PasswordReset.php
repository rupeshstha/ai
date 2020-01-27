<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Facades\Voyager;

class PasswordReset extends Model
{
	public $timestamps = false;
    protected $guarded = [];

    private function clearExpired() {
    	$expired = $this->where('created_at', '<', now()->subMinutes(5))->delete();
    	return true;    	
    }

    public function getEmailAttribute( $data )
    {
    	$this->clearExpired();
    	return $data;
    }
}
