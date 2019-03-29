<?php

namespace Tests\Unit;

use App\Service\BoardService;
use App\Service\Exceptions\BadIndexException;
use App\Service\Exceptions\InvalidCharacterException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BoardServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }


    public function testCreateBoard(){
        $boardService=new BoardService();
        $newBoard=$boardService->createBoard();

        $this->assertTrue(count($newBoard)>0);
        $this->assertTrue(count($newBoard)<=3);
        $this->assertEquals(3,count($newBoard));
        $this->assertEquals(3,count($newBoard[0]));
    }

    public function testAddToBoard(){
        $boardService=new BoardService();
        $board=$boardService->createBoard();
        try{
            $newBoard=$boardService->addToBoard($board,"O",1,2);
            $this->assertEquals("O",$newBoard[1][2]);
        }
        catch(BadIndexException $e){
            $this->assertNull($e);
        }
        catch(InvalidCharacterException $e){
            $this->assertNull($e);
        }
    }


    public function testAddWrongItemToBoard(){
        $boardService=new BoardService();
        $board=$boardService->createBoard();

        try{
            $newBoard=$boardService->addToBoard($board,"A",1,2);
            $this->assertEquals("",$newBoard[1][2]);
        }
        catch(BadIndexException $e){
            $this->assertNull($e);
        }
        catch(InvalidCharacterException $e){
            $this->assertNotNull($e);
        }
    }

    public function testAddWrongXIndex(){
        $boardService=new BoardService();
        $board=$boardService->createBoard();

        try{
            $newBoard=$boardService->addToBoard($board,"O",3,2);
            $this->assertEquals("",$newBoard[1][2]);
        }
        catch(BadIndexException $e){
            $this->assertNotNull($e);
        }
        catch(InvalidCharacterException $e){
            $this->assertNull($e);
        }
    }

    public function testAddWrongYIndex(){
        $boardService=new BoardService();
        $board=$boardService->createBoard();

        try{
            $newBoard=$boardService->addToBoard($board,"O",1,3);
            $this->assertEquals("",$newBoard[1][2]);
        }
        catch(BadIndexException $e){
            $this->assertNotNull($e);
        }
        catch(InvalidCharacterException $e){
            $this->assertNull($e);
        }
    }
}
