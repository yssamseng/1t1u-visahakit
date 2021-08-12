<?php
include('../bootstrap/bootstrap5.php');
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
                    <a class="nav-link " aria-current="page" :href="'detail.php?id=' + id">รายละเอียด</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " :href="'product.php?id=' + id">ผลิตภัณฑ์</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="">สมาชิก</a>
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

            <a type="button" class="btn btn-primary mt-4" :href="'add_member.php?id=' + id">เพิ่มสมาชิก</a>
        </div>

        <br>
        <div class="container">
            <div v-if="isLoading" style="font-size: 20px; text-align:center;"> <br><br><br> Loading . . . </div>
            <div v-if="isLoading == false">
                <table class="table table-striped table-bordered table-hover" id="info">
                    <tr>
                        <th class="text-center">ลำดับ</th>
                        <th class="text-center">คำนำหน้าชื่อ</th>
                        <th class="text-center">ชื่อ-สกุล</th>
                        <th class="text-center">ที่อยู่</th>
                        <th class="text-center">โทรศัพท์</th>
                        <th class="text-center">แก้ไข</th>
                        <th class="text-center">ลบ</th>
                    </tr>
                    <tr v-for="(data, index) in info" :key="data.communityMemberId">
                        <td class="text-center">{{ index }}</td>
                        <td class="text-center">{{ data.gender }}</td>
                        <td class="text-center">{{ data.firstName }} {{ data.lastName }}</td>
                        <td class="text-center">{{ data.address }}</td>
                        <td class="text-center">{{ data.phoneNumber }}</td>

                        <td class="text-center">
                            <a class="btn btn-warning"
                                :href="'edit_member.php?id=' + id + '&m_id=' + data.communityMemberId">แก้ไข</a>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-danger" v-on:click="isDelete(data.communityMemberId)">ลบ</a>
                        </td>
                    </tr>
                </table>
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
        isLoading: true,
        title: 'ผลิตภัณฑ์',
        id: id,
        info: []
    },
    methods: {
        getCommunityMember: function() {
            let URL = "http://localhost/www/training/api/communityMember?id=";

            axios.get(URL + this.id)
                .then(response => {
                    this.info = response.data
                    this.isLoading = false;
                    console.log(this.info);
                })
                .catch(error => console.log(error))
        },
        deleteCommunityMember: function(m_id) {
            let URL = "http://localhost/www/training/api/communityMember";

            axios({
                    method: 'delete',
                    url: URL,
                    data: {
                        communityMemberId: m_id
                    }
                })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => console.log(error))
        },
        isDelete: function(m_id) {
            swal({
                    title: "ต้องการลบสมาชิกหรือไม่?",
                    text: "หากลบข้อมูล ไม่สามารถทำรายการย้อนกลับได้ !!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("ข้อมูลสมาชิกของคุณถูกลบเรียบร้อย", {
                            icon: "success",
                        }).then((willDelete) => {
                            this.deleteCommunityMember(m_id)
                            window.location.href = 'member.php?id=' + this.id;
                        });
                    }
                });
        }
    },
    beforeMount() {
        this.getCommunityMember()
    }



})
</script>

</html>