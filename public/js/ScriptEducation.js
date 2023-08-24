
function submitEducation() {
  $('.alert').hide();
  if($('#form-education').attr('method') == 'post') {
      var formData = new FormData(document.getElementById('form-education'));
      formData.append('user_id', user_id);
  } else {
      var formData = $('#form-education').serialize();
  }
  var config = {
      method: $('#form-education').attr('method'), url: domain + $('#form-education').attr('action'),
      data: formData,
  }
  axios(config)
  .then((response) => {
      successMessage(response.data.message);
      $('#form-education').trigger('reset').attr('method', 'post').attr('action', 'ajax/education');
      $('#education-btn-submit').html("<i class='bx bxs-save me-2' ></i>Save</button>");
      fetchEducation();
  })
  .catch((error) => {
      console.log(error.response);
      if(error.response) {
          let response = error.response.data;
          if(response.message) {
              errorMessage(response.message);
          }
          if(response.errors) {
              if(response.errors.year_start) { $('#alert-education-year_start').html(response.errors.year_start).removeClass('d-none').hide().fadeIn('slow'); }
              if(response.errors.year_end) { $('#alert-education-year_end').html(response.errors.year_end).removeClass('d-none').hide().fadeIn('slow'); }
              if(response.errors.institution) { $('#alert-education-institution').html(response.errors.institution).removeClass('d-none').hide().fadeIn('slow'); }
              if(response.errors.major) { $('#alert-education-major').html(response.errors.major).removeClass('d-none').hide().fadeIn('slow'); }
              if(response.errors.gpa) { $('#alert-education-gpa').html(response.errors.gpa).removeClass('d-none').hide().fadeIn('slow'); }
              if(response.errors.gpa_limit) { $('#alert-education-gpa_limit').html(response.errors.gpa_limit).removeClass('d-none').hide().fadeIn('slow'); }
              if(response.errors.description) { $('#alert-education-description').html(response.errors.description).removeClass('d-none').hide().fadeIn('slow'); }
          }
      }
  });
};
const fetchEducation = () => {
  var config = {
      method: 'post', url: domain + 'action/education',
      data: {
          action: 'fetch_educations',
      },
  }
  axios(config)
  .then((response) => {
      $('#container-educations').html('');
      if(response.data.educations.length > 0) {
          response.data.educations.forEach(foreachEducations);
          function foreachEducations(item, index) {
              index++; description = (item.description) ? item.description : '';
              var year_end = (item.year_end != null) ? item.year_end : 'Now';
              $('#container-educations').append(`
                  <div class="education-item d-flex flex-remove-md justify-content-between mb-3">
                      <div class="col mb-2">
                          <p class="mb-1" style="color:#374785; font-weight:500"><span id="education-year_start-`+index+`">`+ item.year_start + `</span> - <span id="education-year_end-`+ index +`">` + year_end+`</span></p>
                          <h5 id="education-institution-`+index+`" class="item-title mb-1">`+item.institution+`</h5>
                          <div id="container-major-`+index+`" class="mb-1 d-flex align-items-center gap-3">
                              <div id="education-major-`+index+`" class="fs-11 fst-italic">`+item.major+`</div>
                          </div>
                          <p id="education-description-`+index+`" class="fs-10 text-secondary mb-2">`+description+`</p>
                      </div>
                      <div class="mb-3">
                          <div class="d-flex gap-2">
                              <i class="bx bx-edit-alt bx-border btn-outline-success" role="button" onclick="editEducation('`+item.id+`', '`+index+`')"></i>
                              <i class="bx bx-trash-alt bx-border btn-outline-danger" role="button" onclick="deleteEducation('`+item.id+`')"></i>
                          </div>
                      </div>
                  </div>
              `);
              if(item.gpa != null) {
                $('#container-major-'+index).append(`
                    <div id="container-gpa-`+index+`" class="badge bg-primary text-white">
                        <span>GPA : </span>
                        <span id="education-gpa-`+index+`">`+item.gpa+`</span>
                    </div>
                `);
                if(item.gpa_limit != null) {
                    $('#container-gpa-'+index).append(` / <span id="education-gpa_limit-`+index+`">`+item.gpa_limit+`</span>`);
                }
              }
          }
      } else {
          $('#container-educations').html(`<span class="fs-11 text-muted fst-italic">You haven't submitted anything</span>`);
      }
  })
  .catch((error) => {
      console.log(error);
  });
}
const editEducation = (education_id, item_id) => {
  $('#form-education').attr('method', 'put').attr('action', 'ajax/education/'+education_id);
  $('#education-btn-submit').html("<i class='bx bxs-save me-2' ></i>Update</button>");
  $('#education-year_start').val($('#education-year_start-'+item_id).html());
  $('#education-year_end').val($('#education-year_end-'+item_id).html());
  $('#education-institution').val($('#education-institution-'+item_id).html());
  $('#education-major').val($('#education-major-'+item_id).html());
  $('#education-gpa').val($('#education-gpa-'+item_id).html());
  $('#education-gpa_limit').val($('#education-gpa_limit-'+item_id).html());
  $('#education-description').val($('#education-description-'+item_id).html());
}
const newEducation = () => {
  $('#form-education').trigger('reset').attr('method', 'post').attr('action', 'ajax/education');
  $('#education-btn-submit').html("<i class='bx bxs-save me-2' ></i>Save</button>");
}
const deleteEducation = (education_id) => {
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
                method: 'delete', url: domain + 'ajax/education/' + education_id,
            }
            axios(config)
            .then((response) => {
                fetchEducation();
                newEducation();
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