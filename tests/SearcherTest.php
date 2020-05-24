<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use app\Searcher;

require_once dirname(__FILE__) . '\..\app\Searcher.php';

class SearcherTest extends TestCase
{
  /**
   * Mime-type не разрешен
   */

  public function testWrongMimeType()
  {
    $searcher = new Searcher();

    // подстрока, совпадение с которой нужно найти
    $sub_string  = 'something';

    // имя текстового файла для поиска
    $file = (dirname(__FILE__) . '\..\app\files\wrong_mime.php');

    $this->expectOutputString('mime-type файла ' . $file . ' не соответствует требованиям.');
    print($searcher->search($file, $sub_string));
  }

  /**
   * Размер файла превышает допустимые пределы
   */
  public function testTooBigFile()
  {
    $searcher = new Searcher();

    // подстрока, совпадение с которой нужно найти
    $sub_string  = 'something';

    // имя текстового файла для поиска
    $file = (dirname(__FILE__) . '\..\app\files\too_big_file.txt');

    $this->expectOutputString('Размер файла ' . $file . ' превышает 8 Mb.');
    print($searcher->search($file, $sub_string));
  }

  /**
   * Файлл пустой или не существует
   */
  public function testEmptyOrNoExistFile()
  {
    $searcher = new Searcher();

    // подстрока, совпадение с которой нужно найти
    $sub_string  = 'something';

    // имя текстового файла для поиска
    $file = (dirname(__FILE__) . '\..\app\files\empty_file.txt');

    $this->expectOutputString('Файл ' . $file . ' не существует или пуст.');
    print($searcher->search($file, $sub_string));
  }

  /**
   * Нет совпадений
   */
  public function testNoEntries()
  {
    $searcher = new Searcher();

    // подстрока, совпадение с которой нужно найти
    $sub_string  = 'something';

    // имя текстового файла для поиска
    $file = (dirname(__FILE__) . '\..\app\files\no_entries.txt');

    $this->expectOutputString('Искомая строка ' . $sub_string . ' в файле ' . $file . ' не найдена.');
    print($searcher->search($file, $sub_string));
  }

  /**
   * Есть совпадения
   */
  public function testHasEntries()
  {
    $searcher = new Searcher();

    // подстрока, совпадение с которой нужно найти
    $sub_string  = 'something';

    // имя текстового файла для поиска
    $file = (dirname(__FILE__) . '\..\app\files\4_entries.txt');

    $this->assertTrue($searcher->search($file, $sub_string));
  }
}
