<?php

    require_once('../../dbconfig.php');

    $db = new Database();

    if ($_SERVER['REQUEST_METHOD'] == "GET"){
        $sql = "SELECT id, name_th as districts FROM districts WHERE name_th NOT LIKE '%*%' ORDER BY name_th ";

        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $sql = "SELECT id, name_th as districts FROM districts where amphure_id = $id and name_th NOT LIKE '%*%' order by name_th";
        }
        echo json_encode($db->Read($sql), JSON_UNESCAPED_UNICODE);
        
    }else {
        http_response_code(405);
    }

?>
