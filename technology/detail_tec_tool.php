<?php
include('../bootstrap/bootstrap5.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าแสดงรายละเอียดของเทคโนโลยี</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
</head>

<body>
    <ul class="nav bg-light p-2">
        <li class="nav-item">
            <a class="nav-link active " aria-current="page" href="../index.php">Home</a>
        </li>
    </ul>

    <div class="jumbotron text-center">
        <h1> เพิ่ม เครื่องมือและเทคโนโลยี </h1>
    </div>
    <br>
    <div id="app" v-for="data in info">
        <form method="post" class="form-horizontal mt-5">
            <div class="form- text-center">
                <div class="row">
                    <label for="name" class="col-sm-3 control-label"> ชื่อ เครื่องมือและเทคโนโลยี </label>
                    <div class="col-sm-3">
                        <p> {{data.technologyName}} </p>
                    </div>
                </div>
            </div>

            <br>

            <div class="form- text-center">
                <div class="row">
                    <label for="name" class="col-sm-3 control-label"> แหล่งที่มา </label>
                    <div class="col-sm-3">
                        <p> {{data.background}} </p>
                    </div>
                </div>
            </div>

            <br>

            <div class="form- text-center">
                <div class="row">
                    <label for="name" class="col-sm-3 control-label"> ความเหมาะสม/สอดคล้องกับพื้นที่ </label>
                    <div class="col-sm-3">
                        <p> {{data.consistent}} </p>
                    </div>
                </div>
            </div>

            <br>

            <div class="form- text-center">
                <div class="row">
                    <label for="name" class="col-sm-3 control-label"> รายละเอียดอื่นๆ </label>
                    <div class="col-sm-3">
                        <p> {{data.otherDetail}} </p>
                    </div>
                </div>
            </div>

            <br>

            <div class="form- text-center">
                <div class="row">
                    <label class="col-sm-3 control-label">ที่อยู่</label>
                    <div class="col-sm-3">
                        <p> ตำบล {{data.districts}} || อำเภอ {{data.amphures}} || จังหวัด {{data.provinces}} </p>
                    </div>
                </div>
            </div>

            <br>

            <div class="form-group text-center">
                <a href="index.php" class="btn btn-warning"> ย้อนกลับ </a>
                <a class="btn btn-danger" id="del" onclick="delData()"> ลบ </a>
                <a class="btn btn-info" :href="'edit_tec_tool.php?id=' + id"> แก้ไข </a>
            </div>

        </form>
    </div>
</body>

<script>
const getUrlAddr = window.location.search;
const urlParams = new URLSearchParams(getUrlAddr);
const id = urlParams.get('id');

var app = new Vue({
    el: '#app',
    data: {
        apiUrl: 'http://localhost/www/training/api/technology/?id=',
        id: id,
        info: []
    },
    methods: {
        getData: function() {
            axios.get(this.apiUrl + id)
                .then(response => {
                    console.log(response.data);
                    this.info = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
        }
    },
    beforeMount() {
        this.getData()
    }
})

let apiUrl = 'http://localhost/www/training/api/technology/?id=';

function delData() {
    axios({
            method: 'delete',
            url: apiUrl,
            data: {
                technologyId: id
            }
        })
        .then(function(response) {
            console.log(response);
            alert('ลบข้อมูลเสร็จสิ้น');
            window.location.href = 'index.php';
        })
        .catch(function(error) {
            console.log(error);
        })
}

function updatelink() {
    window.location.href = 'edit_tec_tool.php?id=' + id;
}
</script>

</html>