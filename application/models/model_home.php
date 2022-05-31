<?php

class Model_Home extends Model
{
    public function get_login()
    {
        return $_SESSION['login'];
    }

    public function get_id()
    {
        return $_SESSION['id'];
    }

    public function search_chat()
    {
        $data = $_SESSION['id'];
        $pageData = array();
        $query = "select `name_chat`,`chat_id` from `party`, `chat` where 
                                                        party.person_id='$data' and party.chat_id=chat.id";
        $about_chat = mysqli_query($this->link, $query);
        if ($about_chat && (mysqli_num_rows($about_chat)) > 0) {
            while ($row = mysqli_fetch_assoc($about_chat)) {
                $pageData[$row["name_chat"]] = 'http://localhost/kchat/home/chat?chat_id=' . $row["chat_id"];
            }
        } else {
            return false;
        }
        return $pageData;
    }

    public function add_chat($name_chat): bool
    {
        $data = $_SESSION['id'];
        //добавляем новый чат
        $insert = "insert into `chat` (`name_chat`,`id_admin`) values ('$name_chat','$data')";
        //  добавляем новый чат                && налаживаем связь в чате
        if (mysqli_query($this->link, $insert) && $this->add_party($data, $name_chat, $data)) {
            return true;
        } else {
            echo "Произошла ошибка при выполнении запроса";
            return false;
        }
    }

    public function add_party($user_id, $name_chat, $data): bool
    {
        //получаем id чата
        $query = "select `id` from `chat` where `name_chat`='$name_chat' and `id_admin`='$data'";
        $result = mysqli_query($this->link, $query);
        $chat_id = mysqli_fetch_assoc($result);
        $id = $chat_id['id'];
        //налаживаем связь в чате
        $insert = "insert into `party` (`chat_id`,`person_id`) values ('$id','$user_id')";
        if (mysqli_query($this->link, $insert)) {
            return true;
        } else {
            return false;
        }
    }

    function logout_user()
    {
        unset($_POST);
        session_destroy();
        header("location: http://localhost/kchat/");
    }
}
