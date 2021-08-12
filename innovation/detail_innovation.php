<?php
include('../bootstrap/bootstrap5.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Innovation</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="getAddress1.js"></script>
</head>

<body>
    <div id="app" v-for="data in info">
        <div class="jumbotron text-center">
            <h1>รายละเอียด นวัตกรรม </h1>
        </div>
        <br>
        <br>

        <div class="form- text-center">
            <div class="row">
                <label for="name" class="col-sm-3 control-label">ชื่อ นวัตกรรม</label>
                <div class="col-sm-3">
                    <p>{{data.innovationName}}</p>
                </div>
            </div>
        </div>

        <br>

        <div class="form- text-center">
            <div class="row">
                <label for="Detail" class="col-sm-3 control-label">แหล่งที่มา</label>
                <div class="col-sm-3">
                    <p>{{data.background}}</p>
                </div>
            </div>
        </div>

        <br>

        <div class="form- text-center">
            <div class="row">
                <label for="appropriate" class="col-sm-3 control-label">ความเหมาะสม/สอดคล้องกับพื้นที่</label>
                <div class="col-sm-3">
                    <p>{{data.consistent}}</p>
                </div>
            </div>
        </div>

        <br>

        <div class="form- text-center">
            <div class="row">
                <label for="Detail" class="col-sm-3 control-label">รายละเอียดอื่นๆ</label>
                <div class="col-sm-3">
                    <p>{{data.otherDetail}}</p>
                </div>
            </div>
        </div>

        <br>

        <div class="form- text-center">
            <div class="row">
                <label class="col-sm-3 control-label">ที่อยู่</label>
                <div class="col-sm-3">
                    <p>ตำบล {{data.districts}} || อำเภอ {{data.amphures}} || จังหวัด {{data.provinces}}</p>
                </div>
            </div>
        </div>

        <br>

        <div class="form-group text-center">
            <a href="index.php" class="btn btn-warning">ย้อนกลับ</a>
            <a class="btn btn-danger" id="del" onclick="delData()"> ลบ</a>
            <a class="btn btn-info" v-on:click="updatelink()"> แก้ไข</a>
        </div>
    </div>
    </div>
</body>


<script>
    const getUrlAddr = window.location.search;
    const urlParams = new URLSearchParams(getUrlAddr);
    const id = urlParams.get('id');

    var app = new Vue({
        el: '#app',
        data: {
            apiUrl: 'http://localhost/www/training/api/innovation/?id=',
            info: []
        },
        methods: {
            getData: function() {

                if (id)
                    this.apiUrl = this.apiUrl + id;

                axios.get(this.apiUrl)
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

    let apiUrl = 'http://localhost/www/training/api/innovation/?id=';

    function delData() {
        axios({
                method: 'delete',
                url: apiUrl,
                data: {
                    innovationId: id
                }
            })
            .then(function(response) {
                console.log(response);
                alert('Delete success');
                window.location.href = 'index.php';
            })
            .catch(function(error) {
                console.log(error);
            })
    }

    function updatelink() {
        window.location.href = 'edit_innovation.php?id=' + id;
    }
</script>

</html>