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
                    <a class="nav-link active" href="">ผลิตภัณฑ์</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :href="'member.php?id=' + id">สมาชิก</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :href="'childCommunity.php?id=' + id">วิสาหกิจกลุ่มย่อย</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :href="'innovation/?id='+id">นวัตกรรม</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :href="'technology/?id='+id">เครื่องมือและเทคโนโลยี</a>
                </li>
            </ul>

            <a type="button" class="btn btn-primary mt-4" :href="'add_product.php?id='+id">เพิ่มผลิตภัณฑ์</a>


            <center>
                <div v-if="isLoading" style="font-size: 20px;"> <br><br><br><br><br><br> Loading . . . </div>
                <div v-if="isLoading == false">
                    <div class="row gy-4 mt-1">
                        <div class='col-12 col-sm-6 col-md-3' v-for="data in info">
                            <div class="card text-start" style="max-width: 18rem;">
                                <div class="p-1"
                                    style="max-width: 18rem; height: 12rem; object-fit: cover; overflow: hidden;">
                                    <img :src="data.productPicture" class="card-img-top" alt="...">
                                </div>

                                <div class="card-body">
                                    <p class="card-text">ชื่อผลิตภันฑ์ : {{data.productName}}</p>
                                    <p class="card-text">ราคา : {{data.productPrice}} บาท</p>
                                </div>
                                <a class="btn btn-primary"
                                    :href="'detail_product.php?id='+ id +'&product_id='+data.communityProductId">รายละเอียดเพิ่มเติม</a>
                            </div>
                        </div>
                    </div>
                </div>
            </center>
            <br>

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
        isLoading: true,
        title: 'ผลิตภัณฑ์',
        id: id,
        info: [],
        comData: []
    },
    methods: {
        getData: function() {
            let url = 'http://localhost/www/training/api/communityProduct?id=';
            axios.get(url + this.id)
                .then(response => {
                    console.log(response.data);
                    this.info = response.data;
                    this.isLoading = false;
                })
                .catch(error => {
                    console.log(error);
                })
        }
    },
    beforeMount() {
        this.getData();
    }

})
</script>


</html>