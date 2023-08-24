
const newExp = () => {
    $('#form-exp').trigger('reset').attr('method', 'post').attr('action', 'ajax/experience');
    $('#exp-btn-submit').html("<i class='bx bxs-save me-2' ></i>Save</button>");
}
const editExp = (wh_id, item_id) => {
    $('#form-exp').attr('method', 'put').attr('action', 'ajax/experience/'+wh_id);
    $('#exp-btn-submit').html("<i class='bx bxs-save me-2' ></i>Update</button>");
    $('#exp-year_start').val($('#exp-year_start-'+item_id).html());
    $('#exp-year_end').val($('#exp-year_end-'+item_id).html());
    $('#exp-title').val($('#exp-title-'+item_id).html());
    $('#exp-affiliation').val($('#exp-affiliation-'+item_id).html());
    $('#exp-description').val($('#exp-description-'+item_id).html());
}
function submitExp() {
    $('.alert').hide();
    if($('#form-exp').attr('method') == 'post') {
        var formData = new FormData(document.getElementById('form-exp'));
        formData.append('user_id', user_id);
    } else {
        var formData = $('#form-exp').serialize();
    }
    var config = {
        method: $('#form-exp').attr('method'), url: domain + $('#form-exp').attr('action'),
        data: formData,
    }
    axios(config)
    .then((response) => {
        successMessage(response.data.message);
        $('#form-exp').trigger('reset').attr('method', 'post').attr('action', 'ajax/experience');
        $('#exp-btn-submit').html("<i class='bx bxs-save me-2' ></i>Save</button>");
        fetchExp();
    })
    .catch((error) => {
        console.log(error.response);
        if(error.response) {
            let response = error.response.data;
            if(response.message) {
                errorMessage(response.message);
            }
            if(response.errors) {
                if(response.errors.year_start) { $('#alert-exp-year_start').html(response.errors.year_start).removeClass('d-none').hide().fadeIn('slow'); }
                if(response.errors.year_end) { $('#alert-exp-year_end').html(response.errors.year_end).removeClass('d-none').hide().fadeIn('slow'); }
                if(response.errors.title) { $('#alert-exp-title').html(response.errors.title).removeClass('d-none').hide().fadeIn('slow'); }
                if(response.errors.affiliation) { $('#alert-exp-affiliation').html(response.errors.affiliation).removeClass('d-none').hide().fadeIn('slow'); }
            }
        }
    });
};
const deleteExp = (exp_id) => {
  Swal.fire({
    title: 'Are you sure?',
    icon: 'info',
    text: 'do you wish to delete this?',
    showCancelButton: true,
    cancelButtonColor: '#666',
    cancelButtonText: 'Cancel',
    confirmButtonColor: '#d9534f',
    confirmButtonText: "Delete"
    }).then((result) => {
    if(result.isConfirmed) {
        var config = {
            method: 'delete', url: domain + 'ajax/experience/' + exp_id,
        }
        axios(config)
        .then((response) => {
            fetchExp();
            newExp();
        })
        .catch((error) => {
            console.log(error.response);
            if(error.response) {
                if(error.response.data.message) { errorMessage(response.message); }
            }
        });
    }
  });
}
const fetchExp = () => {
    var config = {
        method: 'post', url: domain + 'action/experience',
        data: {
            action: 'fetch_experiences',
        },
    }
    axios(config)
    .then((response) => {
        $('#container-experiences').html('');
        if(response.data.experiences.length > 0) {
            response.data.experiences.forEach(foreachExp);
            function foreachExp(item, index) {
                index++; description = (item.description) ? item.description : '';
                var year_end = (item.year_end != null) ? item.year_end : 'Now';
                $('#container-experiences').append(`
                    <div class="exp-item d-flex justify-content-between mb-3">
                        <div class="col-mb-2">
                            <p class="mb-1" style="color:#374785; font-weight:500"><span id="exp-year_start-`+index+`">`+ item.year_start +`</span> - <span id="exp-year_end-`+index+`">`+ year_end +`</span></p>
                            <h5 id="exp-title-`+index+`" class="item-title mb-1">`+ item.title +`</h5>
                            <p class="mb-1 fs-11 d-flex align-items-center"><span id="exp-affiliation-`+index+`" class="me-2">`+ item.affiliation +`</span> </p>
                            <p id="exp-description-`+index+`" class="fs-10 text-secondary mb-2">`+ description +`</p>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex gap-2">
                                <i class="bx bx-edit-alt bx-border btn-outline-success" role="button" onclick="editExp('`+ item.id +`', '`+index+`')"></i>
                                <i class="bx bx-trash-alt bx-border btn-outline-danger" role="button" onclick="deleteExp('`+ item.id +`')"></i>
                            </div>
                        </div>
                    </div>
                `);
            }
        } else {
            $('#container-experiences').html(`<span class="fs-11 text-muted fst-italic">You haven't submitted anything</span>`);
        }
    })
    .catch((error) => {
        console.log(error);
    });
}

// $('#wh-employment').change(function(e){
//     if($(this).val() == 'other') {
//         $('#wh-employment-other').removeClass('d-none');
//     } else {
//         $('#wh-employment-other').addClass('d-none');

//     }
// });

