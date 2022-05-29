<?php

class Controller //обработать информацию, которую вводит пользователь, а также обновить Model
{
    public $model;
    public $view;
    protected $pageData=array();

    public function __construct()
    {
        $this->model = new Model();
        $this->view = new View();
    }

    function index()
    {
        // это действие, вызывается в реализации классов потомков
    }
}
