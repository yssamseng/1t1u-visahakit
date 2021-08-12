//เมื่อโหลดหน้าจะให้ฟังก์ชันใดทำงานทันที
document.addEventListener("DOMContentLoaded", function() {
    getProvince();
});

let apiUrlProvince = "http://localhost/www/training/api/address/provinces";
let apiUrlAmphure = "http://localhost/www/training/api/address/amphures?id=";
let apiUrlDistrict = "http://localhost/www/training/api/address/districts?id=";

//province
function getProvince() {
    axios.get(apiUrlProvince)
        .then(function(response) {
            //console.log(response.data);
            showProvince(response.data);
        })
        .catch(function(error) {
            console.log(error);
        })
}
const showProvince = (data) => {
    data.map((item) => (
        document.querySelector("#province").innerHTML +=
        `<option value="${item.id}">${item.provinces}</option>`
    ))
    document.querySelector("#district").innerHTML = "<option value='' >--โปรดเลือกตำบล--</option>";
}

//amphure
function getAmphure() {
    let id = document.querySelector("#province").value;
    axios.get(apiUrlAmphure + id)
        .then(function(response) {
            //console.log(response.data);
            showAmphure(response.data);
        })
        .catch(function(error) {
            console.log(error);
        })
}
const showAmphure = (data) => { 
    document.querySelector("#amphure").innerHTML = "<option value=''>--เลือกอำเภอ--</option>";
    data.map((item) => (
        document.querySelector("#amphure").innerHTML +=
        `<option value="${item.id}">${item.amphures}</option>`
    ))
    document.querySelector("#district").innerHTML = "<option value=''>--โปรดเลือกตำบล--</option>";
    
}

//amphure
function getDistrict() {
    let id = document.querySelector("#amphure").value;
    axios.get(apiUrlDistrict + id)
        .then(function(response) {
            //console.log(response.data);
            showDistrict(response.data);
        })
        .catch(function(error) {
            console.log(error);
        })
}
const showDistrict = (data) => {
    document.querySelector("#district").innerHTML = "<option value=''>--เลือกตำบล--</option>";
    data.map((item) => (
        document.querySelector("#district").innerHTML +=
        `<option value="${item.id}">${item.districts}</option>`
    ))

}

//AddressCode
const getAddress = () => {
    let id = document.querySelector("#district").value;
    
    document.querySelector("#addressCode").value = id;
    
}