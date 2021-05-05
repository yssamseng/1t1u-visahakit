<?php
    require_once('../dbconfig.php');


    $db = new Database('localhost','1t1u','root','');

    if ($_SERVER['REQUEST_METHOD'] == "GET"){
        echo json_encode($db->query('SELECT * FROM innovation'));
    }else if ($_SERVER['REQUEST_METHOD'] == "POST"){
        echo 'This is post';
    }else {
        http_response_code(405);
    }

?>


