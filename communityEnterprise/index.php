<?php
    include('../bootstrap/bootstrap5.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> วิสาหกิจ </title>
</head>

<body>
    <ul class="nav bg-light p-2">
        <li class="nav-item">
            <a class="nav-link active " aria-current="page" href="../index.php">Home</a>
        </li>
    </ul>


    <div class="container" id="app">
        <div class="jumbotron">
            <center>
                <h1>{{ title }}</h1>
            </center>
        </div>
        <br>
        <div class="container mt-3">
            <div class="row">
                <div class="col">
                    <a href="addGroup.php" class="btn btn-success">เพิ่มวิสาหกิจชุมชน</a>
                </div>
            </div>
        </div>
        <br>
        <div class="container">
            <div class="row">
                <label for="one">กรองข้อมูล: </label>
                <div class="col">
                    <select class="form-select" v-model="id_province" @change="changeProvince()">
                        <option v-for="province in provinces" v-bind:value="province.id"
                            :disabled="province.id == null">
                            {{ province.provinces }}</option>
                    </select>
                </div>

                <div class="col">
                    <select class="form-select" v-model="id_amphure" @change="changeAmphure()">
                        <option v-for="amphure in amphures" v-bind:value="amphure.id"
                            :selected="amphure.id == id_amphure" :disabled="amphure.id == null">
                            {{ amphure.amphures }}</option>
                    </select>
                </div>

                <div class="col">
                    <select class="form-select" v-model="id_district">
                        <option v-for="district in districts" v-bind:value="district.id"
                            :disabled="district.id == null">
                            {{ district.districts }}</option>
                    </select>
                </div>
            </div>
        </div>
        <br>

        <div class="mt-3">
            <label for="one">แสดงข้อมูล: </label>
            <input type="radio" id="one" value="false" v-model="isChild" v-on:click="getDataParent">
            <label for="one">วิสาหกิจ</label>
            <input type="radio" id="two" value="true" v-model="isChild" v-on:click="getDataChild">
            <label for="two">วิสาหกิจกลุ่มย่อย</label>
        </div>


        <table class="table table-striped table-bordered table-hover" id="info">
            <tr>
                <th class="text-center">ชื่อกลุ่ม</th>
                <th class="text-center">วันที่จดทะเบียน</th>
                <th class="text-center">โทรศัพท์</th>
                <th class="text-center">ตำบล</th>
                <th class="text-center">อำเภอ</th>
                <th class="text-center">จังหวัด</th>
            </tr>
            <tr v-for="data in info">
                <td class="text-left">
                    <a style="text-decoration: none;"
                        :href="'detail.php?id='+data.communityEnterpriseId">{{ data.communityEnterpriseName}}</a>
                </td>
                <td class="text-center">{{ data.registrationDate }}</td>
                <td class="text-center">{{ data.phoneNumber}}</td>
                <td class="text-center">{{ data.districts}}</td>
                <td class="text-center">{{ data.amphures}}</td>
                <td class="text-center">{{ data.provinces}}</td>
            </tr>
        </table>
        <br>
    </div>

    <script>
    new Vue({
        el: '#app',
        data: {
            isLoading: true,
            title: 'วิสาหกิจชุมชน',
            info: [],
            data: [],
            isChild: false,

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
            getDataParent: function(value) {
                let url = 'http://localhost/www/training/api/communityEnterprise';
                this.info = [];
                axios.get(url)
                    .then(response => {
                        response.data
                            .filter(value => value.isChildGroup == 0 ) //value.province_id == this.id_province
                            .map(value => this.info.push(value));
                        console.log(this.info);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            getDataChild: function(value) {
                let url = 'http://localhost/www/training/api/communityEnterprise';
                this.info = [];
                axios.get(url)
                    .then(response => {
                        response.data
                            .filter(value => value.isChildGroup != 0)
                            .map(value => this.info.push(value));
                        console.log(this.info);
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

                this.getDataParent();

            },
            changeAmphure: function() {
                this.districts = [{
                    id: null,
                    districts: '--เลือกตำบล--'
                }];
                this.id_district = null;
                this.getDistrict();
            }
        },
        beforeMount() {
            this.getDataParent();
            this.getProvince();
        }

    })
    </script>
</body>

</html>