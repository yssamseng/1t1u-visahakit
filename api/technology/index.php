<?php
    header('Content-Type: application/json');
    require_once('../dbconfig.php');

    
    $db = new Database();

    if ($_SERVER['REQUEST_METHOD'] == "GET"){
        $sql = "SELECT technologyId, technologyName, background, consistent, otherDetail, isComEnterprise, addressCode,
                d.name_th as districts, a.name_th as amphures, p.name_th as provinces  
                FROM `technology` JOIN `districts` d JOIN `amphures` a JOIN `provinces` p 
                ON d.amphure_id = a.id and a.province_id = p.id and d.id = addressCode";

        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $sql = "SELECT technologyId, technologyName, background, consistent, otherDetail, isComEnterprise, addressCode,
                    d.name_th as districts, a.name_th as amphures, p.name_th as provinces  
                    FROM `technology` JOIN `districts` d JOIN `amphures` a JOIN `provinces` p 
                    ON d.amphure_id = a.id and a.province_id = p.id and d.id = addressCode and technologyId = $id ";
        }
        
        echo json_encode($db->read($sql));

    }else if ($_SERVER['REQUEST_METHOD'] == "OPTIONS"){
        echo 'This is post';
        $data = json_decode(file_get_contents('php://input'), true);

        $name = $data['technologyName'];
        $background = $data['background'];
        $consistent = $data['consistent'];
        $otherDetail = $data['otherDetail'];
        $isComEnterprise = $data['isComEnterprise'];
        $addressCode = $data['addressCode'];

        echo $name ."\n";
        echo $background ."\n";
        echo $consistent ."\n";
        echo $otherDetail ."\n";
        echo $isComEnterprise ."\n";
        echo $addressCode ."\n";

        $sql = "INSERT INTO technology
                VALUES ('','$name','$background','$consistent','$otherDetail','$isComEnterprise','$addressCode')";

        echo json_encode($db->Create($sql));

    }else if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
        echo 'This is PUT';
        $data = json_decode(file_get_contents('php://input'), true);

        $id = $data['technologyId'];
        $name = $data['technologyName'];
        $background = $data['background'];
        $consistent = $data['consistent'];
        $otherDetail = $data['otherDetail'];
        $isComEnterprise = $data['isComEnterprise'];
        $addressCode = $data['addressCode'];

        echo $id ."\n";
        echo $name ."\n";
        echo $background ."\n";
        echo $consistent ."\n";
        echo $otherDetail ."\n";
        echo $isComEnterprise ."\n";
        echo $addressCode ."\n";

        $sql = "UPDATE technology SET 
                technologyName = '$name',
                background = '$background',
                consistent = '$consistent',
                otherDetail = '$otherDetail',
                isComEnterprise = '$isComEnterprise',
                addressCode = '$addressCode'
                WHERE technologyId = $id ";

        echo json_encode($db->Update($sql));

    }else if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        echo "This is Delete\n";
        $data = json_decode(file_get_contents('php://input'), true);

        $id = $data['technologyId'];
        
        echo $id ."\n";

        $sql = "DELETE FROM technology WHERE technologyId = $id ";

        echo json_encode($db->Delete($sql));

    }else {
        http_response_code(405);
    }

?>