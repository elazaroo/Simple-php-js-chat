<?php
header('Content-Type: application/json');

$lastId = isset($_GET['last_id']) ? (int)$_GET['last_id'] : 0;

if (file_exists('../messages.txt')) {
    $messages = json_decode(file_get_contents('../messages.txt'), true) ?: [];
    // Filter messages newer than lastId
    $newMessages = array_filter($messages, function($msg) use ($lastId) {
        return $msg['id'] > $lastId;
    });
    echo json_encode(array_values($newMessages));
} else {
    echo json_encode([]);
}
?>