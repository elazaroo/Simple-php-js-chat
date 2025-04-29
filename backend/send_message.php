<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $message = htmlspecialchars(trim($_POST['message']));
    
    if (!empty($username) && !empty($message)) {
        if (file_exists('../messages.txt') && filesize('../messages.txt') > 0) {
            $jsonContent = file_get_contents('../messages.txt');
            $messages = json_decode($jsonContent, true);
            if ($messages === null) {
                $messages = [];
            }
        } else {
            $messages = [];
        }
        
        $newMessage = [
            'id' => count($messages) + 1,
            'username' => $username,
            'message' => $message,
            'timestamp' => time()
        ];
        $messages[] = $newMessage;
        file_put_contents('../messages.txt', json_encode($messages));
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success']);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>