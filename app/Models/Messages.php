<?php
/**
 * Created by PhpStorm.
 * User: profit
 * Date: 12/12/17
 * Time: 4:02 PM
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
	protected $table="messages";

	public function message_writers(){
		return $this->belongsTo('App\Models\User', 'user_id');
	}

}