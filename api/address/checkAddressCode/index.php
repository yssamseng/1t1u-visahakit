<?php

    require_once('../../dbconfig.php');

    $db = new Database();

    if ($_SERVER['REQUEST_METHOD'] == "GET"){
    
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $sql = "SELECT d.id as district_id, d.name_th as district, a.id as amphure_id, a.name_th as amphure, p.id as province_id, p.name_th as province FROM `districts` d JOIN amphures a JOIN provinces p ON d.amphure_id = a.id and a.province_id = p.id and d.id = $id";
            echo json_encode($db->Read($sql), JSON_UNESCAPED_UNICODE);
        }else{
            echo json_encode("not found id or 'addressCode'");
        }
    }else {
        
    }

?>
