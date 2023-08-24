
let formData = new FormData($('#form-register')[0]);
let config = {
    method: $('#form-register').attr('method'), url: domain + $('#form-register').attr('action'),
    data: formData,
}
axios(config)
.then((response) => {
    successMessage(response.data.message);
})
.catch((error) => {
    console.log(error);
    errorMessage(error.response.data.message);
});