<?php
include('../bootstrap/bootstrap5.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ผลิตภัณฑ์</title>
</head>

<body>
    <div id="app" v-for="data in info">
        <ul class="nav bg-light p-2">
            <li class="nav-item">
                <a class="nav-link active " aria-current="page" href="index.php">Home</a>
            </li>
        </ul>
        <div class="container mt-3">
            <h1>{{ title }} {{ data.communityEnterpriseName }}</h1>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="">รายละเอียด</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " :href="'product.php?id=' + id">ผลิตภัณฑ์</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " :href="'member.php?id=' + id">สมาชิก</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :href="'childCommunity.php?id=' + id">วิสาหกิจกลุ่มย่อย</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :href="'innovation/?id='+id">นวัตกรรม</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :href="'technology/?id='+id">เครื่องมือและเทคโนโลยี</a>
                </li>
            </ul>

            <div class="mt-3">
                <label style="font-weight: 700; font-size: 16px;">ที่มา</label>
                <p>&nbsp&nbsp{{ data.background }}</p>

                <label style="font-weight: 700; font-size: 16px;">สถานที่ขาย</label>
                <p>&nbsp&nbsp{{ data.placeOrder }}</p>

                <label style="font-weight: 700; font-size: 16px;">วันที่จดทะเบียน</label>
                <p>&nbsp&nbsp{{ data.registrationDate}}</p>
                <br>
                <br>
                <label style="font-weight: 700; font-size: 16px;">ติดต่อ</label>
                <p>&nbsp&nbsp {{ data.phoneNumber }} </p>

                <label style="font-weight: 700; font-size: 16px;">ที่อยู่</label>
                <p>&nbsp&nbsp {{ data.districts }} {{ data.amphures }} {{ data.provinces }}</p>
            </div>

            <div class="form-group text-center mt-5">
                <a href="index.php" class="btn btn-warning">ย้อนกลับ</a>
                <a class="btn btn-danger" id="del" v-on:click="deleteData()"> ลบ</a>
                <a class="btn btn-info" v-on:click="updatelink()"> แก้ไข</a>
            </div>

        </div>
    </div>

</body>

<script>
const getUrlAddr = window.location.search;
const urlParams = new URLSearchParams(getUrlAddr);
const id = urlParams.get('id');

new Vue({
    el: '#app',
    data: {
        title: 'วิสาหกิจ',
        apiUrl: 'http://localhost/www/training/api/communityEnterprise/?id=',
        id: id,
        info: []

    },
    methods: {
        getData: function() {
            if (id){
                this.apiUrl = this.apiUrl + id;
            }
            axios.get(this.apiUrl)
                .then(response => {
                    this.info = response.data;
                    console.log(this.info);
                })
                .catch(error => {
                    console.log(error);
                })
        },
        deleteData:function() {
            let apiUrlEnterprise = 'http://localhost/www/training/api/communityEnterprise';
            let apiUrlProduct = 'http://localhost/www/training/api/communityProduct';
            let apiUrlMember = 'http://localhost/www/training/api/communityMember';

            //delete product reference
            axios({
                method: 'delete',
                url: apiUrlProduct,
                data: {
                    communityEnterpriseId: id
                }
            })
            .then(function(response) {
                console.log(response.data);
            })
            .catch(function(error) {
                console.log(error);
            })

            //delete Member reference
            axios({
                method: 'delete',
                url: apiUrlMember,
                data: {
                    communityEnterpriseId: id
                }
            })
            .then(function(response) {
                console.log(response.data);
            })
            .catch(function(error) {
                console.log(error);
            })

            axios({
                method: 'delete',
                url: apiUrlEnterprise,
                data: {
                    communityEnterpriseId: id
                }
            })
            .then(function(response) {
                console.log(response.data);
                alert('ลบข้อมูลสำเร็จ');
                window.location.href = 'index.php';
            })
            .catch(function(error) {
                console.log(error);
            })
        },
        updatelink:  function() {
            window.location.href = 'updateGroup.php?id=' + id;
        }
    },
    beforeMount() {
        this.getData()
    }

})

</script>

</html>