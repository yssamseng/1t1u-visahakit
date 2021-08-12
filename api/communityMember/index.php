<?php
require_once '../dbconfig.php';

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['m_id'])) {
        $id = $_GET['m_id'];
        $sql = "SELECT * FROM communityMember where communityMemberId = $id ";
        echo json_encode($db->read($sql), JSON_UNESCAPED_UNICODE);

    }else if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM communityMember where communityEnterpriseId = $id ";
        echo json_encode($db->read($sql), JSON_UNESCAPED_UNICODE);
    }

} else if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
    echo 'This is post' . "\n";
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['gender']) and isset($data['firstName']) and isset($data['lastName']) and isset($data['address']) and isset($data['phoneNumber']) and isset($data['communityEnterpriseId'])) {
        $gender = $data['gender'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $address = $data['address'];
        $phoneNumber = $data['phoneNumber'];
        $communityEnterpriseId = $data['communityEnterpriseId'];

        $sql = "INSERT INTO communityMember
                VALUES ('','$gender','$firstName','$lastName','$address','$phoneNumber','$communityEnterpriseId')";

        echo json_encode($db->Create($sql), JSON_UNESCAPED_UNICODE);
    } else {
        echo $data['firstName'] . "\n";
        echo $data['lastName'] . "\n";
        echo $data['address'] . "\n";
        echo $data['phoneNumber'] . "\n";
        echo $data['communityEnterpriseId'] . "\n";
        echo json_encode("โปรดตรวจสอบการส่งข้อมูลถูกต้องหรือไม่ หรือข้อมูลไม่ครบ", JSON_UNESCAPED_UNICODE);
    }

} else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    echo 'This is PUT' . "\n";
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['gender']) and isset($data['firstName']) and isset($data['lastName']) and isset($data['address']) and isset($data['phoneNumber']) and isset($data['communityEnterpriseId']) and isset($data['communityMemberId'])) {
        $gender = $data['gender'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $address = $data['address'];
        $phoneNumber = $data['phoneNumber'];
        $communityEnterpriseId = $data['communityEnterpriseId'];
        $id = $data['communityMemberId'];

        $sql = "UPDATE communityMember SET
                gender = '$gender',
                firstName = '$firstName',
                lastName = '$lastName',
                address = '$address',
                phoneNumber = '$phoneNumber',
                communityEnterpriseId = $communityEnterpriseId
                WHERE communityMemberId = $id ";

        echo json_encode($db->Update($sql), JSON_UNESCAPED_UNICODE);
    } else {
        echo $data['firstName'] . "\n";
        echo $data['lastName'] . "\n";
        echo $data['address'] . "\n";
        echo $data['phoneNumber'] . "\n";
        echo $data['communityEnterpriseId'] . "\n";
        echo $data['communityMemberId'] . "\n";

        echo json_encode("โปรดตรวจสอบการส่งข้อมูลถูกต้องหรือไม่ หรือข้อมูลไม่ครบ", JSON_UNESCAPED_UNICODE);
    }

} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    echo "This is Delete\n";
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['communityMemberId'])) {
        $id = $data['communityMemberId'];
        $sql = "DELETE FROM communityMember WHERE communityMemberId = $id  ";

        echo json_encode($db->Update($sql), JSON_UNESCAPED_UNICODE);

    }else if (isset($data['communityEnterpriseId'])) {
        $id = $data['communityEnterpriseId'];
        $sql = "DELETE FROM communityMember WHERE communityEnterpriseId = $id  ";

        echo json_encode($db->Update($sql), JSON_UNESCAPED_UNICODE);

    }
    else {
        echo $data['communityMemberId'] . "\n";

        echo json_encode("โปรดตรวจสอบการส่งข้อมูลถูกต้องหรือไม่ หรือข้อมูลไม่ครบ", JSON_UNESCAPED_UNICODE);
    }

} else {
    http_response_code(405);
}
