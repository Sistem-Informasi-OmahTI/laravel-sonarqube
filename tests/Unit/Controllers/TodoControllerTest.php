<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Mockery;
use App\Repositories\TodoRepository;
use App\Http\Controllers\TodoController;
use App\Todo;
use App\Constants\ResponseMessage;

class TodoControllerTest extends TestCase
{
    private function getTodoObject()
    {
        $todo = new Todo();
        $todo->id = 1;
        $todo->value = "value";
        $todo = $todo->toArray();
        return $todo;
    }

    public function test_index_success()
    {
        $mock = $this->mockeryMock(TodoRepository::class);
        $mock->shouldReceive('all')->once()->andReturn([$this->getTodoObject()]);

        $response = $this->call('GET', '/api')->getOriginalContent();
        $this->assertEquals(true, $response['success']);
        $this->assertEquals([$this->getTodoObject()], $response['data']);
    }

    public function test_store_success()
    {
        $mock = $this->mockeryMock(TodoRepository::class);
        $mock->shouldReceive('create')->with(Mockery::any())
                ->once()
                ->andReturn($this->getTodoObject());

        $response = $this->json('POST', '/api', $this->getTodoObject())
                        ->getOriginalContent();

        $this->assertEquals(true, $response['success']);
        $this->assertEquals($this->getTodoObject(), $response['data']);
    }

    public function test_store_exception()
    {
        $mock = $this->mockeryMock(TodoRepository::class);
        $mock->shouldReceive('create')->with(Mockery::any())
                ->once()
                ->andThrow(new \Exception);

        $response = $this->json('POST', '/api', $this->getTodoObject())
                        ->getOriginalContent();

        $this->assertEquals(false, $response['success']);
    }

    public function test_show_success()
    {
        $mock = $this->mockeryMock(TodoRepository::class);
        $mock->shouldReceive('findOrFail')->with(Mockery::any())
                ->once()
                ->andReturn($this->getTodoObject());

        $response = $this->json('GET', '/api/1')
                ->getOriginalContent();

        $this->assertEquals(true, $response['success']);
        $this->assertEquals($this->getTodoObject(), $response['data']);
    }

    public function test_show_exception_not_found()
    {
        $mock = $this->mockeryMock(TodoRepository::class);
        $mock->shouldReceive('findOrFail')->with(Mockery::any())
                ->once()
                ->andThrow(new \Illuminate\Database\Eloquent\ModelNotFoundException);

        $response = $this->json('GET', '/api/1')
                ->getOriginalContent();

        $this->assertEquals(false, $response['success']);
        $this->assertEquals(ResponseMessage::DATA_NOT_FOUND, $response['message']);
    }

    public function test_show_exception_generic()
    {
        $mock = $this->mockeryMock(TodoRepository::class);
        $mock->shouldReceive('findOrFail')->with(Mockery::any())
                ->once()
                ->andThrow(new \Exception);

        $response = $this->json('GET', '/api/1')
                ->getOriginalContent();

        $this->assertEquals(false, $response['success']);
        $this->assertEquals(ResponseMessage::GENERIC_ERROR, $response['message']);
    }
}
