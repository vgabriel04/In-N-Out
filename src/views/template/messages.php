<?php
$errors = [];
$exception = null; //ver essa exception

if ($exception ) {
    $message = [
        'type' => 'error',
        'message' => $exception->getMessage()
    ];

    if (get_class($exception) === 'ValidationException') {
        $errors = $exception->getErrors();
    }
}

if (isset($message)) {

    $alertType = '';

    if ($message['type'] === 'error') {
        $alertType = 'danger';
    } else {
        $alertType = 'success';
    }
}
?>

<?php if (isset($message)) : ?>
    <div role="alert" class="my-3 alert alert-<?= $alertType ?>">
        <?= $message['message'] ?>
    </div>
<?php endif ?>