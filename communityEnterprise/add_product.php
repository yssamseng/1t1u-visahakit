<?php
include '../bootstrap/bootstrap5.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> เพิ่มสมาชิก </title>

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
                <h1>เพิ่มผลิตภัณฑ์</h1>
            </center>
        </div>

        <div style="max-width: 500px;">

            <div class="form-group">
                <label class="col-form-label">ชื่อผลิตภัณฑ์</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" v-model="productName" required>
                </div>
            </div>
            <br>

            <div class="image-preview" v-if="imageBase64String.length > 0">
                <img class="preview" :src="imageBase64String" style="max-width: 50px;">
            </div>

            <div class="form-group">
                <label class="col-form-label">รูปภาพ</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" @change="previewImage" accept="image/*" required>
                </div>
            </div>
            <br>

            <div class="form-group">
                <label class="col-form-label">ราคา</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" v-model="productPrice" required>
                </div>
            </div>
            <br>

            <div class="form-group">
                <label class="col-form-label">รายละเอียดสินค้า</label>
                <div class="col-sm-10">
                    <textarea type="text" class="form-control" v-model="productDetail" required> </textarea>
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
                <label class="col-form-label">มาตรฐานสินค้า(เช่น Otop)</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" v-model="productStandard" required>
                </div>
            </div>
            <br>



            <div class="row">
                <div class="col">
                    <a class="btn btn-info btn-round" :href="'product.php?id='+ id">ย้อนกลับ</a>
                </div>
                <div class="col">
                    <input type="submit" class="btn btn-success" value="เพิ่มข้อมูล" v-on:click="addData">
                </div>
            </div>

            <br>


        </div>
    </div>



    <script>
    const getUrlAddr = window.location.search;
    const urlParams = new URLSearchParams(getUrlAddr);
    const id = urlParams.get('id');
    if(id == null){
        window.location.href = 'index.php';
    }
    new Vue({
        el: '#app',
        data: {
            title: 'ผลิตภัณฑ์',
            id: id,
            imageBase64String: '',

            productName: null,
            productPrice: null,
            productDetail: null,
            productStandard: null,

        },
        methods: {
            addData: function() {
                let url = 'http://localhost/www/training/api/communityProduct';

                if (this.productName &&
                    this.imageBase64String &&
                    this.productPrice &&
                    this.productDetail &&
                    this.productStandard
                ) {
                    axios({
                            method: 'options',
                            url: url,
                            data: {
                                productName: this.productName,
                                productPicture: this.imageBase64String,
                                productPrice: this.productPrice,
                                productDetail: this.productDetail,
                                placeOrder: ' ',
                                productStandard: this.productStandard,
                                communityEnterpriseId: this.id
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
                }else{
                    alert("อนุญาตให้อัพโหลดเฉพาะรูปภาพเท่านั้น");
                }
            },
            alertPass: function() {
                swal({
                    title: "เพิ่มข้อมูลสำเร็จ",
                    text: "คุณได้ทำการเพิ่มข้อมูลสำเร็จแล้ว",
                    icon: "success",
                    button: "ตกลง",
                }).then((res) => {
                    window.location.href = 'product.php?id=' + this.id
                });
            },
            alertNotPass: function() {
                swal({
                    title: "เพิ่มข้อมูลไม่สำเร็จ",
                    text: "การเพิ่มข้อมูลของคุณไม่สำเร็จ โปรดตรวจสอบข้อมูลอีกครั้ง",
                    icon: "warning",
                    button: "ตกลง",
                }).then((res) => {

                });
            }
        }

    })
    </script>


</body>

</html>