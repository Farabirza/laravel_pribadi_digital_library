
<section id="section-wizard-education" class="section-wizard px-3 d-none">
    <div class="container">

        <div class="row bg-white p-4 rounded shadow mb-4">
            <div class="col-md-12">
                <h2 class="section-title mt-3 mb-4 d-flex align-items-center justify-content-between">Education <i class="bx bx-plus-circle ms-2 popper" title="new education history" role="button" onclick="newEducation()"></i></h2>

                <!-- form education start -->
                <form id="form-education" action="ajax/education" method="post" class="m-0">
                <div class="mb-2 d-flex gap-3 flex-remove-md">
                    <div class="col">
                        <label for="education-year_start" class="form-label">Year start*</label>
                        <input type="number" name="year_start" id="education-year_start" class="form-control form-control-sm mb-2" min="1950" max="{{date('Y', time())}}" placeholder="ex: 2018" required>
                        <p class="mb-2 fs-9 text-muted fst-italic">*) required</p>
                        <p id="alert-education-year_start" class="alert alert-danger d-none mb-3"></p>
                    </div>
                    <div class="col">
                        <label for="education-year_end" class="form-label">Year end</label>
                        <input type="number" name="year_end" id="education-year_end" class="form-control form-control-sm mb-2" min="1950" placeholder="ex: {{date('Y')}}">
                        <p class="mb-2 fs-9 text-muted fst-italic">*) empty this field if you still study here</p>
                        <p id="alert-education-year_end" class="alert alert-danger d-none mb-3"></p>
                    </div>
                </div>
                <div class="mb-2 d-flex gap-3 flex-remove-md">
                    <div class="col">
                        <label for="education-institution" class="form-label">Learning institution*</label>
                        <input type="text" name="institution" id="education-institution" class="form-control form-control-sm mb-2" placeholder="ex: University of Indonesia" required>
                        <p class="mb-2 fs-9 text-muted fst-italic">*) required</p>
                        <p id="alert-education-institution" class="alert alert-danger d-none mb-3"></p>
                    </div>
                    <div class="col">
                        <label for="education-major" class="form-label">Major*</label>
                        <input type="text" name="major" id="education-major" class="form-control form-control-sm mb-2" placeholder="ex: Computer Science" required>
                        <p class="mb-2 fs-9 text-muted fst-italic">*) required</p>
                        <p id="alert-education-major" class="alert alert-danger d-none mb-3"></p>
                    </div>
                </div>
                <div class="mb-2 d-flex gap-3 flex-remove-md">
                    <div class="col">
                        <label for="education-gpa" class="form-label">GPA</label>
                        <input type="number" step="0.01" name="gpa" id="education-gpa" class="form-control form-control-sm mb-2" placeholder="ex: 3.47" required>
                        <p id="alert-education-gpa" class="alert alert-danger d-none mb-3"></p>
                    </div>
                    <div class="col">
                        <label for="education-gpa_limit" class="form-label">GPA limit</label>
                        <input type="number" step="0.01" name="gpa_limit" id="education-gpa_limit" class="form-control form-control-sm mb-2" placeholder="ex: 4.0" required>
                        <p id="alert-education-gpa_limit" class="alert alert-danger d-none mb-3"></p>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="education-description" class="form-label">Description</label>
                    <textarea name="description" id="education-description" class="form-control" placeholder="tell us a little bit more about your study"></textarea>
                    <p id="alert-education-description" class="alert alert-danger d-none mb-3"></p>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <hr class="col me-3"/>
                    <button id="education-btn-submit" type="button" class="btn btn-success d-flex align-items-center" onclick="submitEducation()"><i class='bx bxs-save me-2' ></i>Save</button>
                </div>
                </form>
                <!-- form education end -->

            </div>
        </div>
        
        <div class="row bg-white p-4 rounded shadow mb-4">
            <div id="container-educations" class="col-md-12">
                @forelse($educations as $key => $education)
                <div class="education-item d-flex flex-remove-md justify-content-between mb-3">
                    <div class="col mb-2">
                        <p class="mb-1" style="color:#374785; font-weight:500"><span id="education-year_start-{{$key+1}}">{{$education->year_start}}</span> @if($education->year_end) - <span id="education-year_end-{{$key+1}}">{{$education->year_end}}</span> @else - Now<span id="education-year_end-{{$key+1}}"></span> @endif</p>
                        <h5 id="education-institution-{{$key+1}}" class="item-title mb-1">{{$education->institution}}</h5>
                        <div id="container-major-{{$key+1}}" class="mb-1 d-flex align-items-center gap-3">
                            <div id="education-major-{{$key+1}}" class="fs-11 fst-italic">{{$education->major}}</div>
                            @if($education->gpa)
                            <div id="container-gpa-{{$key+1}}" class="badge bg-primary text-white">
                                <span>GPA : </span>
                                <span id="education-gpa-{{$key+1}}">{{$education->gpa}}</span>
                                @if($education->gpa_limit)
                                / <span id="education-gpa_limit-{{$key+1}}">{{$education->gpa_limit}}</span>
                                @endif
                            </div>
                            @endif
                        </div>
                        <p id="education-description-{{$key+1}}" class="fs-10 text-secondary mb-2">{{$education->description}}</p>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex gap-2">
                            <i class="bx bx-edit-alt bx-border btn-outline-success" role="button" onclick="editEducation('{{$education->id}}', '{{$key+1}}')"></i>
                            <i class="bx bx-trash-alt bx-border btn-outline-danger" role="button" onclick="deleteEducation('{{$education->id}}')"></i>
                        </div>
                    </div>
                </div>
                @empty
                <span class="fs-11 text-muted fst-italic">You haven't submitted anything</span>
                @endforelse
            </div>
        </div>
        
        <div class="row mb-5">
            <div class="col-md-12 d-flex align-items-center justify-content-between">
                <span class="text-primary fs-14 d-flex align-items-center" role="button" onclick="navWizard('profile', 20)"><i class='bx bx-chevrons-left me-2' ></i>Previous</span>
                <span class="text-primary fs-14 d-flex align-items-center" role="button" onclick="navWizard('experience', 60)">Next<i class='bx bx-chevrons-right ms-2' ></i></span>
            </div>
        </div>

    </div>
</section>
