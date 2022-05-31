<?php

class Model_Index extends Model
{
    public function login_user($login, $password): bool
    {
        $query = "SELECT * FROM `person` WHERE `login`='$login'";
        $res = mysqli_query($this->link, $query);
        $data = mysqli_fetch_array($res);

        if (empty($data['login']) || $password != $data['password']) {
            return false;
        }
        $_SESSION['login'] = $data['login'];
        $_SESSION['id'] = $data['id'];
        header("location: ".$_SERVER['REQUEST_URI']."./home");
        return true;
    }

    public function register_user($login, $password)
    {
        $query = "SELECT `login` FROM `person` WHERE `login`='$login'";
        $res = mysqli_query($this->link, $query);
        $data = mysqli_fetch_array($res);
        if (!empty($data['login'])) {
            return false;
        }
        $query = "INSERT INTO `person` (`login`,`password`) VALUES('$login','$password') ";
        $result = mysqli_query($this->link, $query) or die("Error!" . mysqli_error());

        if ($result == true) {
            echo "Вы успешно зарегистрированы! <br>Войдите в свою учетную запись";
            return true;
        }
    }
}
