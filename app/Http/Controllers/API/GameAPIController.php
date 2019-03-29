<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Service\BoardService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameAPIController extends AppBaseController
{
    private $characters=['X','O'];

    public function start(Request $request,BoardService $boardService){
        $fullname=$request->get('fullname');
        $character=$request->get('character');
//        $computer=
        $board=$boardService->createBoard();
        $response=[
            'fullname'=>$fullname,
            'character'=>$character,
            'computer'=>'x', //TODO: Fix this xter
            'board'=>$board
        ];

        return $this->sendResponse($response,'Game Started Successfully.');
    }

}
