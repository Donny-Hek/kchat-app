<?php

class View //данным, которые запрашиваются у «Модели», задается вид их вывода
{
//$content_view,
    public function generate($content_view,$template_view, $pageData)
    {
        if (is_array($pageData)) {
            // преобразуем элементы массива в переменные
            extract($pageData);
        }
        include 'application/views/' . $template_view;
    }
}
