<?php
loadModel('Login');
$exception = null;

if (count($_POST) > 0) {
    $login =  new Login($_POST);
    try {
        $user = $login->checkLogin();
        header("Location: /day_records");
    } catch (Exception $e) {
        $exception = $e;
        // echo "Falha no login: $exception";
        //faz um log
        //$this->logger->warning($error);
    }
}

loadView('login', $_POST + [
    'exception' => $exception,
]);
