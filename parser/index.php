<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Form</title>
        <meta name="description" content="lorem ipsum">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    </head>
    <body>
        <?
        use Valera\MysqliConnect;
        // Автозагрузка стриптов
        include($_SERVER["DOCUMENT_ROOT"] . "/autoload.php");
        // Получение данных конфигурационного файла
        $config = include $_SERVER["DOCUMENT_ROOT"] . '/config.php';
        // Подключение в БД
        $mysqli = MysqliConnect::getInstance($config["db"]);
        // Получение количества записей в таблице
        $arResult["COUNT"] = $mysqli->getCount();
        // Количество элементов на странице
        $elemOnPage = $config["elem_on_page"];
        // Текущая страница
        $currentPage = !empty($_REQUEST["PAGE"]) ? $_REQUEST["PAGE"] : 1;
        // Начальная строка
        $currentRow = ($currentPage - 1) * $elemOnPage;
        // Выбранные элементы из БД
        $arResult["ELEMENTS"] = $mysqli->getElements($currentRow, $elemOnPage);
        // Количество страниц пагинатора
        $arResult["PAGE_COUNT"] = ceil($arResult["COUNT"]/$elemOnPage);
        ?>

        <div class="container">
            <div class="row my-4">
                <div class="col col-12">
                    <button type="button" class="btn btn-primary" data-bind="save-csv">
                        Загрузить данные из CSV-фаила
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col col-12">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr class="table-info">
                                <th scope="col">ID</th>
                                <th scope="col">NAME</th>
                                <th scope="col">VALUE1</th>
                                <th scope="col">VALUE2</th>
                                <th scope="col">VALUE3</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?foreach ($arResult["ELEMENTS"] as $element):?>
                                <tr>
                                    <?foreach ($element as $data):?>
                                        <td><?=$data?></td>
                                    <?endforeach;?>
                                </tr>
                            <?endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>

            <nav>
                <ul class="pagination justify-content-center">
                    <?for ($i=1; $i <= $arResult["PAGE_COUNT"]; $i++):?>
                        <?if ($i == $currentPage):?>
                            <li class="page-item active" aria-current="page">
                                <a class="page-link" href="?PAGE=<?=$i?>"><?=$i?></a>
                            </li>
                        <?else:?>
                            <li class="page-item">
                                <a class="page-link" href="?PAGE=<?=$i?>"><?=$i?></a>
                            </li>
                        <?endif;?>
                    <?endfor;?>
                </ul>
            </nav>

        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
        <script src="../assets/js/csv.js"></script>
    </body>
</html>