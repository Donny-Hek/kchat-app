<?php
//require_once("application/models/model_home.php");

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
//        echo var_dump($res);
        return $result;
    }

    public function get_messages($chat_id)
    {
        $query = "select `text_m`, `chat_id`, `person_id`, `send_date` from `messages` where `chat_id`='$chat_id'";
        $res = mysqli_query($this->link, $query);
        $pageData = array();
        if ($res && (mysqli_num_rows($res) > 0)) {
            while ($result = mysqli_fetch_assoc($res)) {
//                echo var_dump($result);
                array_push($pageData, $result);
            }
        }
//        $result = mysqli_fetch_assoc($res);
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
}