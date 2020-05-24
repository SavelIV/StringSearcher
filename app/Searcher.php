<?php

namespace app;

/**
 * Класс поиска совпадения
 */
class Searcher
{
  //функция поиска заданной строки в текст.файле
  public function search($file, $sub_string)
  {

    //преобразуем спецсимволы (против XSS)
    $sub_string = htmlspecialchars($sub_string);

    if (file_exists($file) && file_get_contents($file)) {

      //получаем mime-type файла
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $file_mime =  finfo_file($finfo, $file);
      finfo_close($finfo);



      //подключаем массив с разрешенными параметрами
      $paramsPath = dirname(__FILE__) . '\fileparams.php';
      $params = include($paramsPath);

      //разрешенные mime-types
      $acceptedMime = $params['mime_types'];
      //разрешенный макс. размер файла
      $acceptedFileSize = $params['max_file_size'];

      //если не наш mime-type
      if (!in_array($file_mime, $acceptedMime, true) === true) {
        echo 'mime-type файла ' . $file . ' не соответствует требованиям.';
        return false;
      }

      //если не наш размер
      if (filesize($file) > $acceptedFileSize) {
        echo 'Размер файла ' . $file . ' превышает 8 Mb.';
        return false;
      }

      //откр. файл на чтение
      $f = fopen($file, "rb") or die("Не удается открыть файл " . $file);

      //делим файл на строки по переносу строки
      $strings = explode("\n", fread($f, filesize($file)));

      //закр. файл
      fclose($f);


      foreach ($strings as $string_num => $string_content) {

        //преобразуем спецсимволы (против XSS)
        $string_content = htmlspecialchars($string_content);
        //счетчик номера строки
        $string_num++;

        //ищем вхождения без учета регистра
        if (stripos($string_content, $sub_string) !== false) {

          //начальная позиция подстроки в строке (преобразуем в спецсимволы обратно, чтобы корректно считать позиции)
          $substr_position = stripos(htmlspecialchars_decode($string_content), $sub_string) + 1;

          echo '<hr> Искомая строка ' . $sub_string . ' встречается в заданном файле <br>' . $file . '<br> в строке номер: '
            . $string_num . ', в позиции от начала строки: ' . $substr_position . '<br> Содержание всей этой строки: ' . $string_content;
        }
      }

      //если нет совпадений
      if (!$substr_position) {
        echo 'Искомая строка ' . $sub_string . ' в файле ' . $file . ' не найдена.';
        return false;
      }
    } else {
      echo 'Файл ' . $file . ' не существует или пуст.';
      return false;
    }
    return true;
  }
}
