<?php
include '../../bootstrap/bootstrap5.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Innovation</title>
</head>

<body>
    <div id="app">
        <ul class="nav bg-light p-2">
            <li class="nav-item">
                <a class="nav-link active " aria-current="page" href="../index.php">Home</a>
            </li>
        </ul>
        <div class="container mt-3">
            <h1>{{ title }}</h1>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" :href="'../detail.php?id=' + id">รายละเอียด</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " :href="'../product.php?id=' + id">ผลิตภัณฑ์</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :href="'../member.php?id=' + id">สมาชิก</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="'../childCommunity.php?id='+id">วิสาหกิจกลุ่มย่อย</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :href="'../innovation/?id='+id">นวัตกรรม</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" >เครื่องมือและเทคโนโลยี</a>
                </li>
            </ul>

            <div class="mt-3">
                <table class="table table-striped table-bordered table-hover" id="info">
                    <tr>
                        <th class="text-center">ชื่อนวัตกรรม</th>
                        <th class="text-center">แหล่งที่มา</th>
                    </tr>
                    <tr v-for="data in info">
                        <td class="text-left">
                            <a style="text-decoration: none;"
                                :href="'../../innovation/detail_innovation.php?id='+data.technologyId">{{ data.technologyName}}</a>
                        </td>
                        <td class="text-center">{{ data.background }}</td>
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
        title: 'เครื่องมือและเทคโนโลยี',
        id: id,
        info: []
    },
    methods: {
        getData: function() {
            let url = 'http://localhost/www/training/api/technology';
            axios.get(url)
                .then(response => {
                    response.data
                        .filter(value => value.isComEnterprise == this.id)
                        .map(value => this.info.push(value))
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