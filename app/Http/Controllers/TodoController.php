<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\TodoRepository;
use App\Todo;
use App\Utils\ResponseHandler;
use App\Constants\HttpStatus;
use App\Constants\ResponseMessage;

class TodoController extends Controller
{
    public function __construct(TodoRepository $todoRepo)
    {
        $this->todoRepo = $todoRepo;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ResponseHandler::create()
                ->isSuccess()
                ->data($this->todoRepo->all())
                ->send();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $todo = $this->todoRepo->create($request->all());
            return ResponseHandler::create()
                ->isSuccess()
                ->data($todo)
                ->send(HttpStatus::OK);
        } catch (\Exception $e) {
            return ResponseHandler::create()
                ->isFailed()
                ->message(ResponseMessage::GENERIC_ERROR)
                ->send(HttpStatus::OK);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $todo = $this->todoRepo->findOrFail($id);
            return ResponseHandler::create()
                ->isSuccess()
                ->data($todo)
                ->send(HttpStatus::OK);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ResponseHandler::create()
                ->isFailed()
                ->message(ResponseMessage::DATA_NOT_FOUND)
                ->send(HttpStatus::OK);
        } catch (\Exception $e) {
            return ResponseHandler::create()
                ->isFailed()
                ->message(ResponseMessage::GENERIC_ERROR)
                ->send(HttpStatus::OK);
        }
    }
}
