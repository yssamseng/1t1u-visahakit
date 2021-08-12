<?php
require_once '../dbconfig.php';

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['product_id'])) {
        $id = $_GET['product_id'];
        $sql = "SELECT * FROM communityProduct where communityProductId = $id ";
        echo json_encode($db->read($sql), JSON_UNESCAPED_UNICODE);

    }else if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM communityProduct where communityEnterpriseId = $id ";
        echo json_encode($db->read($sql), JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode("Error: โปรดตรวจสอบการส่งค่า id หรือ product_id", JSON_UNESCAPED_UNICODE);
    }

} else if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
    echo 'This is post' . "\n";
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['productName']) and isset($data['productPicture']) and isset($data['productPrice']) and isset($data['productDetail']) and isset($data['placeOrder']) and isset($data['productStandard']) and isset($data['communityEnterpriseId'])) {
        $productName = $data['productName'];
        $productPicture = $data['productPicture'];
        $productPrice = $data['productPrice'];
        $productDetail = $data['productDetail'];
        $placeOrder = $data['placeOrder'];
        $productStandard = $data['productStandard'];
        $communityEnterpriseId = $data['communityEnterpriseId'];


        $sql = "INSERT INTO communityProduct
                VALUES ('','$productName','$productPicture',$productPrice,'$productDetail','$placeOrder','$productStandard',$communityEnterpriseId)";

        echo json_encode($db->Create($sql), JSON_UNESCAPED_UNICODE);

    } else {
        $productName = $data['productName'];
        $productPicture = $data['productPicture'];
        $productPrice = $data['productPrice'];
        $productDetail = $data['productDetail'];
        $placeOrder = $data['placeOrder'];
        $productStandard = $data['productStandard'];
        $communityEnterpriseId = $data['communityEnterpriseId'];
        echo json_encode("โปรดตรวจสอบการส่งข้อมูลถูกต้องหรือไม่ หรือข้อมูลไม่ครบ", JSON_UNESCAPED_UNICODE);
    }

} else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    echo 'This is PUT' . "\n";
    $data = json_decode(file_get_contents('php://input'), true);


    if (isset($data['communityProductId']) and isset($data['productName']) and isset($data['productPicture']) and isset($data['productPrice']) and isset($data['productDetail']) and isset($data['placeOrder']) and isset($data['productStandard']) and isset($data['communityEnterpriseId'])) {
        $id = $data['communityProductId'];
        $productName = $data['productName'];
        $productPicture = $data['productPicture'];
        $productPrice = $data['productPrice'];
        $productDetail = $data['productDetail'];
        $placeOrder = $data['placeOrder'];
        $productStandard = $data['productStandard'];
        $communityEnterpriseId = $data['communityEnterpriseId'];

        $sql = "UPDATE communityProduct SET
                productName = '$productName',
                productPicture = '$productPicture',
                productPrice = $productPrice,
                productDetail = '$productDetail',
                placeOrder = '$placeOrder',
                productStandard = '$productStandard',
                communityEnterpriseId = $communityEnterpriseId
                WHERE communityProductId = $id ";

        echo json_encode($db->Update($sql), JSON_UNESCAPED_UNICODE);
    } else {
        echo $data['productName'] . "\n";
        echo $data['productPicture'] . "\n";
        echo $data['productPrice'] . "\n";
        echo $data['productDetail'] . "\n";
        echo $data['communityEnterpriseId'] . "\n";
        echo $data['communityMemberId'] . "\n";

        echo json_encode("โปรดตรวจสอบการส่งข้อมูลถูกต้องหรือไม่ หรือข้อมูลไม่ครบ", JSON_UNESCAPED_UNICODE);
    }


} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    echo "This is Delete\n";
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['communityProductId'])) {
        $id = $data['communityProductId'];
        $sql = "DELETE FROM communityProduct WHERE communityProductId = $id  ";

        echo json_encode($db->Update($sql), JSON_UNESCAPED_UNICODE);

    }else if (isset($data['communityEnterpriseId'])) {
        $id = $data['communityEnterpriseId'];
        $sql = "DELETE FROM communityProduct WHERE communityEnterpriseId = $id  ";

        echo json_encode($db->Update($sql), JSON_UNESCAPED_UNICODE);

    }
    else {
        echo $data['communityMemberId'] . "\n";

        echo json_encode("โปรดตรวจสอบการส่งข้อมูลถูกต้องหรือไม่ หรือข้อมูลไม่ครบ", JSON_UNESCAPED_UNICODE);
    }

} else {
    http_response_code(405);
}
