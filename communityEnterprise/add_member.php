<?php
include('../bootstrap/bootstrap5.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> เพิ่มสมาชิก </title>
</head>

<body>
    <div id="app" v-for="data in info">
        <ul class="nav bg-light p-2">
            <li class="nav-item">
                <a class="nav-link active " aria-current="page" href="../index.php">Home</a>
            </li>
        </ul>


        <div class="container">
            <div class="jumbotron">
                <center>
                    <h1>เพิ่มสมาชิก</h1>
                </center>
            </div>

            <div style="max-width: 500px;">

                <div class="form-group">
                    <label class="col-form-label">โปรดระบุเพศ :</label>
                    <input type="radio" id="male" name="gender" value="นาย" v-model="data.gender">
                    <label for="male">ชาย</label>
                    <input type="radio" id="female" name="gender" value="นางสาว" v-model="data.gender">
                    <label for="female">หญิง</label><br>
                </div>

                <div class="form-group">
                    <label class="col-form-label">ชื่อ</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="firstname" v-model="data.firstName">
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <label class="col-form-label">สกุล</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="lastname" v-model="data.lastName">
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <label class="col-form-label">ทีอยู่</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" name="address" v-model="data.address"></textarea>
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <label class="col-form-label">โทรศัพท์</label>
                    <div class="col-sm-10">
                        <input type="text" maxlength="10" class="form-control" name="phoneNumber" v-model="data.phoneNumber" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                    </div>
                </div>
                <br>


                <br>
                <div class="row">
                    <div class="col">
                        <a class="btn btn-info btn-round" :href="'member.php?id='+id">ย้อนกลับ</a>
                    </div>
                    <div class="col">
                        <input type="submit" name="submit" class=" btn btn-success" v-on:click="addMember()" value="เพิ่มข้อมูล">
                    </div>
                </div>

            </div>
        </div>
    </div>



    <script>
        const getUrlAddr = window.location.search;
        const urlParams = new URLSearchParams(getUrlAddr);
        const id = urlParams.get('id');


        var app = new Vue({
            el: '#app',
            data: {
                apiUrl: 'http://localhost/www/training/api/communityMember',
                id: id,
                info: [{
                    firstName: null,
                    lastName: null,
                    address: null,
                    phoneNumber: null,
                    gender: null
                }],
            },
            methods: {
                addMember: function() {
                    let data = this.info[0];
                    if (this.info[0]['gender'] &&
                        this.info[0]['firstName'] &&
                        this.info[0]['lastName'] &&
                        this.info[0]['address'] &&
                        this.info[0]['phoneNumber']) {
                        axios({
                                method: 'options',
                                url: this.apiUrl,
                                data: {
                                    gender: data['gender'],
                                    firstName: data['firstName'],
                                    lastName: data['lastName'],
                                    address: data['address'],
                                    phoneNumber: data['phoneNumber'],
                                    communityEnterpriseId: this.id
                                }
                            })
                            .then(response => {
                                console.log(response.data);
                                this.alertPass()
                            })
                            .catch(error => {
                                console.log(error);
                            })

                    } else {
                        this.alertNotPass()

                    }
                },
                alertPass: function() {
                    swal({
                        title: "เพิ่มข้อมูลสำเร็จ",
                        text: "คุณได้ทำการเพิ่มข้อมูลสำเร็จแล้ว",
                        icon: "success",
                        button: "ตกลง",
                    }).then((res) => {
                        window.location.href = 'member.php?id=' + this.id
                    });
                },
                alertNotPass: function() {
                    swal({
                        title: "เพิ่มข้อมูลไม่สำเร็จ",
                        text: "การเพิ่มข้อมูลของคุณไม่สำเร็จ โปรดตรวจสอบข้อมูลอีกครั้ง",
                        icon: "warning",
                        button: "ตกลง",
                    }).then((res) => {

                    });
                }
            },
        })
    </script>


</body>

</html>