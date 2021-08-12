<?php
include('../bootstrap/bootstrap5.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Innovation</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="getAddress1.js"></script>
</head>

<body>
    <div id="app" v-for="data in info">
        <ul class="nav bg-light p-2">
            <li class="nav-item">
                <a class="nav-link active " aria-current="page" href="../index.php">Home</a>
            </li>
        </ul>

        <div class="jumbotron">
            <h1 class="text-center">เพิ่ม นวัตกรรม</h1>

            <div class="form- text-center">
                <div class="row">
                    <label for="name" class="col-sm-3 control-label">ชื่อ นวัตกรรม</label>
                    <div class="col-sm-6">
                        <input type="text" name="tct_name" class="form-control" placeholder="ชื่อ นวัตกรรม"
                            v-model="data.innovationName">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <input type="checkbox" v-model="isChild" onchange="getProvince()">
                    <label for="checkbox">หากเป็นวิสาหกิจกลุ่มย่อยให้กดเครื่องหมายถูก และเลือกวิสาหกิจหลัก</label>
                </div>
            </div>

            <div v-if='isChild'>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-1">
                        <select v-model='isComSelect'>
                            <option v-for='isCom in isComEnter' v-bind:value='isCom.communityEnterpriseId'
                                :disabled='isCom.communityEnterpriseId == 0'
                                :selected='isCom.communityEnterpriseId == 0'>
                                {{isCom.communityEnterpriseName}}
                            </option>
                        </select>
                    </div>
                </div>

                <!-- getAddressCode when have isChild-->
                <div v-for="isCom in isComEnter" hidden>
                    <input type="text"
                        v-bind:value="isCom.communityEnterpriseId == isComSelect? isComAddressCode = isCom.addressCode : ''">
                </div>
            </div>


            <br>

            <div class="form- text-center">
                <div class="row">
                    <label for="Detail" class="col-sm-3 control-label">แหล่งที่มา</label>
                    <div class="col-sm-6">
                        <textarea name="txt_bg" rows="4" cols="133" placeholder="แหล่งที่มาของนวัตกรรม"
                            v-model="data.background"></textarea>
                    </div>
                </div>
            </div>

            <br>

            <div class="form- text-center">
                <div class="row">
                    <label for="appropriate" class="col-sm-3 control-label">ความเหมาะสม/สอดคล้องกับพื้นที่</label>
                    <div class="col-sm-6">
                        <input type="text" name="txt_appropriate" class="form-control"
                            placeholder="ความเหมาะสม/สอดคล้องกับพื้นที่" v-model="data.consistent">
                    </div>
                </div>
            </div>

            <br>

            <div class="form- text-center">
                <div class="row">
                    <label for="Detail" class="col-sm-3 control-label">รายละเอียดอื่นๆ</label>
                    <div class="col-sm-6">
                        <textarea name="txt_detail" rows="4" cols="133" placeholder="รายละเอียดต่างๆ"
                            v-model="data.otherDetail"></textarea>
                    </div>
                </div>
            </div>

            <br>
            <div v-if='isChild == false'>
                <div class="form- text-center">
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

                <div class="form- text-center">
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

                <div class="form= text-center">
                    <div class="row">
                        <label class="col-sm-3 control-label">ตำบล</label>
                        <div class="col-sm-1">
                            <select id="district" v-model="data.addressCode">
                                <option value="">--โปรดเลือกตำบล--</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="form-group text-center">
                <input type='submit' class="btn btn-success" value="เพิ่ม" v-on:click="AddData()">
                <a href="index.php" class="btn btn-danger">ย้อนกลับ</a>
            </div>
        </div>

    </div>

    <script>
    var app = new Vue({
        el: '#app',
        data: {
            apiUrl: 'http://localhost/www/training/api/innovation',
            info: [{
                innovationName: null,
                background: null,
                consistent: null,
                otherDetail: null,
                addressCode: null,
                isComEnterprise: null,
            }],
            isComEnter: [{
                communityEnterpriseId: 0,
                communityEnterpriseName: ' --โปรดเลือกกลุ่มวิสาหกิจ-- '
            }],
            isChild: false,
            isComSelect: 0,
            isComAddressCode: 0,
            addressCode: null
        },
        methods: {
            AddData: function() {

                if (this.isChild && this.isComSelect == 0 || this.isChild == false && this.info[0]
                    .addressCode == null) {
                    this.alertNotPass();
                } else {

                    if (this.isChild == true && this.isComSelect != 0) {
                        this.addressCode = this.isComAddressCode;
                    } else {
                        this.isComSelect = 0;
                        this.addressCode = this.info[0].addressCode;
                    }
                    let data = this.info[0];

                    if (data['innovationName'] == null || data['innovationName'] == '' &&
                        data['background'] == null || data['background'] == '' &&
                        data['consistent'] == null || data['consistent'] == '' &&
                        data['therDetail'] == null || data['therDetail'] == '' &&
                        data['addressCode'] == null || data['addressCode'] == '' &&
                        data['isComEnterprise'] == null || data['isComEnterprise'] == '') {
                        this.alertNotPass()
                    } else {
                        axios({
                                method: 'options',
                                url: this.apiUrl,
                                data: {
                                    innovationName: data['innovationName'],
                                    background: data['background'],
                                    consistent: data['consistent'],
                                    otherDetail: data['otherDetail'],
                                    addressCode: this.addressCode,
                                    isComEnterprise: this.isComSelect,
                                }
                            })
                            .then(response => {
                                console.log(response.data);
                                this.alertPass()
                            })
                            .catch(error => {
                                console.log(error);
                            })
                    }
                }

            },
            getParent: function() {
                let url = 'http://localhost/www/training/api/communityEnterprise';
                axios.get(url)
                    .then(response => {
                        response.data.map(i => {
                            this.isComEnter.push(i)
                        })
                        console.log(this.isComEnter);
                    })
                    .catch(error => {
                        console.log(error);
                    })
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
            this.getParent()
        }
    })
    </script>

</body>

</html>