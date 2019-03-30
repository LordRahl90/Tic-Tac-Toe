<?php
/**
 * Created by PhpStorm.
 * User: alugbinabiodun
 * Date: 2019-03-29
 * Time: 13:05
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Response;

class AppBaseController extends Controller
{
    public function sendResponse($result, $message,$code=200)
    {
        return Response::json([
            'success'=>true,
            'message'=>$message,
            'data'=>$result
        ],$code);
    }

    public function sendError($error, $code = 400)
    {
        return Response::json([
            'success'=>false,
            'message'=>$error
        ], $code);
    }

}