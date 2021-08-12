<?php
    include('../bootstrap/bootstrap5.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> แก้ไขผลิตภัณฑ์ </title>

</head>

<body>
    <ul class="nav bg-light p-2">
        <li class="nav-item">
            <a class="nav-link active " aria-current="page" href="../index.php">Home</a>
        </li>
    </ul>


    <div class="container" id="app" v-for="data in info">
        <div class="jumbotron p-1">
            <center>
                <h1>แก้ไขผลิตภัณฑ์</h1>
            </center>
        </div>

        <div style="max-width: 500px;">

            <div class="form-group">
                <label class="col-form-label">ชื่อผลิตภัณฑ์</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" v-model="data.productName" required>
                </div>
            </div>
            <br>

            <div class="image-preview" v-if="imageBase64String.length > 0">
                <img class="preview" :src="imageBase64String" style="max-width: 50px;">
            </div>

            <div class="form-group">
                <label class="col-form-label">เปลี่ยนรูปภาพ</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" @change="previewImage" accept="image/*" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-form-label">ราคา</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" v-model="data.productPrice" required>
                </div>
            </div>
      

            <div class="form-group">
                <label class="col-form-label">รายละเอียดสินค้า</label>
                <div class="col-sm-10">
                    <textarea type="text" class="form-control" v-model="data.productDetail" required></textarea>
                </div>
            </div>
            <br>

            <!-- <div class="form-group">
                <label class="col-form-label">สถานที่วางจำหน่ายผลิตภัณฑ์</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="placeother" id="placeother" required>
                </div>
            </div>
            <br> -->

            <div class="form-group">
                <label class="col-form-label">มาตรฐานสินค้า</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" v-model="data.productStandard" required>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col">
                    <a class="btn btn-info btn-round" :href="'detail_product.php?id='+ id +'&product_id='+product_id">ย้อนกลับ</a>
                </div>
                <div class="col">
                    <input type="submit" class="btn btn-warning" value="แก้ไขข้อมูล" v-on:click="editData">
                </div>
            </div>
            <br>
         
        </div>
    </div>


    <script>
    const getUrlAddr = window.location.search;
    const urlParams = new URLSearchParams(getUrlAddr);
    const product_id = urlParams.get('product_id');
    const id = urlParams.get('id');
    /*if (id == null) {
        window.location.href = 'index.php';
    }*/
    new Vue({
        el: '#app',
        data: {
            title: 'ผลิตภัณฑ์',
            id: id,
            product_id: product_id,
            imageBase64String: '',
            info: [],
        },
        methods: {
            getData: function() {
                let url = 'http://localhost/www/training/api/communityProduct?product_id=';
                axios.get(url + this.product_id)
                    .then(response => {
                        this.info = response.data;
                        this.imageBase64String = response.data[0].productPicture;
                        console.log(this.info);
                    })
                    .catch(error => {
                        console.log(error);
                    })

            },
            editData: function() {
                let url = 'http://localhost/www/training/api/communityProduct';

                //alert(this.info[0].productName)

                if (this.info[0].productName &&
                    this.imageBase64String &&
                    this.info[0].productPrice &&
                    this.info[0].productDetail &&
                    this.info[0].productStandard
                ) {
                    axios({
                            method: 'put',
                            url: url,
                            data: {
                                communityProductId: this.info[0].communityProductId,
                                productName: this.info[0].productName,
                                productPicture: this.imageBase64String,
                                productPrice: this.info[0].productPrice,
                                productDetail: this.info[0].productDetail,
                                placeOrder: ' ',
                                productStandard: this.info[0].productStandard,
                                communityEnterpriseId: this.info[0].communityEnterpriseId
                            }
                        })
                        .then(response => {
                            console.log(response.data);
                            this.alertPass();
                        })
                        .catch(error => console.log(error))
                } else {
                    this.alertNotPass()
                }


            },
            previewImage: function(event) {
                // Reference to the DOM input element
                var input = event.target;
                // Ensure that you have a file before attempting to read it
                if (input.files && input.files[0] && input.files[0].type.match(/image.*/)) {
                    // create a new FileReader to read this image and convert to base64 format
                    var reader = new FileReader();
                    // Define a callback function to run, when FileReader finishes its job
                    reader.onload = (e) => {
                        // Note: arrow function used here, so that "this.imageBase64String" refers to the imageBase64String of Vue component
                        // Read image as base64 and set to imageBase64String
                        this.imageBase64String = e.target.result;
                    }
                    // Start the reader job - read file as a data url (base64 format)
                    reader.readAsDataURL(input.files[0]);

                    //reader.onloadend = function() {
                    console.log(this.imageBase64String);

                    //}
                } else {
                    alert("อนุญาตให้อัพโหลดเฉพาะรูปภาพเท่านั้น");
                }
            },
            alertPass: function() {
                swal({
                    title: "แก้ไขข้อมูลสำเร็จ",
                    text: "คุณได้ทำการแก้ไขข้อมูลสำเร็จแล้ว",
                    icon: "success",
                    button: "ตกลง",
                }).then((res) => {
                    window.location.href = 'detail_product.php?id='+ id +'&product_id=' + this.product_id
                });
            },
            alertNotPass: function() {
                swal({
                    title: "แก้ไขข้อมูลไม่สำเร็จ",
                    text: "การแก้ไขข้อมูลของคุณไม่สำเร็จ โปรดตรวจสอบข้อมูลอีกครั้ง",
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