<?php
class Model //обеспечивает доступ к информации для просмотра, записи, отбора.
{
    protected $link;

    public function __construct()
    {
        $this->link = mysqli_connect("localhost", "kchat_site", "", "kchat_site")
            or die("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
    }
}
