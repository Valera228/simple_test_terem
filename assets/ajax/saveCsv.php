<?php
/**
 * Сохранение данных из CSV-фаила в базу данных
 */
if (!empty($_REQUEST["ajax"]) && $_REQUEST["action"] === "save_csv_data")
{
    // Автозагрузка стриптов
    include($_SERVER["DOCUMENT_ROOT"] . "/autoload.php");
    // Получение данных конфигурационного файла
    $config = include $_SERVER["DOCUMENT_ROOT"] . '/config.php';

    // Парсинг файла
    $parser = new \Valera\Parser($config["csv_file"], $config["db"]);
    if (!empty($parser->error)) {
        echo $parser->error;
        return;
    }

    // Сохранение в БД
    $res = $parser->saveToBd();
    echo $res;
}