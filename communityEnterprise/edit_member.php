<?php
    include('../bootstrap/bootstrap5.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> แก้ไขสมาชิก </title>


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
                    <h1>แก้ไขสมาชิก</h1>
                </center>
            </div>

            <div style="max-width: 500px;">

                <div class="form-group">
                    <label class="col-form-label">โปรดระบุเพศ :</label>
                    <input type="radio" id="male" name="gender"  value="นาย" :checked="data.gender == 'นาย'">
                    <label for="male">ชาย</label>
                    <input type="radio" id="female" name="gender"  value="นางสาว" :checked="data.gender == 'นางสาว'">
                    <label for="female">หญิง</label><br>
                </div>

                <div class="form-group">
                    <label class="col-form-label">ชื่อ</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="data.firstName" required>
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <label class="col-form-label">สกุล</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="data.lastName" required>
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <label class="col-form-label">ทีอยู่</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" v-model="data.address" required></textarea>
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <label class="col-form-label">โทรศัพท์</label>
                    <div class="col-sm-10">
                        <input type="text" maxlength="10" class="form-control" v-model="data.phoneNumber" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                    </div>
                </div>
                <br>


                <br>
                <div class="row">
                    <div class="col">
                        <a class="btn btn-info" :href="'member.php?id=' + id">ย้อนกลับ</a>
                    </div>
                    <div class="col">
                        <input type="submit" name="submit" id="submit" class=" btn btn-success"
                            v-on:click="updateData()" value="อัพเดตข้อมูล">
                    </div>
                </div>

            </div>
        </div>
    </div>



    <script>
    const getUrlAddr = window.location.search;
    const urlParams = new URLSearchParams(getUrlAddr);
    const id = urlParams.get('id');
    const m_id = urlParams.get('m_id');

    var app = new Vue({
        el: '#app',
        data: {
            apiUrl: 'http://localhost/www/training/api/communityMember?m_id=',
            id: id,
            m_id: m_id,
            info: []


        },
        methods: {
            getData: function() {
            this.apiUrl = this.apiUrl + this.m_id;
            axios.get(this.apiUrl)
                .then(response => {
                    console.log(response.data);
                    this.info = response.data;
            
                })
                .catch(error => {
                    console.log(error);
                })
        },
            updateData: function() {
                this.apiUrl = this.apiUrl;
                if (
                    this.info[0]['gender'] &&
                    this.info[0]['firstName'] &&
                    this.info[0]['lastName'] &&
                    this.info[0]['address'] &&
                    this.info[0]['phoneNumber']) {

                    axios({
                            method: 'put',
                            url: this.apiUrl,
                            data: {
                                gender: this.info[0]['gender'],
                                communityMemberId: this.m_id,
                                firstName: this.info[0]['firstName'],
                                lastName: this.info[0]['lastName'],
                                address: this.info[0]['address'],
                                phoneNumber: this.info[0]['phoneNumber'],
                                communityEnterpriseId: this.id,
                            }
                        })
                        .then(response => {
                            console.log(response.data);
                            this.alertPass();
                        })
                        .catch(error => {
                            console.log(error);
                        })


                } else {
                    this.alertNotPass();
                }

            },

            alertPass: function() {
                swal({
                    title: "แก้ไขข้อมูลสำเร็จ",
                    text: "ข้อมูลของคุณได้รับการแก้ไขแล้ว",
                    icon: "success",
                    button: "ตกลง",
                }).then((res) => {
                    window.location.href = "member.php?id= "+ this.id
                });
            },
            alertNotPass: function() {
                swal({
                    title: "แก้ไขข้อมูลไม่สำเร็จ",
                    text: "ข้อมูลของคุณไม่ได้รับการแก้ไข โปรดตรวจสอบข้อมูลอีกครั้ง",
                    icon: "warning",
                    button: "ตกลง",
                }).then((res) => {

                });
            }
        },
        beforeMount() {
            this.getData()
        }
    })
    </script>



</body>

</html>