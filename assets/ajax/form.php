<?php
if (!empty($_REQUEST["form"])) {
    echo json_encode([
        "status" => "success",
        "message" => "Данные формы пришли на сервер"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Данные формы не попали на сервер"
    ]);
}