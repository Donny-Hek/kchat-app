<?php
require_once("application/models/model_home.php");

class Controller_Chat extends Controller
{
    public function __construct()
    {
        $this->model = new Model_Chat();
        $this->model_home = new Model_Home();
        $this->view = new View();

    }

    function index()
    {
        if (!isset($_SESSION['login'])) {
            header("Location: http://localhost/kchat/");
        }
        $chat_id = $_GET['chat_id'];
        $this->pageData = $this->model->get_info($chat_id);//имя чата + админ чата
        $this->pageData['title'] = "KChat-Чат";
        $this->pageData['login'] = $this->model_home->get_login();
        $this->pageData['id_person'] = $this->model_home->get_id();
        //если админ, то добавляем кнопку и форму поиска
        if ($this->pageData['login'] == $this->pageData['login_admin']) {
            $this->pageData['form_for_admin']['button'] = '<form method="post">
            <input type="submit" name="add_person" value="Работа с пользователями"> <!-- кнопка -->
            </form>';
            $this->pageData['form_for_admin']['form'] =
                '<div style="padding-top: 5px;padding-bottom: 5px; border: 3px solid #f1f1f1;">
                <form method="post">
                            <input type="text" name="search" style="width: 98%">
                            <input type="submit" name="go" value="Добавить"><!-- кнопка -->
                             <!-- поиск по всем пользователям -->
                            <input type="submit" name="cancel" value="Отменить"> <!-- кнопка -->
                        </form>
                    </div>';
        }
        //список всех участников
        $this->pageData['array_party'] = $this->model->get_party($chat_id);

        if (!isset($this->pageData['array_party'][$this->pageData['id_person']])) {
            header("Location: http://localhost/kchat/home");
        }
        //для админа добавление пользователя
        if (isset($_POST['search']) && isset($_POST['go'])) {
            if (in_array($_POST['search'], $this->pageData['array_party'])) {
                $this->pageData['form_for_admin']['error'] = "Этот пользователь уже добавлен";
            } else {
                if (!$this->model->add_party($_POST['search'], $chat_id)) {
                    $this->pageData['form_for_admin']['error'] = "ошибка";
                    unset($_POST);
                }
                $this->pageData['array_party'] = $this->model->get_party($chat_id);
            }
        }
        $this->view->generate("chat_view.php", "template_view.php", $this->pageData);
    }

    function ins_message()
    {
        date_default_timezone_set("Europe/Moscow");
        $this->pageData['id_person'] = $this->model_home->get_id();

        if (isset($_POST['message']) && $_POST['message'] != "" && $_POST['message'] != " ") {
            $message = htmlspecialchars(trim($_POST['message']));
            $date = date("y.m.d/H:i");
            $this->model->set_message($message, $_POST['chat_id'], $this->pageData['id_person'], $date);
        }
    }

    function reload()
    {
        $this->pageData['array_party'] = $this->model->get_party($_POST['chat_id']);
        $this->pageData['array_messages'] = $this->model->get_messages($_POST['chat_id']);
        $this->pageData['id_person'] = $this->model_home->get_id();

        $input = "";

        //свои сообщения
        if (!isset($this->pageData['array_messages'])) echo "В этом чате пока нет сообщений.";
        else {
            foreach ($this->pageData['array_messages'] as $array => $message) {
                //проверяем, написал пользователь сообщение сам или другие
                foreach ($this->pageData['array_party'] as $key => $name) {
                    if ($message['person_id'] == $key) {
                        $name_person = $name;
                    }
                }
                if ($this->pageData['id_person'] == $message['person_id']) {//написал он
                    $input .= "<div style='text-align: left; width: 90%'><p><span style='color: #cf00ff'>
                            (" . $message['send_date'] . ") " .
                        $name_person . ":</span> " .
                        $message['text_m'] . "</p></div>";
                } else {
                    $input .= "<div style='text-align: left;width:90%'><p><span style='color: #41ff00'>
                            (" . $message['send_date'] . ") " .
                        $name_person . ":</span> " .
                        $message['text_m'] . "</p></div>";
                }
            }
        }
        echo $input;
    }
}
