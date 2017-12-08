<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 11/15/2017
 * Time: 6:02 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackController extends Controller
{
    public function Login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        $io_token = $request->input('io_token');
        $android_token = $request->input('android_token');
    }
}