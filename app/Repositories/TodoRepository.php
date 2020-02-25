<?php

namespace App\Repositories;

use App\Todo;

class TodoRepository
{
  protected $todo;  

  public function __construct(Todo $todo)
  {
    $this->todo = $todo;
  }

  public function all()
  {
    return $this->todo->all();
  }

  public function create($data)
  {
    return $this->todo->create($data);
  }

  public function findOrFail($id)
  {
    return $this->todo->findOrFail($id);
  }
}