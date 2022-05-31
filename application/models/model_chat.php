<?php

class Model_Chat extends Model
{
    public function get_info($chat_id): array//общая инфа по чату
    {
        $result = array();
        //имя чата + админ чата
        $query = "select `name_chat`,`id_admin` from `chat` where `id`='$chat_id'";
        $res = mysqli_query($this->link, $query);//имя чата и ид админ
        $res = mysqli_fetch_assoc($res);
        $result['name_chat'] = $res['name_chat'];
        $query = "select `login` from `person` where `id`=" . $res['id_admin'];
        $res = mysqli_query($this->link, $query);
        $res = mysqli_fetch_assoc($res);
        $result['login_admin'] = $res['login'];
        $result['chat_id'] = $chat_id;
        return $result;
    }

    public function get_party($chat_id)//получить список участиков чата
    {
        $result = array();
        $query = "select `id`,`login` from `party`,`person` where party.chat_id='$chat_id' and person.id=party.person_id";
        $res = mysqli_query($this->link, $query);
        $res = mysqli_fetch_all($res);
        foreach ($res as $num => $re) {
            $result[$re[0]] = $re[1];
        }
        return $result;
    }

    public function get_messages($chat_id)
    {
        $query = "select `text_m`, `chat_id`, `person_id`, `send_date` from `messages` where `chat_id`='$chat_id' order by `send_date`";
        $res = mysqli_query($this->link, $query);
        $pageData = array();
        if ($res && (mysqli_num_rows($res) > 0)) {
            while ($result = mysqli_fetch_assoc($res)) {
                array_push($pageData, $result);
            }
        }
        return $pageData;
    }

    public function set_message($text, $chat_id, $person_id, $date)
    {
        $query = "INSERT INTO `messages`(`text_m`, `chat_id`, `person_id`, `send_date`) 
        VALUES ('$text','$chat_id','$person_id','$date')";;
        $res = mysqli_query($this->link, $query);
        if ($res) return true;
        else return false;
    }

    public function add_party($user_login, $chat_id): bool
    {
        //получаем id того, кого добавляем
        $query = "select `id` from `person` where `login`='$user_login'";
        $result = mysqli_query($this->link, $query);
        $user_id = mysqli_fetch_assoc($result);
        if ($user_id == null) return false;
        else {
            $user_id = $user_id['id'];
            $insert = "insert into `party` (`chat_id`,`person_id`) values ('$chat_id','$user_id')";
            if (mysqli_query($this->link, $insert)) return true;
            else return false;
        }
    }
}
