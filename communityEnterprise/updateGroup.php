<?php
    include('../bootstrap/bootstrap5.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลวิสาหกิจชุมชน </title>
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
                    <h1>แก้ไขข้อมูลวิสาหกิจชุมชน</h1>
                </center>
            </div>

            <div style="max-width: 800px;">

                <div class="form-group">
                    <label class="col-form-label">ชื่อกลุ่ม</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="data.communityEnterpriseName">
                    </div>
                </div>


                <input type="checkbox" v-model="isChild" @change="changeIsChild()">
                <label for="checkbox"> หากเป็นวิสาหกิจกลุ่มย่อยให้กดเครื่องหมายถูก และเลือกวิสาหกิจหลัก</label>

                <div v-if="isChild">
                    <select v-model="data.isChildGroup">
                        <option v-for="parent in ParentData" v-bind:value="parent.communityEnterpriseId"
                            :disabled="parent.communityEnterpriseId === 0">
                            {{ parent.communityEnterpriseName }}
                        </option>
                    </select>

                    <!-- getAddressCode when have isChild-->
                    <div v-for="parents in ParentData" hidden>
                        <input type="text"
                            v-bind:value="parents.communityEnterpriseId == data.isChildGroup? id_district = parents.addressCode : ''">
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-form-label">ที่มา</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="data.background">
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
                        <input type="text" class="form-control" v-model="data.phoneNumber">
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


                <div class="col-sm-10">
                    <input type="text" class="form-control" name="isChildGroup" id="isChildGroup" value="no" hidden />
                </div>

                <br>
      
                <div v-if="isChild == false">

                    <div class="form text-center">
                        <div class="row">
                            <label class="col-sm-3 control-label">จังหวัด</label>
                            <div class="col-sm-1">
                                <select v-model="id_province" @change="changeProvince()">
                                    <option v-for="province in provinces" v-bind:value="province.id"
                                        :disabled="province.id == null">
                                        {{ province.provinces }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="form text-center">
                        <div class="row">
                            <label class="col-sm-3 control-label">อำเภอ</label>
                            <div class="col-sm-1">
                                <select v-model="id_amphure" @change="changeAmphure()">
                                    <option v-for="amphure in amphures" v-bind:value="amphure.id"
                                        :selected="amphure.id == id_amphure" :disabled="amphure.id == null">
                                        {{ amphure.amphures }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="form text-center">
                        <div class="row">
                            <label class="col-sm-3 control-label">ตำบล</label>
                            <div class="col-sm-1">
                                <select v-model="id_district">
                                    <option v-for="district in districts" v-bind:value="district.id"
                                        :disabled="district.id == null">
                                        {{ district.districts }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>

                <div class="form-group text-center">
                    <a class="btn btn-warning" :href="'detail.php?id=' + id">ย้อนกลับ</a>
                    <a class="btn btn-info" id="put" v-on:click="updateData()">บันทีก</a>
                </div>
                <br>

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
            apiUrl: 'http://localhost/www/training/api/communityEnterprise/?id=',
            id: id,
            info: [],

            ParentData: [{
                communityEnterpriseId: 0,
                communityEnterpriseName: '--เลือกวิสาหกิจหลัก--'
            }],
            isChild: null,

            provinces: [{
                id: null,
                provinces: '--เลือกจังหวัด--'
            }],
            amphures: [{
                id: null,
                amphures: '--เลือกอำเภอ--'
            }],
            districts: [{
                id: null,
                districts: '--เลือกตำบล--'
            }],

            id_province: null,
            id_amphure: null,
            id_district: null

        },
        methods: {
            getData: function() {
                this.apiUrl = this.apiUrl + id;
                axios.get(this.apiUrl)
                    .then(response => {
                        console.log(response.data);
                        this.info = response.data;
                        
                        this.getComEnterprise();
                        this.checkIsChild(response.data[0]['isChildGroup']);
                        this.checkAddresCode(response.data[0]['addressCode']);

                    })
                    .catch(error => {
                        console.log(error);
                    })

            },
            updateData: function() {
                this.apiUrl = this.apiUrl + id;

                if (this.id_district != null) {
                    axios({
                            method: 'put',
                            url: this.apiUrl,
                            data: {
                                communityEnterpriseId: id,
                                communityEnterpriseName: this.info[0]['communityEnterpriseName'],
                                background: this.info[0]['background'],
                                placeOrder: this.info[0]['placeOrder'],
                                registrationDate: this.info[0]['registrationDate'],
                                phoneNumber: this.info[0]['phoneNumber'],
                                address: this.info[0]['address'],
                                addressCode: this.id_district,
                                isChildGroup: this.info[0]['isChildGroup']
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
            getComEnterprise: function() {
                let url = 'http://localhost/www/training/api/communityEnterprise';
                
                axios.get(url)
                    .then(response => {
                        // isChildGroup == 0 is a parent
                        
                        response.data
                            .filter(value => value.isChildGroup == 0 && value.communityEnterpriseId != this.info[0]['communityEnterpriseId'])
                            .map(value => this.ParentData.push(value))
                        //console.log(this.ParentData);
                    })
                    .catch(error => console.log(error))
            },
            checkIsChild: function(isChild) {
                //alert(isChild +' | '+isChildData);
                if (isChild != 0) {
                    this.isChild = true;
                } else {
                    this.isChild = false;
                    this.isChildData = isChild;
                }
            },


            checkAddresCode: function(addressCode) {
                let apiUrlCheckAddr = "http://localhost/www/training/api/address/checkaddresscode/?id=";
                axios.get(apiUrlCheckAddr + addressCode)
                    .then(response => {
                        //console.log(response.data);
                        this.id_province = response.data[0]['province_id'];
                        this.id_amphure = response.data[0]['amphure_id'];
                        this.id_district = response.data[0]['district_id'];

                        this.getProvince();
                        this.getAmphure();
                        this.getDistrict();

                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            getProvince: function() {
                let apiUrlProvince = "http://localhost/www/training/api/address/provinces";
                axios.get(apiUrlProvince)
                    .then(response => {
                        response.data.map(value => this.provinces.push(value))
                        //console.log(this.provinces);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            getAmphure: function() {
                let apiUrlAmphure = "http://localhost/www/training/api/address/amphures?id=";

                //alert(this.id_province);

                axios.get(apiUrlAmphure + this.id_province)
                    .then(response => {
                        response.data.map(value => this.amphures.push(value))
                        console.log(this.amphures);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            getDistrict: function() {
                let apiUrlDistrict = "http://localhost/www/training/api/address/districts?id=";
                axios.get(apiUrlDistrict + this.id_amphure)
                    .then(response => {
                        response.data.map(value => this.districts.push(value))
                        //console.log(this.districts);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            changeProvince: function() {
                this.amphures = [{
                    id: null,
                    amphures: '--เลือกอำเภอ--'
                }];
                this.id_amphure = null;
                this.getAmphure();

                this.districts = [{
                    id: null,
                    districts: '--เลือกตำบล--'
                }];
                this.id_district = null;


            },
            changeAmphure: function() {
                this.districts = [{
                    id: null,
                    districts: '--เลือกตำบล--'
                }];
                this.id_district = null;
                this.getDistrict();
            },
            changeIsChild: function() {
                this.id_province = null;
                this.amphures = [{
                    id: null,
                    amphures: '--เลือกอำเภอ--'
                }];
                this.id_amphure = null;

                this.districts = [{
                    id: null,
                    districts: '--เลือกตำบล--'
                }];
                this.id_district = null;
                this.info[0]['isChildGroup'] = 0;
            },

            alertPass: function() {
                swal({
                    title: "แก้ไขข้อมูลสำเร็จ",
                    text: "ข้อมูลของคุณได้รับการแก้ไขแล้ว",
                    icon: "success",
                    button: "ตกลง",
                }).then((res) => {
                    window.location.href = 'index.php'
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