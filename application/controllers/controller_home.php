<?php

class Controller_Home extends Controller
{
    public function __construct()
    {
        $this->model = new Model_Home();
        $this->view = new View();
    }

    function index()
    {
        if (!isset($_SESSION['login'])){
            header("Location: http://localhost/kchat/");
        }
        $this->pageData['title'] = "KChat-Домашняя";
        $this->pageData['login'] = $this->model->get_login();
        //если сразу перейти на эту страницу без логина, то кидает туда авто
        //кнопка выхода
        if (isset($_POST['logout'])) {
            $this->model->logout_user();
        }
        //список чатов
        if (!$this->pageData ['chats'] = $this->model->search_chat()) {
            $this->pageData['error'] = "У вас пока нет чатов.";
        }
        //кнопка создать чат
        if (isset($_POST['name_chat']) && isset($_POST['add_chat']) && !isset($_POST['cancel'])) {
            //тут обращение к бд и создание чата
            if ($this->model->add_chat($_POST['name_chat'])) {
                $this->pageData ['chats'] = $this->model->search_chat();
            }
            unset($_POST);
        }
        //кнопка отмены создания чата
        if (isset($_POST['cancel'])) {
            unset($_POST);
        }
        $this->view->generate('home_view.php',
             $this->pageData);
    }
}
