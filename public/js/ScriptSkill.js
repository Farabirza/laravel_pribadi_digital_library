function submitSkill() {
    $('.alert').hide();
    if($('#form-skill').attr('method') == 'post') {
        var formData = new FormData(document.getElementById('form-skill'));
        formData.append('user_id', user_id);
    } else {
        var formData = $('#form-skill').serialize();
    }
    var config = {
        method: $('#form-skill').attr('method'), url: domain + $('#form-skill').attr('action'),
        data: formData,
    }
    axios(config)
    .then((response) => {
        successMessage(response.data.message);
        $('#form-skill').trigger('reset').attr('method', 'post').attr('action', 'ajax/skill');
        $('#skill-proficiency-level').html('55');
        $('#skill-btn-submit').html("<i class='bx bxs-save me-2' ></i>Save</button>");
        fetchSkill();
    })
    .catch((error) => {
        console.log(error.response);
        if(error.response) {
            let response = error.response.data;
            if(response.message) {
                errorMessage(response.message);
            }
            if(response.errors) {
                if(response.errors.name) { $('#alert-skill-name').html(response.errors.name).removeClass('d-none').hide().fadeIn('slow'); }
                if(response.errors.proficiency) { $('#alert-skill-proficiency').html(response.errors.proficiency).removeClass('d-none').hide().fadeIn('slow'); }
            }
        }
    });
};
const fetchSkill = () => {
    var config = {
        method: 'post', url: domain + 'action/skill',
        data: {
            action: 'fetch_skills',
        },
    }
    axios(config)
    .then((response) => {
        $('#container-skills').html('');
        if(response.data.skills.length > 0) {
            response.data.skills.forEach(foreachskills);
            function foreachskills(item, index) {
                index++; description = (item.description) ? item.description : '';
                $('#container-skills').append(`
                    <div id="skill-item-`+index+`" class="skill-item col-md-6 mb-4">
                        <div class="mb-2 d-flex flex-remove-md align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span id="skill-name-`+index+`" class="">`+item.name+`</span>
                                <span id="skill-point-`+index+`" class="badge bg-success">`+item.proficiency+`%</span>
                                <span id="skill-description-`+index+`" class="d-none">`+description+`</span>
                            </div>
                            <div class="d-flex gap-2">
                                <i class="bx bx-edit-alt bx-border btn-outline-success" role="button" onclick="editSkill('`+item.id+`', `+index+`)"></i>
                                <i class="bx bx-trash-alt bx-border btn-outline-danger" role="button" onclick="deleteSkill('`+item.id+`')"></i>
                            </div>
                        </div>
                        <div class="progress">
                            <div id="skill-proficiency-`+index+`" class="progress-bar" role="progressbar" aria-label="skill name" style="width: `+item.proficiency+`%" aria-valuenow="`+item.proficiency+`" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                `);
            }
        } else {
            $('#container-skills').html(`<span class="fs-11 text-muted fst-italic">You haven't submitted anything</span>`);
        }
    })
    .catch((error) => {
        console.log(error);
    });
}
const editSkill = (skill_id, item_id) => {
    $('#form-skill').attr('method', 'put').attr('action', 'ajax/skill/'+skill_id);
    $('#skill-btn-submit').html("<i class='bx bxs-save me-2' ></i>Update</button>");
    $('#skill-name').val($('#skill-name-'+item_id).html());
    $('#skill-proficiency').val($('#skill-proficiency-'+item_id).attr('aria-valuenow'));
    $('#skill-proficiency-level').html($('#skill-proficiency-'+item_id).attr('aria-valuenow'));
    $('#skill-description').val($('#skill-description-'+item_id).html());
}
const newSkill = () => {
    $('#form-skill').trigger('reset').attr('method', 'post').attr('action', 'ajax/skill');
    $('#skill-btn-submit').html("<i class='bx bxs-save me-2' ></i>Save</button>");
    $('#skill-proficiency-level').html(55);
}
const deleteSkill = (skill_id) => {
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
            method: 'delete', url: domain + 'ajax/skill/' + skill_id,
        }
        axios(config)
        .then((response) => {
            fetchSkill();
            newSkill();
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
$('#skill-proficiency').change(function(e) {
    $('#skill-proficiency-level').html($(this).val());
});
$(document).ready(function(e){ 
    $('#skill-proficiency').val(55);
});