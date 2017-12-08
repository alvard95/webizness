<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 11/15/2017
 * Time: 4:45 PM
 */

namespace App\Models;


class IoToken extends Eloquent  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'io_tokens';

    public static function updateToken($user_id, $token){
        $db_token = IoToken::where('user_id', $user_id)
            ->where('token', $token)
            ->first();
        if(!$db_token){
            IoToken::insert(
                array(
                    'user_id' => $user_id,
                    'token' => $token,
                )
            );
        }

        return true;
    }
}
