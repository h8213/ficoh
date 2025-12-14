<?php

// Configuración del bot de Telegram
$telegram_bot_id = "8541373947:AAFuEOt9mj-d6ThxhTdcUuBlmZljTnJx1Bs"; // TODO: reemplazar por tu token real y mantenerlo fuera de control de versiones
$chat_id        = "7655000874";                                   // TODO: reemplazar por tu chat id real si cambia

// Leer el mensaje enviado por AJAX
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if ($message === '') {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Mensaje vacío']);
    exit;
}

// Preparar la solicitud a la API de Telegram
$url  = "https://api.telegram.org/bot" . $telegram_bot_id . "/sendMessage";
$data = [
    'chat_id' => $chat_id,
    'text'    => $message,
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
        'timeout' => 10,
    ],
];

$context  = stream_context_create($options);
$result   = @file_get_contents($url, false, $context);

if ($result === false) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'No se pudo contactar con Telegram']);
    exit;
}

echo $result;
