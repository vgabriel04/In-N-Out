<?php
$errors = [];
$message = [
    'type' => '',
    'message' => ''
];

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
} elseif (isset($exception)) {
    $message = [
        'type' => 'error',
        'message' => $exception->getMessage()
    ];
    if (get_class($exception) === 'ValidationException') {
        $errors = $exception->getErrors();
    }
}

$alertType = '';

if ($message['type'] === 'error') {
    $alertType = 'danger';
} elseif ($message['type'] === 'success') {
    $alertType = 'success';
}
?>

<?php if (isset($message['message'])) : ?>
    <div role="alert" class="my-3 alert alert-<?= $alertType ?>">
        <?= $message['message'] ?>
    </div>
<?php endif ?>