<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 11/16/2017
 * Time: 9:13 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Support\Facades\DB;

class Group extends Model
{
    protected $table="group";
}