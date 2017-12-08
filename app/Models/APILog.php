<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 11/15/2017
 * Time: 4:44 PM
 */

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

class APILog
{
    public function log_d($function_name, $data) {
        $data_writeable = json_encode($data);
        $sep = " - ";

        $fp = fopen('api.log', 'a');
        fwrite($fp, date('Y-m-d H:i:s'));
        fwrite($fp, $sep);
        fwrite($fp, $function_name);
        fwrite($fp, $sep);
        fwrite($fp, $data_writeable);
        fwrite($fp, "\n\r");
        fclose($fp);

        return true;
    }
}