<?php

class Controller_Index extends Controller
{
    public function __construct()
    {
        $this->model = new Model_Index();
        $this->view = new View();
    }

    function index()
    {
        $this->pageData['title'] = "KChat-Вход";
        if (isset($_POST['register_login']) && isset($_POST['register_password'])) {
            $this->register();
        } elseif (isset($_POST['auth_login']) && isset($_POST['auth_password'])) {
            $this->login();
        }
        $this->view->generate('auth_view.php',
            'template_view.php', $this->pageData);
    }

    public function login()
    {
        $login = htmlspecialchars(trim($_POST['auth_login']));
        $password = htmlspecialchars(trim($_POST['auth_password']));
        if (!$this->model->login_user($login, $password)) {
            $this->pageData['error2'] = "Введите верно логин и пароль";
            return false;
        }
    }

    public function register()
    {
        $login = htmlspecialchars(trim($_POST['register_login']));
        $password = htmlspecialchars(trim($_POST['register_password']));

        if (strlen($password) < 5) {
            $this->pageData['error1'] = "Длина пароля не может быть меньше 
            5 символов. Попробуйте еще раз";
            return false;
        }
        if (!$this->model->register_user($login, $password)) {
            $this->pageData['error1'] = "Такой логин уже существует";
            return false;
        }
    }
}
