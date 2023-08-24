
<section id="section-wizard-skill" class="section-wizard px-3 d-none">
    <div class="container">

        <div class="row bg-white p-4 rounded shadow mb-4">
            <div class="col-md-12">
                <h2 class="section-title mt-3 mb-4 d-flex align-items-center justify-content-between">Skill <i class="bx bx-plus-circle ms-2 popper" title="new skill" role="button" onclick="newSkill()"></i></h2>
                <!-- form skill start -->
                <form id="form-skill" action="ajax/skill" method="post" class="m-0">
                <div class="mb-3">
                    <label for="skill-name" class="form-label">Name*</label>
                    <input type="text" name="name" id="skill-name" class="form-control form-control-sm mb-2" placeholder="ex: Copywriting">
                    <p class="mb-2 fs-9 text-muted fst-italic">*) required</p>
                    <p id="alert-skill-name" class="alert alert-danger d-none mb-3"></p>
                </div>
                <div class="mb-3">
                    <label for="skill-proficiency" class="form-label">Proficiency*</label>
                    <div class="d-flex mb-2">
                        <span class="fs-11 text-danger me-3">Beginner</span>
                        <input type="range" id="skill-proficiency" name="proficiency" class="form-range col" min="10" max="100" step="5" required>
                        <span class="fs-11 text-primary ms-3">Expert</span>
                    </div>
                    <p class="fs-11 text-muted mb-2">Level :</span> <span id="skill-proficiency-level" class="fs-11 fw-bold skill-proficiency-level">55</p>
                    <p class="mb-2 fs-9 text-muted fst-italic">*) required</p>
                    <p id="alert-skill-proficiency" class="alert alert-danger d-none mb-3"></p>
                </div>
                <div class="mb-4">
                    <label for="skill-description" class="form-label">Description</label>
                    <textarea name="description" id="skill-description" class="form-control" placeholder="tell us a little bit more about your skill"></textarea>
                    <p id="alert-skill-description" class="alert alert-danger d-none mb-3"></p>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <hr class="col me-3"/>
                    <button id="skill-btn-submit" type="button" class="btn btn-success d-flex align-items-center" onclick="submitSkill()"><i class='bx bxs-save me-2' ></i>Save</button>
                </div>
                </form>
                <!-- form skill end -->
            </div>
        </div>
        
        <div class="row bg-white p-4 rounded shadow mb-4">
            <div id="container-skills" class="col-md-12 row">
                @forelse($skills as $key => $skill)
                <div id="skill-item-{{$key+1}}" class="skill-item col-md-6 mb-4">
                    <div class="mb-2 d-flex flex-remove-md align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <span id="skill-name-{{$key+1}}" class="">{{$skill->name}}</span>
                            <span id="skill-point-{{$key+1}}" class="badge bg-success">{{$skill->proficiency}}%</span>
                            <span id="skill-description-{{$key+1}}" class="d-none">{{$skill->description}}</span>
                        </div>
                        <div class="d-flex gap-2">
                            <i class="bx bx-edit-alt bx-border btn-outline-success" role="button" onclick="editSkill('{{$skill->id}}', '{{$key+1}}')"></i>
                            <i class="bx bx-trash-alt bx-border btn-outline-danger" role="button" onclick="deleteSkill('{{$skill->id}}')"></i>
                        </div>
                    </div>
                    <div class="progress">
                        <div id="skill-proficiency-{{$key+1}}" class="progress-bar" role="progressbar" aria-label="skill name" style="width: {{$skill->proficiency}}%" aria-valuenow="{{$skill->proficiency}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                @empty
                <span class="fs-11 text-muted fst-italic">You haven't submitted anything</span>
                @endforelse
            </div>
        </div>
        
        <div class="row mb-5">
            <div class="col-md-12 d-flex align-items-center justify-content-between">
                <span class="text-primary fs-14 d-flex align-items-center" role="button" onclick="navWizard('experience', 60)"><i class='bx bx-chevrons-left me-2' ></i>Previous</span>
                <span class="text-primary fs-14 d-flex align-items-center" role="button" onclick="navWizard('config', 100)">Next<i class='bx bx-chevrons-right ms-2' ></i></span>
            </div>
        </div>

    </div>
</section>

<script type="text/javascript">
</script>