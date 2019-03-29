<?php
/**
 * Created by PhpStorm.
 * User: alugbinabiodun
 * Date: 2019-03-29
 * Time: 14:24
 */

namespace App\Repository\Eloquents;


use App\Repository\Repository;
use App\User;


class UserRepository  extends Repository
{
    function model()
    {
        return User::class;
    }


}