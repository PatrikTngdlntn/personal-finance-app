<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * @var string
     */
    protected $model;

    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }
}
