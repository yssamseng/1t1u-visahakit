<?php
include '../bootstrap/bootstrap5.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ผลิตภัณฑ์</title>
</head>

<body>
    <div id="app">
        <ul class="nav bg-light p-2">
            <li class="nav-item">
                <a class="nav-link active " aria-current="page" href="index.php">Home</a>
            </li>
        </ul>
        <div class="container mt-3">
            <h1>{{ title }}</h1>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" :href="'detail.php?id=' + id">รายละเอียด</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " :href="'product.php?id=' + id">ผลิตภัณฑ์</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :href="'member.php?id=' + id">สมาชิก</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="">วิสาหกิจกลุ่มย่อย</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :href="'innovation/?id='+id">นวัตกรรม</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :href="'technology/?id='+id">เครื่องมือและเทคโนโลยี</a>
                </li>
                
            </ul>

            <div class="mt-3">
                <table class="table table-striped table-bordered table-hover" id="info">
                    <tr>
                        <th class="text-center">ชื่อกลุ่ม</th>
                        <th class="text-center">วันที่จดทะเบียน</th>
                        <th class="text-center">โทรศัพท์</th>
                        <th class="text-center">ตำบล</th>
                    </tr>
                    <tr v-for="data in info">
                        <td class="text-left">
                            <a style="text-decoration: none;"
                                :href="'detail.php?id='+data.communityEnterpriseId">{{ data.communityEnterpriseName}}</a>
                        </td>
                        <td class="text-center">{{ data.registrationDate }}</td>
                        <td class="text-center">{{ data.phoneNumber}}</td>
                        <td class="text-center">{{ data.districts}}</td>
                    </tr>
                </table>
                <br>
            </div>


        </div>



    </div>

</body>

<script>
const getUrlAddr = window.location.search;
const urlParams = new URLSearchParams(getUrlAddr);
const id = urlParams.get('id');
new Vue({
    el: '#app',
    data: {
        title: 'ติดต่อ',
        apiUrl: 'http://localhost/www/training/api/communityEnterprise',
        id: id,
        info: []
    },
    methods: {
        getData: function() {
            let url = 'http://localhost/www/training/api/communityEnterprise';
            axios.get(url)
                .then(response => {
                    response.data
                        .filter(value => value.isChildGroup === this.id)
                        .map(value => this.info.push(value))
                    this.isLoading = false;
                    console.log(this.info);
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
</script>

</html>