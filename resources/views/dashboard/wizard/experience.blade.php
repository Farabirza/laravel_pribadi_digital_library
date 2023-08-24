
<section id="section-wizard-experience" class="section-wizard px-3 d-none">
    <div class="container">

        <div class="row bg-white p-4 rounded shadow mb-4">
            <div class="col-md-12">
                <h2 class="section-title mt-3 mb-4 d-flex align-items-center justify-content-between">Experience <i class="bx bx-plus-circle ms-2 popper" title="new work history" role="button" onclick="newWH()"></i></h2>

                <!-- form work_history start -->
                <form id="form-wh" action="ajax/work_history" method="post" class="m-0">
                <div class="mb-3">
                    <label for="wh-role" class="form-label">Role*</label>
                    <input type="text" name="role" id="wh-role" class="form-control form-control-sm mb-2" placeholder="ex: Software Engineer">
                    <p class="mb-2 fs-9 text-muted fst-italic">*) required</p>
                    <p id="alert-wh-role" class="alert alert-danger d-none mb-3"></p>
                </div>
                <div class="mb-3 d-flex flex-remove-md gap-3">
                    <div class="col">
                        <label for="wh-work_place" class="form-label">Work place*</label>
                        <input type="text" name="work_place" id="wh-work_place" class="form-control form-control-sm mb-2" placeholder="ex: LinkedIn Company">
                        <p class="mb-2 fs-9 text-muted fst-italic">*) required</p>
                        <p id="alert-wh-work_place" class="alert alert-danger d-none mb-3"></p>
                    </div>
                    <div class="col">
                        <label for="wh-employment" class="form-label">Employment category*</label>
                        <select name="employment" id="wh-employment" class="form-control form-select mb-2" required>
                            <option value="select" selected disabled hidden>select</option>
                            <option value="full time">Full time</option>
                            <option value="part time">Part time</option>
                            <option value="casual">Casual</option>
                            <option value="apprenticeship">Apprenticeship</option>
                            <option value="traineeship">Traineeship</option>
                            <option value="commision">Commision</option>
                            <option value="internship">Internship</option>
                            <option value="other">Other</option>
                        </select>
                        <p class="mb-2 fs-9 text-muted fst-italic">*) required</p>
                        <p id="alert-wh-employment" class="alert alert-danger d-none mb-3"></p>
                    </div>
                </div>
                <div class="mb-3 d-flex gap-3 flex-remove-md">
                    <div class="col">
                        <label for="wh-year_start" class="form-label">Year start*</label>
                        <input type="number" name="year_start" id="wh-year_start" class="form-control form-control-sm mb-2" min="1950" max="{{date('Y', time())}}" placeholder="ex: 2018" required>
                        <p class="mb-2 fs-9 text-muted fst-italic">*) required</p>
                        <p id="alert-wh-year_start" class="alert alert-danger d-none mb-3"></p>
                    </div>
                    <div class="col">
                        <label for="wh-year_end" class="form-label">Year end</label>
                        <input type="number" name="year_end" id="wh-year_end" class="form-control form-control-sm mb-2" min="1950" placeholder="ex: {{date('Y')}}">
                        <p class="mb-2 fs-9 text-muted fst-italic">*) empty this field if you still work here</p>
                        <p id="alert-wh-year_end" class="alert alert-danger d-none mb-3"></p>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="wh-description" class="form-label">Description</label>
                    <textarea name="description" id="wh-description" class="form-control" placeholder="tell us a little bit more about your experience"></textarea>
                    <p id="alert-wh-description" class="alert alert-danger d-none mb-3"></p>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <hr class="col me-3"/>
                    <button id="wh-btn-submit" type="button" class="btn btn-success d-flex align-items-center" onclick="submitWH()"><i class='bx bxs-save me-2' ></i>Save</button>
                </div>
                </form>
                <!-- form work_history end -->
            </div>
        </div>
        
        <div class="row bg-white p-4 rounded shadow mb-4">
            <div id="container-work_histories" class="col-md-12">
                @forelse($work_histories as $key => $wh)
                <div class="wh-item d-flex justify-content-between mb-3">
                    <div class="col-mb-2">
                        <p class="mb-1" style="color:#374785; font-weight:500"><span id="wh-year_start-{{$key+1}}">{{$wh->year_start}}</span> @if($wh->year_end) - <span id="wh-year_end-{{$key+1}}">{{$wh->year_end}}</span> @else - <span id="wh-year_end-{{$key+1}}">Now</span> @endif </p>
                        <h5 id="wh-role-{{$key+1}}" class="item-title mb-1">{{$wh->role}}</h5>
                        <p class="mb-1 fs-11 d-flex align-items-center"><span id="wh-work_place-{{$key+1}}" class="me-2">{{$wh->work_place}}</span> <span id="wh-employment-{{$key+1}}" class="badge bg-primary">{{$wh->employment}}</span></p>
                        <p id="wh-description-{{$key+1}}" class="fs-10 text-secondary mb-2">{{$wh->description}}</p>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex gap-2">
                            <i class="bx bx-edit-alt bx-border btn-outline-success" role="button" onclick="editWH('{{$wh->id}}', '{{$key+1}}')"></i>
                            <i class="bx bx-trash-alt bx-border btn-outline-danger" role="button" onclick="deleteWH('{{$wh->id}}')"></i>
                        </div>
                    </div>
                </div>
                @empty
                <span class="fs-11 text-muted fst-italic">You haven't submitted anything</span>
                @endforelse
            </div>
        </div>
        
        <div class="row mb-5">
            <div id="container-nav-profile" class="col-md-12 d-flex align-items-center justify-content-between">
                <span class="text-primary fs-14 d-flex align-items-center" role="button" onclick="navWizard('education', 40)"><i class='bx bx-chevrons-left me-2' ></i>Previous</span>
                <span class="text-primary fs-14 d-flex align-items-center" role="button" onclick="navWizard('skill', 80)">Next<i class='bx bx-chevrons-right ms-2' ></i></span>
            </div>
        </div>

    </div>
</section>

<script type="text/javascript">
</script>
