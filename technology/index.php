<!--include bootstrap-->
<?php
include('../bootstrap/bootstrap5.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnology and Tool Display</title>

</head>

<body>
    <ul class="nav bg-light p-2">
        <li class="nav-item">
            <a class="nav-link active " aria-current="page" href="../index.php">Home</a>
        </li>
    </ul>


    <div class="jumbotron text-center">
        <h1>เครื่องมือและเทคโนโลยี</h1>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <a href="add_tec_tool.php"><button class="btn btn-success">เพิ่มเครื่องมือและเทคโนโลยี</button></a>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        จังหวัด
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#">test</a></li>
                    </ul>

                </div>
            </div>

            <div class="col">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        อำเภอ
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                        <li><a class="dropdown-item" href="#">test</a></li>
                    </ul>
                </div>
            </div>

            <div class="col">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        ตำบล
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                        <li><a class="dropdown-item" href="#">test</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <br>

        <div>
            <span id="name"></span>
        </div>

        <div class="row">
            <table class="table table-striped table-bordered tablr-hover" id="info">
                <tr>
                    <th>ชื่อเครื่องมือและเทคโนโลยี</th>
                    <th>ตำบล</th>
                    <th>อำเภอ</th>
                    <th>จังหวัด</th>
                </tr>

            </table>
        </div>

    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        getData();
    });

    //link กับ ข้อมูลที่ต้องการจะดึง
    let apiUrl = "http://localhost/www/training/api/Technology";

    //ส่วนดึงข้อมูล
    function getData() {
        axios.get(apiUrl)
            .then(function(response) {
                //console.log(response.data);
                let data = response.data;
                showData(data);
            })
            .catch(function(error) {
                console.log(error);
            })
    }

    //ส่วนแสดงข้อมูล
    const showData = (data) => {
        for (let i = 0; i < data.length; i++) {
            document.querySelector("#info").innerHTML += `
                    <tr>
                        <td><a href="detail_tec_tool.php?id=${data[i].technologyId}"class="text-decoration-none">${data[i].technologyName}</a></td>
                        <td>${data[i].districts}</td>
                        <td>${data[i].amphures}</td>
                        <td>${data[i].provinces}</td>
                        
                    </tr>`;
        }

        //เพื่อ reset ค่า หากมีการเรียกค่าซ้ำ
        //document.getElementbyId("info").innerHTML = "";
    }
    </script>
</body>

</html>