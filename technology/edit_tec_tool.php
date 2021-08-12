<?php
include('../bootstrap/bootstrap5.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Innovation</title>
</head>

<body>
    <div id="app" v-for="data in info">
        <div class="jumbotron">
            <h1 class="form- text-center">แก้ไขรายละเอียด นวัตกรรม </h1>
        </div>

        <br>
        <br>

        <div class="form- text-center">
            <div class="row">
                <label for="name" class="col-sm-3 control-label">ชื่อ นวัตกรรม</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" v-model="data.technologyName"></input>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <input type="checkbox" v-model="isChild" @change="changeIsChild()">
                <label for="checkbox"> หากเป็นวิสาหกิจกลุ่มย่อยให้กดเครื่องหมายถูก และเลือกวิสาหกิจหลัก</label>
            </div>
        </div>


        <div v-if="isChild">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-1">
                    <select v-model="data.isComEnterprise">
                        <option v-for="comEnter in comEnterData" v-bind:value="comEnter.communityEnterpriseId"
                            :disabled="comEnter.communityEnterpriseId === 0">
                            {{ comEnter.communityEnterpriseName }}
                        </option>
                    </select>
                </div>
            </div>

            <!-- getAddressCode when have isChild-->
            <div v-for="comEnter in comEnterData" hidden>
                <input type="text"
                    v-bind:value="comEnter.communityEnterpriseId == data.isComEnterprise? id_district = comEnter.addressCode : ''">
            </div>
        </div>

        <br>

        <div class="form- text-center">
            <div class="row">
                <label for="Detail" class="col-sm-3 control-label">แหล่งที่มา</label>
                <div class="col-sm-6">
                    <textarea name="txt_bg" rows="4" cols="133" v-model="data.background"></textarea>
                </div>
            </div>
        </div>

        <br>

        <div class="form- text-center">
            <div class="row">
                <label for="appropriate" class="col-sm-3 control-label">ความเหมาะสม/สอดคล้องกับพื้นที่</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" v-model="data.consistent"></input>
                </div>
            </div>
        </div>

        <br>

        <div class="form- text-center">
            <div class="row">
                <label for="Detail" class="col-sm-3 control-label">รายละเอียดอื่นๆ</label>
                <div class="col-sm-6">
                    <textarea name="txt_bg" rows="4" cols="133" v-model="data.otherDetail"></textarea>
                </div>
            </div>
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
                                {{ province.provinces }}
                            </option>
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
                                {{ amphure.amphures }}
                            </option>
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
                                {{ district.districts }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <br>
        </div>

        <br>

        <div class="form-group text-center">
            <a href="index.php" class="btn btn-warning">ย้อนกลับ</a>
            <a class="btn btn-info" id="put" v-on:click="updateData()">บันทีก</a>
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
        apiUrl: 'http://localhost/www/training/api/technology/?id=',
        id: id,
        info: [],

        comEnterData: [{
            communityEnterpriseId: 0,
            communityEnterpriseName: '--เลือกวิสาหกิจชุมชน--'
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
            this.apiUrl = this.apiUrl + this.id;
            axios.get(this.apiUrl)
                .then(response => {
                    console.log(response.data);
                    this.info = response.data;

                    this.getComEnterprise();
                    this.checkIsChild(response.data[0]['isComEnterprise']);
                    this.checkAddresCode(response.data[0]['addressCode']);
                })
                .catch(error => {
                    console.log(error);
                })
        },
        updateData: function() {
            this.apiUrl = this.apiUrl + this.id;

            if (this.id_district &&
                this.info[0]['technologyName'] &&
                this.info[0]['background'] &&
                this.info[0]['consistent'] &&
                this.info[0]['otherDetail'] ) {
        
                axios({
                        method: 'put',
                        url: this.apiUrl,
                        data: {
                            technologyId: id,
                            technologyName: this.info[0]['technologyName'],
                            background: this.info[0]['background'],
                            consistent: this.info[0]['consistent'],
                            otherDetail: this.info[0]['otherDetail'],
                            addressCode: this.id_district,
                            isComEnterprise: this.info[0]['isComEnterprise'],
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
                alert('g')
                this.alertNotPass();
            }

        },
        getComEnterprise: function() {
            let url = 'http://localhost/www/training/api/communityEnterprise';

            axios.get(url)
                .then(response => {
                    response.data
                        .filter(value => value.communityEnterpriseId != this.info[0][
                            'communityEnterpriseId'
                        ])
                        .map(value => this.comEnterData.push(value))
                    //console.log(this.comEnterData);
                })
                .catch(error => console.log(error))
        },
        checkIsChild: function(isChild) {
            if (isChild != 0) {
                this.isChild = true;
            } else {
                this.isChild = false;
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
            this.info[0]['isComEnterprise'] = 0;
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

</html>