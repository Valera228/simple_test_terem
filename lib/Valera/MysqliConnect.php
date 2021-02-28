<?php

namespace Valera;

class MysqliConnect
{
    private static $oObject = null;
    private ?\mysqli $mysqli = null;
    public string $connectError = "";

    /**
     * MysqliConnect constructor.
     * @param array $config - конфиг для подключения к БД
     */
    private function __construct(array $config)
    {
        $this->mysqli = new \mysqli($config["url"], $config["user"], $config["pass"], $config["name"]);
        if ($this->mysqli->connect_error) {
            $this->connectError = "Не удалось подключиться к MySQL: " . $this->mysqli->connect_error;
        }
    }

    /**
     * Инстанс класса
     * @param array $config
     * @return MysqliConnect|null
     */
    public static function getInstance(array $config): ?MysqliConnect
    {
        if (null === self::$oObject)
        {
            self::$oObject = new self($config);
        }

        return self::$oObject;
    }

    /**
     * Добавление или обновление данных в таблице
     * @param $data - данные для добавления в таблицу
     * @return bool|\mysqli_result
     */
    public function saveData($data)
    {
        $res = $this->mysqli->query('INSERT INTO `data` (ID,NAME,VALUE1,VALUE2,VALUE3) VALUES ' . $data .
            ' ON DUPLICATE KEY UPDATE NAME=VALUES(NAME), VALUE1=VALUES(VALUE1), VALUE2=VALUES(VALUE2), VALUE3=VALUES(VALUE3)');

        return $res;
    }

    /**
     * Подсчет кол-ва элементов в таблице
     * @return int
     */
    public function getCount()
    {
        $res = $this->mysqli->query('SELECT COUNT(ID) as count FROM `data`');
        return intval($res->fetch_assoc()["count"]);
    }

    /**
     * Получение элементов из таблицы
     * @param $currentRow - начальная строка
     * @param $countRow - количество выбираемых элементов
     * @return mixed
     */
    public function getElements($currentRow, $countRow)
    {
        $res = $this->mysqli->query('SELECT * FROM `data` LIMIT ' . $currentRow . ',' . $countRow . '');
        return $res->fetch_all();
    }
}