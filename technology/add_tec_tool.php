<?php
    include('../bootstrap/bootstrap5.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Tecnology and Tool</title>
    <script src="getAddressT.js"></script>

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
                    <h1>เพิ่ม เครื่องมือและเทคโนโลยี</h1>
                </center>
            </div>

            <div style="max-width: 800px;">

                <div class="form-group">
                    <label class="col-form-label">ชื่อเครื่องมือและเทคโนโลยี</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="data.technologyName">
                    </div>
                </div>

                <input type="checkbox" v-model="isChild" onchange="getProvince()">
                <label for="checkbox"> หากเป็นอยู่ในความรับผิดชอบของวิสาหกิจชุมชนให้กดเครื่องหมายถูก</label>

                <div v-if="isChild">
                    <select v-model="isComSelect">
                        <option v-for="isCom in isComEnter" v-bind:value="isCom.communityEnterpriseId"
                            :disabled='isCom.communityEnterpriseId == 0' :selected='isCom.communityEnterpriseId == 0'>
                            {{isCom.communityEnterpriseName}}
                        </option>
                    </select>
                </div>


                <!-- getAddressCode when have isChild-->
                <div v-for="isCom in isComEnter" hidden>
                    <input type="text"
                        v-bind:value="isCom.communityEnterpriseId == isComSelect? isComAddressCode = isCom.addressCode : ''">
                </div>




                <div class="form-group">
                    <label class="col-form-label">แหล่งที่มา</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" v-model="data.background"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label">ความเหมาะสม/สอดคล้องกับพื้นที่</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" v-model="data.consistent"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label">รายละเอียดอื่นๆ</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" v-model="data.otherDetail"></textarea>
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
                </div>

                <br>


                <div class="form-group text-center">
                    <a class="btn btn-warning" :href="'index.php'">ย้อนกลับ</a>
                    <a class="btn btn-info" id="put" v-on:click="AddData()">เพิ่มข้อมูล</a>
                </div>
                <br>
                <br>
            </div>

        </div>
    </div>


    <script>
    var app = new Vue({
        el: '#app', //อ้างอิง elment
        data: { //สร้างตัวแปร
            apiUrl: "http://localhost/www/training/api/technology",
            info: [{
                technologyName: null,
                background: null,
                consistent: null,
                otherDetail: null,
                addressCode: null,
                isComEnterprise: null
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
        methods: { // create function
            AddData: function() {

                if (this.isChild && this.isComSelect == 0 || this.isChild == false && this.info[0].addressCode == null) {
                    this.alertNotPass();
                } else {

                    if (this.isChild == true && this.isComSelect != 0) {
                        this.addressCode = this.isComAddressCode;
                    } else {
                        this.isComSelect = 0;
                        this.addressCode = this.info[0].addressCode;
                    }
                    let data = this.info[0];
                    if (data['technologyName'] &&
                        data['background'] &&
                        data['consistent'] &&
                        data['otherDetail']) {
                        axios({
                                method: 'options',
                                url: this.apiUrl,
                                data: {
                                    technologyName: data['technologyName'],
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
                    } else {
                        this.alertNotPass()

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
        beforeMount() { // จะให้อะไรทำงานก่อน
            this.getParent()
        }

    })
    </script>

</body>

</html>