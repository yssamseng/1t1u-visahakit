<?php
include '../bootstrap/bootstrap5.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลวิสาหกิจชุมชน</title>
    <script src="getAddressC.js"></script>
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
                    <h1>เพิ่มข้อมูลวิสาหกิจชุมชน</h1>
                </center>
            </div>

            <div style="max-width: 800px;">

                <div class="form-group">
                    <label class="col-form-label">ชื่อกลุ่ม</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="data.communityEnterpriseName">
                    </div>
                </div>


                <input type="checkbox" v-model="isChild" onchange="getProvince()">
                <label for="checkbox"> หากเป็นวิสาหกิจกลุ่มย่อยให้กดเครื่องหมายถูก และเลือกวิสาหกิจหลัก</label>

                <div v-if="isChild">
                    <select v-model="ChildGroupData">
                        <option v-for="parent in ParentData" v-bind:value="parent.communityEnterpriseId"
                            :disabled="parent.communityEnterpriseId === 0">
                            {{ parent.communityEnterpriseName }}
                        </option>
                    </select>
                </div>

                <!-- getAddressCode when have isChild-->
                <div v-for="parents in ParentData" hidden>
                    <input type="text"
                        v-bind:value="parents.communityEnterpriseId == ChildGroupData? ChildGroupAddrCode = parents.addressCode : ''">
                </div>




                <div class="form-group">
                    <label class="col-form-label">ที่มา</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" v-model="data.background"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label">สถานที่ขาย</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="data.placeOrder">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label">โทรศัพท์</label>
                    <div class="col-sm-10">
                        <input type="text" maxlength="10" class="form-control" v-model="data.phoneNumber" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label">วันที่จดทะเบียน</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" v-model="data.registrationDate">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword3" class="col-form-label">ที่อยู่</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" v-model="data.address"></textarea>
                    </div>
                </div>

                <br>

                <div v-if="isChild == false">
                    <div class="form text-center">
                        <div class="row">
                            <label class="col-sm-3 control-label">จังหวัด</label>
                            <div class="col-sm-1">
                                <select id="province" onChange="getAmphure()">
                                    <option value="">--โปรดเลือกจังหวัด--</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="form text-center">
                        <div class="row">
                            <label class="col-sm-3 control-label">อำเภอ</label>
                            <div class="col-sm-1">
                                <select id="amphure" onChange="getDistrict()">
                                    <option value="">--โปรดเลือกอำเภอ--</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="form text-center">
                        <div class="row">
                            <label class="col-sm-3 control-label">ตำบล</label>
                            <div class="col-sm-1">
                                <select id="district" v-model="data.addressCode">
                                    <option value="">--โปรดเลือกตำบล--</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <br>
                </div>



                <div class="form-group text-center">
                    <a class="btn btn-warning" :href="'index.php'">ย้อนกลับ</a>
                    <a class="btn btn-info" id="put" v-on:click="postData()">เพิ่มข้อมูล</a>
                </div>
                <br>
            </div>


        </div>

    </div>


    <script>
    var app = new Vue({
        el: '#app',
        data: {
            apiUrl: 'http://localhost/www/training/api/communityEnterprise',
            info: [{
                communityEnterpriseName: null,
                background: null,
                placeOrder: null,
                registrationDate: null,
                phoneNumber: null,
                address: null,
                addressCode: 0,
                isChildGroup: null
            }],

            ParentData: [{
                communityEnterpriseId: 0,
                communityEnterpriseName: '--เลือกวิสาหกิจหลัก--'
            }],
            isChild: false,
            ChildGroupData: 0,
            ChildGroupAddrCode: 0,
            addressCode: null
        },
        methods: {
            postData: function() {

                if (this.isChild && this.ChildGroupData == 0 || this.isChild == false && this.info[0]
                    .addressCode == '') {
                    this.alertNotPass();

                } else {
                    if (this.isChild == true && this.ChildGroupData != 0) {
                        this.addressCode = this.ChildGroupAddrCode;
                    } else {
                        this.ChildGroupData = 0;
                        this.addressCode = this.info[0].addressCode;
                    }
                    //alert(addressCode);
                    let data = this.info[0];
                    axios({
                            method: 'options',
                            url: this.apiUrl,
                            data: {
                                communityEnterpriseName: data['communityEnterpriseName'],
                                background: data['background'],
                                placeOrder: data['placeOrder'],
                                registrationDate: data['registrationDate'],
                                phoneNumber: data['phoneNumber'],
                                address: data['address'],
                                addressCode: this.addressCode,
                                isChildGroup: this.ChildGroupData
                            }
                        })
                        .then(response => {
                            console.log(response.data);
                            //alert('เพิ่มข้อมูลสำเร็จ');
                            this.alertPass();
                            //window.location.href = 'index.php';
                        })
                        .catch(error => console.log(error))
                }
            },
            getComEnterprise: function() {
                let url = 'http://localhost/www/training/api/communityEnterprise';
                axios.get(url)
                    .then(response => {
                        // isChildGroup == 0 is a parent
                        response.data
                            .filter(value => value.isChildGroup == 0)
                            .map(value => this.ParentData.push(value))
                        console.log(this.ParentData);
                    })
                    .catch(error => console.log(error))
            },

            alertPass: function() {
                swal({
                    title: "เพิ่มข้อมูลสำเร็จ",
                    text: "คุณได้ทำการเพิ่มข้อมูลสำเร็จแล้ว",
                    icon: "success",
                    button: "ตกลง",
                }).then((res) => {
                    window.location.href = 'index.php'
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
        beforeMount() {
            this.getComEnterprise()
        }
    })
    </script>

</body>

</html>