<?php

namespace Tests\Unit;

use App\Repository\Eloquents\MoveRepository;
use App\Repository\Eloquents\PlayerRepository;
use App\Service\BoardService;
use App\Service\BotService;
use App\Service\MoveService;
use App\Service\PlayerService;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BotServiceTest extends TestCase
{

    public function testBotPlay(){
        $app=new Container();
        $playerRepo=new PlayerRepository($app);
        $moveRepo=new MoveRepository($app);

        $boardService=new BoardService();
        $moveService=new MoveService($moveRepo,$boardService);

        $playerService=new PlayerService($playerRepo,$boardService,$moveService);
        $botService=new BotService($playerRepo,$playerService);

        $board=[
            ["","O","X"],
            ["O","","O"],
            ["","O","X"]
        ];

        $response=$botService->play(1,$board);
        $this->assertNotNull($response);
        $this->assertNotNull($response['x']);
        $this->assertNotNull($response['y']);
    }


    public function testBotPlayOnFilledBoard(){
        $app=new Container();
        $playerRepo=new PlayerRepository($app);
        $moveRepo=new MoveRepository($app);

        $boardService=new BoardService();
        $moveService=new MoveService($moveRepo,$boardService);

        $playerService=new PlayerService($playerRepo,$boardService,$moveService);
        $botService=new BotService($playerRepo,$playerService);

        $board=[
            ["X","O","X"],
            ["O","X","O"],
            ["O","O","X"]
        ];

        $response=$botService->play(1,$board);
        $this->assertNotNull($response);
        $this->assertNotNull($response['board']);
        $this->assertNull($response['x']);
        $this->assertNull($response['y']);
    }
}
