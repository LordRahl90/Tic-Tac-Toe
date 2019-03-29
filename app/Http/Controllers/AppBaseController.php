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
    public function sendResponse($result, $message)
    {
        return Response::json([
            'success'=>true,
            'message'=>$message,
            'data'=>$result
        ],200);
    }

    public function sendError($error, $code = 404)
    {
        return Response::json([
            'success'=>false,
            'message'=>$error
        ], $code);
    }

}