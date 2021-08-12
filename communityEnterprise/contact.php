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
                    <a class="nav-link active" href="">ติดต่อ</a>
                </li>
            </ul>
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
        apiUrl: 'http://localhost/www/training/api/communityEnterprise/?id=',
        id: id,
        info: []
    },
    methods: {
        getData: function() {
            if (id){
                this.apiUrl = this.apiUrl + id;
            }
            axios.get(this.apiUrl)
                .then(response => {
                    this.info = response.data;
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