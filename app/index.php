<?php

namespace app;


//подключ. автозагрузчика
require_once('..\vendor\autoload.php');

//подключение библиотеки
require_once(dirname(__FILE__) . '\Searcher.php');

// имя текстового файла для поиска
$file = (dirname(__FILE__) . '\files\4_entries.txt');


// подстрока, совпадение с которой нужно найти
$sub_string  = 'something';

//проверка
//$sub_string  = '<script>alert("test");</script>';

//вызов объекта класса
$searcher = new Searcher;
$searcher->search($file, $sub_string);
