<?php

//$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

//socket_bind($sock, '0.0.0.0', 8000);

//socket_listen($sock, 0);

/* while ($read = socket_read($sock, 2048, PHP_BINARY_READ)) {
    echo $read;
} */

//$socket = socket_create_listen(8001);
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($socket, '0.0.0.0', 8000);
socket_listen($socket, 0);
socket_set_nonblock($socket);
//socket_select()
while ($connSocket = socket_accept($socket)) {
    /* socket_getpeername($connSocket, $teste, $porta);
    var_dump($teste);
    var_dump($porta); */
    $readBuffer = '';
    while ($teste = socket_recv($connSocket, $readBuffer, 10, MSG_WAITALL)) {
        var_dump($teste);
    }
    var_dump($readBuffer);
    echo $readBuffer;
    /* while ($data = socket_read($connSocket, 10, )) {
        $readBuffer += $data;
        //echo "[$data]";
        //echo '['.$data.']';
        echo ".";
        //echo strlen($data)."\n";
        if ()
    } */
    echo 'ok, data all read';

    //$write = "426 Upgrade Required"
    //socket_write($connSocket, $write);
}

var_dump(socket_last_error());
var_dump(SOCKET_EWOULDBLOCK);
