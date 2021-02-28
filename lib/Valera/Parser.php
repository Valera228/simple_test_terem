<?php
namespace Valera;

class Parser
{
    private string $file;
    private int $rows = 0;
    private ?MysqliConnect $mysqli;
    public string $error = "";

    /**
     * Parser constructor.
     * @param string $file - путь к файлу
     * @param array $config - конфиг для подключения к БД
     */
    public function __construct(string $file, array $config)
    {
        $this->file = $file;
        $this->mysqli = MysqliConnect::getInstance($config);
        $this->error = $this->mysqli->connectError;
    }

    /**
     * Получение данных из CSV-файла в нужном для записи в БД формате
     * @return string
     */
    private function getFileData(): string
    {
        $arValues = [];
        $this->rows = 1;
        $fileName = $_SERVER["DOCUMENT_ROOT"] . $this->file;
        if (($handle = fopen($fileName, "r")) !== FALSE)
        {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
            {
                $num = count($data);
                $this->rows++;
                $newData = [];
                for ($c=0; $c < $num; $c++) {
                    $newData[] = '"' . $data[$c] .'"';
                }
                $arValues[] = "(" . implode(",", $newData) . ")";
            }
            fclose($handle);
        } else {
            $this->error = "Не удалось прочитать данные из файла " . $fileName;
        }

        return implode(", ", $arValues);
    }

    /**
     * Сохранения данных в БД
     * @return string
     */
    public function saveToBd(): string
    {
        $dataToSave = $this->getFileData();
        $result = $this->mysqli->saveData($dataToSave);

        if ($result) {
            return "Обновлено строк: " . $this->rows;
        } else {
            return "Ошибка обновления";
        }
    }
}