<?php
session_start();
requireValidSession();

// if (!isset($_GET['update'])) {
//   throw new AppException('Usuario não informado');
// }

$exception = null;

if (count($_POST) > 0)
    try {
        $newUser = new User($_POST);

        $isAdmin = isset($_POST['is_admin']) ? $_POST['is_admin'] : false;

        // var_dump($isAdmin);
        $isAdmin = $isAdmin == 'on' ? true : false;
        // var_dump($isAdmin);
        $newUser->is_admin = $isAdmin;

        // var_dump($newUser);
        $newUser->insert();
        addSuccessMsg('usuário cadastrado com sucesso!');
        $_POST = [];
    } catch (Exception $e) {
        $exception = $e;
    }

loadTemplateView('save_user', $_POST + ['exception' => $exception]);
