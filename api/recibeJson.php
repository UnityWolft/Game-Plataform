<?php
function recibeJson() {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    if ($data === null) {
        throw new Exception("JSON inválido o no recibido.");
    }
    return $data;
}
?>