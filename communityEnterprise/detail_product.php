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
        <div class="container">
            <h1>{{ title }}</h1>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" :href="'detail.php?id=' + id">รายละเอียด</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" :href="'product.php?id='+id">ผลิตภัณฑ์</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :href="'member.php?id=' + id">สมาชิก</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :href="'contact.php?id=' + id">ติดต่อ</a>
                </li>
            </ul>


            <div class="row p-5" v-for="data in info">
                <div class="col-sm-5 col-12">
                    <center>
                        <div tyle="max-width: 18rem;">
                            <div class="m-1"
                                style="max-width: 30rem; height: 20rem; object-fit: cover; overflow: hidden;">
                                <img :src="data.productPicture" class="img-thumbnail rounded" alt="...">
                            </div>
                        </div>

                    </center>
                </div>
                <div class="col-sm-7 col-12">
                    <h3 class="card-text">{{data.productName}}</h3>
                    <p class="card-text pt-2">ราคา : {{data.productPrice}} บาท</p>
                    <p class="card-text pt-2">มาตรฐานสินค้า : {{data.productStandard}} บาท</p>
                    <p class="card-text">รายละเอียด : {{data.productDetail}} </p>
                </div>
            </div>

            <center>
                <div class="row ">
                    <div class="col-sm-1"></div>
                    <div class="col-12 col-sm-3 m-2">
                        <a class="btn btn-info btn-round" :href="'product.php?id='+id">ย้อนกลับ</a>
                    </div>
                    <div class="col-12 col-sm-3 m-2">
                        <a class="btn btn-danger btn-round" v-on:click="isDelete(product_id)">ลบผลิตภัณฑ์</a>
                    </div>
                    <div class="col-12 col-sm-3 m-2">
                        <a class="btn btn-warning btn-round"
                            :href="'edit_product.php?id='+ id +'&product_id='+product_id">แก้ไข</a>
                    </div>
                    <div class="col-sm-1"></div>

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
const product_id = urlParams.get('product_id');

new Vue({
    el: '#app',
    data: {
        title: 'ผลิตภัณฑ์',
        id: id,
        product_id: product_id,
        info: []
    },
    methods: {
        getData: function() {
            let url = 'http://localhost/www/training/api/communityProduct?product_id=';
            axios.get(url + this.product_id)
                .then(response => {
                    console.log(response.data);
                    this.info = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
        },
        deleteProduct: function(product_id) {
            let URL = "http://localhost/www/training/api/communityProduct";
            axios({
                    method: 'delete',
                    url: URL,
                    data: {
                        communityProductId: product_id
                    }
                })
                .then(response => {
                    console.log(response.data);
                    window.location.href = 'product.php?id=' + this.id;
                })
                .catch(error => console.log(error))
        },
        isDelete: function(product_id) {
            swal({
                    title: "ต้องการลบผลิตภัณฑ์หรือไม่?",
                    text: "หากลบข้อมูล ไม่สามารถทำรายการย้อนกลับได้ !!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("ข้อมูลผลิตภัณฑ์ของคุณถูกลบเรียบร้อยแล้ว", {
                            icon: "success",
                        }).then((willDelete) => {
                            this.deleteProduct(product_id)
                        });
                    }
                });
        }
    },
    beforeMount() {
        this.getData();
    }

})
</script>


</html>