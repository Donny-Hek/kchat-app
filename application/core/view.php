<?php

class View //данным, которые запрашиваются у «Модели», задается вид их вывода
{
    public function __construct()
    {
    }
//$content_view,
    public function generate($template_view, $pageData)
    {
        if (is_array($pageData)) {
            // преобразуем элементы массива в переменные
            extract($pageData);
        }
        include 'application/views/' . $template_view;
    }
//    public function generate2($content_view_static,$content_view_nonstatic, $pageData)
//    {
//        if (is_array($pageData)) {
//            // преобразуем элементы массива в переменные
//            extract($pageData);
//        }
//        if(file_exists('application/views/' . $content_view_static)) {
//            require 'application/views/' . $content_view_static;
//        }
//        if(file_exists('application/views/' . $content_view_nonstatic)) {
//            require 'application/views/' . $content_view_nonstatic;
//        }
//    }
}