function submitWH() {
    $('.alert').hide();
    if($('#form-wh').attr('method') == 'post') {
        var formData = new FormData(document.getElementById('form-wh'));
        formData.append('user_id', user_id);
    } else {
        var formData = $('#form-wh').serialize();
    }
    var config = {
        method: $('#form-wh').attr('method'), url: domain + $('#form-wh').attr('action'),
        data: formData,
    }
    axios(config)
    .then((response) => {
        successMessage(response.data.message);
        $('#form-wh').trigger('reset').attr('method', 'post').attr('action', 'ajax/work_history');
        $('#wh-btn-submit').html("<i class='bx bxs-save me-2' ></i>Save</button>");
        fetchWH();
    })
    .catch((error) => {
        console.log(error.response);
        if(error.response) {
            let response = error.response.data;
            if(response.message) {
                errorMessage(response.message);
            }
            if(response.errors) {
                if(response.errors.year_start) { $('#alert-wh-year_start').html(response.errors.year_start).removeClass('d-none').hide().fadeIn('slow'); }
                if(response.errors.year_end) { $('#alert-wh-year_end').html(response.errors.year_end).removeClass('d-none').hide().fadeIn('slow'); }
                if(response.errors.role) { $('#alert-wh-role').html(response.errors.role).removeClass('d-none').hide().fadeIn('slow'); }
                if(response.errors.work_place) { $('#alert-wh-work_place').html(response.errors.work_place).removeClass('d-none').hide().fadeIn('slow'); }
                if(response.errors.employment) { $('#alert-wh-employment').html(response.errors.employment).removeClass('d-none').hide().fadeIn('slow'); }
            }
        }
    });
};
const fetchWH = () => {
    var config = {
        method: 'post', url: domain + 'action/work_history',
        data: {
            action: 'fetch_wh',
        },
    }
    axios(config)
    .then((response) => {
        $('#container-work_histories').html('');
        if(response.data.work_histories.length > 0) {
            response.data.work_histories.forEach(foreachWH);
            function foreachWH(item, index) {
                index++; description = (item.description) ? item.description : '';
                var year_end = (item.year_end != null) ? item.year_end : 'Now';
                $('#container-work_histories').append(`
                    <div class="wh-item d-flex flex-remove-md justify-content-between mb-3">
                        <div class="col mb-2">
                            <p class="mb-1" style="color:#374785; font-weight:500"><span id="wh-year_start-`+index+`">`+ item.year_start + `</span> - <span id="wh-year_end-`+ index +`">` + year_end+`</span></p>
                            <h5 id="wh-role-`+index+`" class="item-title mb-1">`+item.role+`</h5>
                            <p class="mb-1 fs-11 d-flex align-items-center"><span id="wh-work_place-`+index+`" class="me-2">`+item.work_place+`</span> <span id="wh-employment-`+index+`" class="badge bg-primary">`+item.employment+`</span></p>
                            <p id="wh-description-`+index+`" class="fs-10 text-secondary mb-2">`+description+`</p>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex gap-2">
                                <i class="bx bx-edit-alt bx-border btn-outline-success" role="button" onclick="editWH('`+item.id+`', '`+index+`')"></i>
                                <i class="bx bx-trash-alt bx-border btn-outline-danger" role="button" onclick="deleteWH('`+item.id+`')"></i>
                            </div>
                        </div>
                    </div>
                `);
            }
        } else {
            $('#container-work_histories').html(`<span class="fs-11 text-muted fst-italic">You haven't submitted anything</span>`);
        }
    })
    .catch((error) => {
        console.log(error);
    });
}
const editWH = (wh_id, item_id) => {
    $('#form-wh').attr('method', 'put').attr('action', 'ajax/work_history/'+wh_id);
    $('#wh-btn-submit').html("<i class='bx bxs-save me-2' ></i>Update</button>");
    $('#wh-year_start').val($('#wh-year_start-'+item_id).html());
    $('#wh-year_end').val($('#wh-year_end-'+item_id).html());
    $('#wh-role').val($('#wh-role-'+item_id).html());
    $('#wh-work_place').val($('#wh-work_place-'+item_id).html());
    $('#wh-employment option[value="'+ $('#wh-employment-'+item_id).html()+'"]').prop('selected', true);
    $('#wh-description').val($('#wh-description-'+item_id).html());
}
const newWH = () => {
    $('#form-wh').trigger('reset').attr('method', 'post').attr('action', 'ajax/work_history');
    $('#wh-btn-submit').html("<i class='bx bxs-save me-2' ></i>Save</button>");
}
const deleteWH = (wh_id) => {
  Swal.fire({
    title: 'Are you sure?',
    icon: 'info',
    text: 'do you wish to delete this?',
    showCancelButton: true,
    cancelButtonColor: '#666',
    cancelButtonText: 'Cancel',
    confirmButtonColor: '#d9534f',
    confirmButtonText: "Delete"
    }).then((result) => {
    if(result.isConfirmed) {
        var config = {
            method: 'delete', url: domain + 'ajax/work_history/' + wh_id,
        }
        axios(config)
        .then((response) => {
            fetchWH();
            newWH();
        })
        .catch((error) => {
            console.log(error.response);
            if(error.response) {
                if(error.response.data.message) { errorMessage(response.message); }
            }
        });
    }
  });
}