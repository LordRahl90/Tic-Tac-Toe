<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Service\BoardService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GameAPIController extends AppBaseController
{
    private $characters=['X'=>'X','O'=>'O'];

    public function start(Request $request,BoardService $boardService){


        $v=Validator::make($request->all(),[
            'fullname'=>'required',
            'character'=>[
                'required',
                Rule::in(['O','X'])
            ]
        ]);

        if($v->fails()){
            return $this->sendError($v->messages()->all(),400);
        }

        $fullname=$request->get('fullname');
        $character=$request->get('character');
        $board=$boardService->createBoard();
        $response=[
            'fullname'=>$fullname,
            'character'=>$character,
            'computer'=>$character=='X'?'O':'X',
            'board'=>$board
        ];

        session([uniqid('user-')=>[
            'fullname'=>$fullname,
            'character'=>$character
        ]]);

        return $this->sendResponse($response,'Game Started Successfully.');
    }

}
