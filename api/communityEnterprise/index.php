<?php

require_once '../dbconfig.php';

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $sql = "SELECT communityEnterpriseId, communityEnterpriseName, background, placeOrder, DATE_FORMAT(registrationDate, '%d %M %Y') as registrationDate, phoneNumber,
            address, addressCode, isChildGroup, d.name_th as districts, d.id as district_id, a.name_th as amphures, a.id as amphure_id, p.name_th as provinces, p.id as province_id
            FROM `communityenterprise` c JOIN `districts` d JOIN amphures a JOIN provinces p
            ON d.amphure_id = a.id and a.province_id = p.id and d.id = addressCode";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT communityEnterpriseId, communityEnterpriseName, background, placeOrder, DATE_FORMAT(registrationDate, '%Y-%m-%d') as registrationDate, phoneNumber,
            address, addressCode, isChildGroup, d.name_th as districts, a.name_th as amphures, p.name_th as provinces
            FROM `communityenterprise` JOIN `districts` d JOIN amphures a JOIN provinces p
            ON d.amphure_id = a.id and a.province_id = p.id and d.id = addressCode and communityEnterpriseId = $id";

    }
    echo json_encode($db->Read($sql));

} else if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    echo "This is post\n";
    $data = json_decode(file_get_contents('php://input'), true);
    //print_r($data);
    //echo file_get_contents('php://input');
    $name = $data['communityEnterpriseName'];
    $background = $data['background'];
    $placeOrder = $data['placeOrder'];
    $regisDate = $data['registrationDate'];
    $phone = $data['phoneNumber'];
    $address = $data['address'];
    $addressCode = $data['addressCode'];
    $isChildGroup = $data['isChildGroup'];

    echo $name . "\n";
    echo $background . "\n";
    echo $placeOrder . "\n";
    echo $regisDate . "\n";
    echo $phone . "\n";
    echo $address . "\n";
    echo $addressCode . "\n";
    echo $isChildGroup . "\n";

    $sql = "INSERT INTO  communityenterprise
        VALUES ('','$name','$background','$placeOrder','$regisDate','$phone','$address','$addressCode','$isChildGroup') ";

    echo json_encode($db->Create($sql));

} else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    echo "This is PUT\n";
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['communityEnterpriseId'];
    $name = $data['communityEnterpriseName'];
    $background = $data['background'];
    $placeOrder = $data['placeOrder'];
    $regisDate = $data['registrationDate'];
    $phone = $data['phoneNumber'];
    $address = $data['address'];
    $addressCode = $data['addressCode'];
    $isChildGroup = $data['isChildGroup'];

    echo $id . "\n";
    echo $name . "\n";
    echo $background . "\n";
    echo $placeOrder . "\n";
    echo $regisDate . "\n";
    echo $phone . "\n";
    echo $address . "\n";
    echo $addressCode . "\n";
    echo $isChildGroup . "\n";

    $sql = "UPDATE communityEnterprise SET
        communityEnterpriseName = '$name',
        background = '$background',
        placeOrder = '$placeOrder',
        registrationDate = '$regisDate',
        phoneNumber = '$phone',
        address = '$address',
        addressCode = '$addressCode',
        isChildGroup = '$isChildGroup'
        WHERE communityEnterpriseId = '$id' ";

    echo json_encode($db->Update($sql));

} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    echo "This is Delete\n";
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['communityEnterpriseId'];

    echo $id . "\n";

    $sql = "DELETE FROM communityEnterprise WHERE communityEnterpriseId = $id ";

    echo json_encode($db->Delete($sql));

} else {
    http_response_code(405);
}
