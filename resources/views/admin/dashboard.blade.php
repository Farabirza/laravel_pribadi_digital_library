<!-- Check wether this user is an admin -->
@if(Auth::user()->role == 'user')
<?php header("Location: /?admin=false"); die(); ?>
@endif
<!-- Check wether this user is an admin -->

@extends('layouts.master')

@push('css-styles')
<link rel="stylesheet" href="{{ asset('/vendor/datatables/datatables.min.css') }}">
<link href="{{ asset('/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
<script src="{{ asset('/vendor/fontawesome/fontawesome.js') }}" crossorigin="anonymous"></script>
<style>
.section-title { font-family: 'Raleway',sans-serif; font-weight: bold; }
.title-dark, .icon-dark { color: #124265; } .title-light, .icon-light { color: #f1f1f1; }
.title-icon { font-size: 28pt; }
.form-label { color: #149ddd; }
table tr { vertical-align: middle; }
#section-assignments .modal label { color: #149ddd; }
#submissionsTable-container { border-top: 8px solid #fac863; display: none; }
#submissionsTable-time_limit { color: var(--bs-secondary); font-size: 11pt; }
#submissionsTable-description { font-size: 11pt; }

#container-user-profile { 
    display: none;
    padding: 20px;
    box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2); 
    border-top: 8px solid #fac863;
}
.user_name:hover { cursor: help; }

.attachment { padding: 10px 14px; border: 2px solid var(--bs-primary); border-radius: 8px; margin-right: 10px; color: var(--bs-primary); }
.attachment:hover { background: var(--bs-primary); color: white; cursor: pointer; }

@media (max-width: 768px) {
}
</style>
@endpush

@section('content')

<!-- section-assignments -->
<section id="section-assignments" class="ptb-40">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-3 text-center">
                <i class='bx bx-task title-icon icon-dark mb-2' ></i>
                <h2 class="section-title title-dark">Assignments Controller</h2>
            </div>

            <!-- assignmentsTable start -->
            <div class="col-md-12 mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <h4>Assignments Table</h4>
                </div>
                <div class="mb-2">
                    <table id="assignmentsTable" class="table table-striped">
                        <thead>
                            <th>#</th>
                            <th>Subject</th>
                            <th>Title</th>
                            <th>Target Group</th>
                            <th>Submission</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php $k = 1; ?>
                            @forelse($assignments as $item)
                            <tr>
                                <td>{{$k;}}</td>
                                <td>@if($item->subject_id == 0) <span class="color-primary">General</span> @else {{$item->subject->title;}} @endif</td>
                                <td><span class="popper" title="{{$item->description}}">{{$item->title}}</span></td>
                                <td>{{$item->group->name}}</td>
                                <td>{{$submission_count[$item->id]}} / {{$group_member_count[$item->group->name]}}</td>
                                <td>
                                    <a href="{{$item->id}}" class="assignment-edit btn btn-primary btn-sm mr-4"><i class='bx bx-edit'></i> Edit</a>
                                    <a href="{{$item->id}}" class="assignment-show btn btn-success btn-sm mr-4"><i class='bx bx-show'></i> Show</a>
                                    <a href="/delete_assignment/{{$item->id}}" class="btn-warn-delete btn btn-danger btn-sm mr-4"><i class='bx bx-trash'></i> Delete</a>
                                </td>
                                <?php $k++; ?>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center">No assignment data with subject found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mb-2"><a href="" class="new-assignment btn btn-primary"><i class='bx bx-plus' ></i> New Assignment</a></div>
                <p class="text-muted fst-italic">*Once created, assignment's subject and target group can't be changed</p>
            </div>
            <!-- assignmentsTable end -->

            <!-- submissionsTable -->
            <div id="submissionsTable-container" class="col-md-12 card padd-20 box-shadow-2 mb-4">
                <div class="submissionsTable-details mb-2">
                    <h4 id="submissionsTable-title" class="mb-2">Assignment Title</h4>
                    <p id="submissionsTable-time_limit" class="fst-italic mb-2">Time Limit</p>
                    <p id="submissionsTable-description">Description</p>
                </div>
                <!-- Attachment -->
                <div class="submissionsTable-attachment d-flex mb-2">
                    <div class="attachment-items d-flex">
                    </div>
                    <a href="#" class="btn btn-primary attachment-new"><i class='bx bx-plus' ></i> Add Attachment</a>

                    <!-- Modal Add Attachment -->
                    <div class="modal fade" id="modal-newAttachment" aria-hidden="true"> 
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add New Attachment</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="/new_attachment" id="form-newAttachment" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="assignment_id" id="newAttachment-assignment_id" value="">
                                    <input type="hidden" name="action" value="new_attachment">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name" id="newAttachment-name" class="form-control" placeholder="File Name" value="Default">
                                        <label for="newAttachment-name" class="label">File Name</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="label mb-2">Input File</label>
                                        <input class="form-control" id="newAttachment-file" name="file" type="file">
                                    </div>
                                    <div class="form-group">
                                        <label class="label mb-2">Description</label>
                                        <textarea name="description" id="newAttachment-description" rows="3" class="form-control" placeholder="Description"></textarea>
                                    </div>
                                    <p class="text-muted fst-italic">*Maximum file size : 50 Mb</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary mr-4" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-arrow-back'></i> Cancel</button>
                                    <button type="submit" class="btn btn-primary" id="submit-newAttachment"><i class='bx bx-paper-plane' ></i> Submit</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Add Attachment end -->
                    <!-- Modal Attachment Details -->
                    <div class="modal fade" id="modal-showAttachment" aria-hidden="true"> 
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Attachment Details</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="form-label">File Name</label>
                                        <input type="text" name="name" id="showAttachment-name" class="form-control" value="" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" id="showAttachment-description" rows="5" class="form-control" disabled></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn-cancel btn btn-secondary mr-4" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-arrow-back'></i> Cancel</button>
                                    <a href="/delete_attachment" id="showAttachment-delete" class="btn btn-danger btn-warn-delete mr-4"><i class='bx bx-trash-alt' ></i> Delete</a>
                                    <a href="/download_attachment" target="_blank" id="showAttachment-download" class="btn btn-primary"><i class='bx bx-download' ></i> Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Attachment Details end -->
                    <!-- Modal Personal Attachment -->
                    <div class="modal fade" id="modal-personalAttachment" aria-hidden="true"> 
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add Personal Attachment</h4>
                                    <button type="button" class="cancel-personalAttachment btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="/ajax_assignment" id="form-personalAttachment" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="assignment_id" id="personalAttachment-assignment_id" value="">
                                    <input type="hidden" name="user_id" id="personalAttachment-user_id" value="">
                                    <input type="hidden" name="action" value="new_personalAttachment">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name" id="personalAttachment-name" class="form-control" placeholder="File Name" value="Default">
                                        <label for="personalAttachment-name" class="label">File Name</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="label mb-2">Input File</label>
                                        <input class="form-control" id="personalAttachment-file" name="file" type="file">
                                    </div>
                                    <p class="text-muted fst-italic">*Maximum file size : 50 Mb</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="cancel-personalAttachment btn btn-secondary mr-4" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-arrow-back'></i> Cancel</button>
                                    <button type="submit" class="btn btn-primary" id="submit-personalAttachment"><i class='bx bx-paper-plane' ></i> Submit</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Personal Attachment end -->
                </div>
                <!-- Attachment end-->

                <table id="submissionsTable" class="table table-striped mb-4">
                    <thead>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Submitted At</th>
                        <th>Submission</th>
                        <th>Score</th>
                        <th>Response</th>
                        <th>Action</th>
                    </thead>
                    <tbody id="submissions-list">
                        <tr>
                            <td colspan="5" class="text-center">No submission data found</td>
                        </tr>
                    </tbody>
                </table>
                <p class="d-flex">
                    <a href="#" id="btn-download-all" class="btn btn-primary btn-sm mr-8"><i class="bx bx-download"></i> Archive and Download</a>
                    <a href="#" id="btn-confirm-all" class="btn btn-primary btn-sm mr-8"><i class="bx bx-check-square"></i> Confirm All</a>
                </p>
            </div>
            <!-- submissionsTable end -->
        </div> <!-- Row end -->

        <!-- Modal New Assignment -->
        <div class="modal fade" id="modal-assignment" aria-hidden="true"> 
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Assignment</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/new_assignment" method="POST">
                            @csrf
                            <div class="form-floating mb-3">
                                <select name="subject_id" id="assign_subject" class="form-control form-select" required>
                                    <option selected hidden disabled>Select subject</option>
                                    @forelse($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->title}}</option>
                                    @empty
                                    <option value="" disabled>You need to create a subject first</option>
                                    @endforelse
                                </select>
                                <label for="assign_group">Subject</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="assignment_title" id="assign_title" class="form-control" placeholder="Title" required>
                                <label for="assign_title">Title</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select name="assignment_group" id="assign_group" class="form-control form-select" required>
                                    <option selected hidden disabled>Select group</option>
                                    @forelse($groups as $group)
                                    @if($group->name == 'Uncategorized')
                                    <option value="-" disabled>You need to create a group first</option>
                                    @else
                                    <option value="{{$group->name}}">{{$group->name}}</option>
                                    @endif
                                    @empty
                                    <option value="-" disabled>You need to create a group first</option>
                                    @endforelse
                                </select>
                                <label for="assign_group">Target group</label>
                            </div>
                            
                            <div class="form-group">
                                <div class="d-flex mb-3">
                                    <div class="col form-floating">
                                        <input type="date" name="assignment_date_start" id="assign_date_start" class="form-control" value="{{$date_today}}" required>
                                        <label for="assign_date_start">Limit start date</label>
                                    </div>
                                    <span>&ensp;</span>
                                    <div class="col form-floating">
                                        <input type="date" name="assignment_date_end" id="assign_date_end" class="form-control" value="{{$date_today}}" required>
                                        <label for="assign_date_end">Limit end date</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="col form-floating">
                                        <input type="time" id="assign_time_start" name="assignment_time_start" value="00:00" class="form-control" required>
                                        <label for="assign_time_start">Open time</label>
                                    </div>
                                    <span>&ensp;</span>
                                    <div class="col form-floating">
                                        <input type="time" name="assignment_time_end" id="assign_time_end" class="form-control" value="23:59" required>
                                        <label for="assign_time_end">Close time</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="assign_description" class="mb-2">Description</label>
                                <textarea name="assignment_description" id="assign_description" style="height:100px" class="form-control" placeholder="Description"></textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                            <button type="button" id="cancel-newAssign" class="btn btn-secondary mr-4" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-arrow-back'></i> Cancel</button>
                            <button type="submit" id="submit-newAssign" class="btn btn-primary"><i class='bx bx-message-square-add' ></i> Create assignment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal New Assignment end -->
        
        <!-- Modal Score -->
        <div class="modal fade" id="modal-score" aria-hidden="true"> 
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Score</h4>
                        <button type="button" class="btn-close cancel-score" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form-score" action="/dashboard_ajax" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating mb-2">
                            <input type="number" min="0" max="100" id="input-score" class="form-control" placeholder="">
                            <label for="input-score">Score</label>
                        </div>
                        <p class="text-muted fst-italic mb-2">*Score Range: 0 - 100</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mr-4 cancel-score" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-arrow-back'></i> Cancel</button>
                        <button type="submit" class="btn btn-primary" id="submit-score"><i class='bx bx-paper-plane' ></i> Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Score end -->

        <!-- Modal Comment -->
        <div class="modal fade" id="modal-comment" aria-hidden="true"> 
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Comment</h4>
                        <button type="button" class="btn-close cancel-comment" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form-comment" action="/dashboard_ajax" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating">
                            <textarea name="comment" id="input-comment" style="height:100px" class="form-control" placeholder=""></textarea>
                            <label for="input-comment">Comment</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancel-comment mr-4" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-arrow-back'></i> Cancel</button>
                        <button type="submit" class="btn btn-primary" id="submit-comment"><i class='bx bx-paper-plane' ></i> Send</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Comment end -->
        
        <!-- Modal Edit Assignment -->
        <div class="modal fade" id="modal-edit-assignment" aria-hidden="true"> 
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Assignment</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/update_assignment" method="POST">
                            @csrf
                            <input type="hidden" id="editAssign_id" name="id" val="">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="editAssign_subject" name="subject" value="" placeholder="Subject" disabled>
                                <label for="editAssign_subject">Subject</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="editAssign_title" name="title" value="" placeholder="Title">
                                <label for="editAssign_title">Title</label>
                            </div>
                            <div class="form-group">
                                <div class="d-flex mb-3">
                                    <div class="col form-floating">
                                        <input type="date" name="date_start" id="editAssign_date_start" class="form-control" value="" required>
                                        <label for="editAssign_date_start">Limit start date</label>
                                    </div>
                                    <span>&ensp;</span>
                                    <div class="col form-floating">
                                        <input type="date" name="date_end" id="editAssign_date_end" class="form-control" value="" required>
                                        <label for="editAssign_date_end">Limit end date</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="col form-floating">
                                        <input type="time" id="editAssign_time_start" name="time_start" value="" class="form-control" required>
                                        <label for="editAssign_time_start">Open time</label>
                                    </div>
                                    <span>&ensp;</span>
                                    <div class="col form-floating">
                                        <input type="time" name="time_end" id="editAssign_time_end" class="form-control" value="" required>
                                        <label for="editAssign_time_end">Close time</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="editAssign_group" name="group" value="" placeholder="Group" disabled>
                                <label for="editAssign_group">Target group</label>
                            </div>
                            <div class="form-group">
                                <label class="mb-2">Description</label>
                                <textarea id="editAssign_description" name="description" rows="5" class="form-control" placeholder="Description"></textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mr-4" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-arrow-back'></i> Cancel</button>
                        <button type="submit" class="btn btn-primary" id="update-assignment"><i class='bx bx-edit-alt' ></i> Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Edit Assignment end -->

    </div>
</section>
<!-- section-assignments end -->

<!-- section-subjects -->
<section id="section-subjects" class="ptb-40 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 mb-3 text-center">
                <i class='bx bx-book-content title-icon icon-dark mb-2'></i>
                <h2 class="section-title title-dark">Subjects Controller</h2>
            </div>
            <div class="col-md-12">
                <h4 class="mb-3">Subject List</h4>


                <?php $j = 1; ?>
                <!-- subject item -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="subjectItem-heading-{{$j}}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#subjectItem-collapse-{{$j}}" aria-expanded="false" aria-controls="subjectItem-collapse-{{$j}}">
                            <b><i class='bx bx-message-square-add' ></i> Add New Subject</b>
                        </button>
                    </h2>
                    <div id="subjectItem-collapse-{{$j}}" class="accordion-collapse collapse" aria-labelledby="subjectItem-heading-{{$j}}">
                        <div class="accordion-body">
                            <form action="/new_subject" method="post">
                            @csrf
                            <p class="form-floating">
                                <input id="input-title-{{$j}}" type="text" class="form-control" name="title" value="" placeholder="Title">
                                <label for="input-title-{{$j}}" class="form-label">Title</label>
                            </p>
                            <p>
                                <label class="form-label">Description</label>
                                <textarea name="description" id="" rows="3" class="form-control" placeholder="Description"></textarea>
                            </p>
                            <p class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mr-8"><i class='bx bx-message-square-add' ></i> Create a new subject</button>
                            </p>
                            </form>
                        </div>
                    </div>
                </div>
                <?php $j++; ?>
                @forelse($subjects as $subject)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="subjectItem-heading-{{$j}}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#subjectItem-collapse-{{$j}}" aria-expanded="false" aria-controls="subjectItem-collapse-{{$j}}">
                            <b>{{ucfirst($subject->title)}}</b>
                        </button>
                    </h2>
                    <div id="subjectItem-collapse-{{$j}}" class="accordion-collapse collapse" aria-labelledby="subjectItem-heading-{{$j}}">
                        <div class="accordion-body">
                            <!-- <label class="form-label">References</label>
                            <p class="d-flex flex-wrap">
                                <a href="#" class="btn btn-primary btn-sm reference-new"><i class='bx bx-plus' ></i> Add reference</a>
                            </p> -->
                            @if(count($subject->assignment) > 0)<label class="form-label">Assignments</label>@endif
                            <p class="d-flex flex-wrap">
                                @forelse($subject->assignment as $assignment)
                                <span class="btn btn-sm btn-secondary disabled mb-2 mr-8">{{$assignment->title}}</span>
                                @empty
                                @endif
                            </p>
                            <form action="/update_subject" method="post">
                            @csrf
                            <input type="hidden" name="subject_id" value="{{$subject->id}}">
                            <input type="hidden" name="old_title" value="{{$subject->title}}">
                            <p class="form-floating">
                                <input id="input-title-{{$j}}" type="text" class="form-control" name="title" value="{{$subject->title}}" placeholder="Title">
                                <label for="input-title-{{$j}}" class="form-label">Title</label>
                            </p>
                            <p>
                                <label class="form-label">Description</label>
                                <textarea name="description" id="" rows="3" class="form-control" placeholder="Description">{{$subject->description}}</textarea>
                            </p>
                            <p class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mr-8"><i class='bx bx-edit-alt' ></i> Update</button>
                                <a type="button" href="/delete_subject/{{$subject->id}}" class="btn btn-danger btn-warn-delete mr-3 @if(Auth::user()->role != 'superadmin') disabled @endif"><i class='bx bx-trash'></i> Delete</a>
                            </p>
                            </form>
                        </div>
                    </div>
                </div>
                <?php $j++; ?>
                @empty
                @endforelse
            </div>
        </div>
    </div>
</section>
<!-- section-subjects end -->

<!-- section-users -->
<section id="section-users" class="ptb-40">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 mb-3 text-center">
                <i class='bx bxs-user title-icon icon-dark mb-2' ></i>
                <h2 class="section-title title-dark">Users Controller</h2>
            </div>
            <div class="col-md-12 mb-3">
                <h4 class="mb-3">Users Table</h4>
                <table id="usersTable" class="table table-striped mb-2">
                    <thead class="text-center">
                        <th>#</th>
                        <th>Name</th>
                        <th>Grade</th>
                        <th>Role</th>
                        <th>Group</th>
                        <th>Star point</th>
                        @if(Auth::user()->role === "superadmin")
                        <th>Action</th>
                        @endif
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @forelse($users as $user)
                        <tr>
                            <td>{{$i;}}</td>
                            <td>
                                <a href="{{ asset('/img/profiles/'.$user->profile->image) }}" data-title="{{$user->profile->first_name}} {{$user->profile->last_name}}" data-description="{{$user->profile->gender}} | {{$user->group->name}}" class="glightbox">
                                    <img src="{{ asset('/img/profiles/'.$user->profile->image) }}" id="user-img" class="rounded-circle">
                                </a>
                                <span class="user_name popper" title="{{$user->email}}">{{$user->profile->first_name.' '.$user->profile->last_name}}</span>
                            </td>
                            <td>@if($user->profile->grade == null) - @else {{ucfirst($user->profile->grade)}} @endif</td>
                            <td>{{ucfirst($user->role)}}</td>
                            <td><a href="{{$user->id}}" class="change_group popper" @if($user->group->name==='Uncategorized') style="color:#e95344;" @endif title="Change group">{{ucfirst($user->group->name)}}</a></td>
                            <td class="text-center"><i class='bx bxs-star mr-3 text-warning'></i> 
                                @if($user->star_point) <span id="point-amount-{{$user->id}}">{{$user->star_point->amount}}</span>
                                @else <span id="point-amount-{{$user->id}}">0</span>
                                @endif
                            </td>
                            @if(Auth::user()->role === "superadmin")
                            <td>
                                <a href="{{$user->id}}" class="btn-show_profile btn btn-success btn-sm mb-2 mr-3"><i class='bx bx-show'></i> Profile</a>
                                <button class="btn btn-secondary btn-sm dropdown-toggle mb-2 mr-3" type="button" id="dropdown-user-action-{{$i}}" data-bs-toggle="dropdown" aria-expanded="false">Action &nbsp;</button>
                                <ul class="dropdown-menu" aria-labelledby="dropdown-user-action-{{$i}}">
                                    <li><a class="dropdown-item btn-warn" href="/change_role/{{$user->id}}/user"><i class='bx bx-user'></i> Turn into user</a></li>
                                    <li><a class="dropdown-item btn-warn" href="/change_role/{{$user->id}}/admin"><i class='bx bxs-user'></i> Turn into admin</a></li>
                                    <li><a class="dropdown-item btn-warn" href="/change_role/{{$user->id}}/superadmin"><i class='bx bxs-star'></i> Turn into superadmin</a></li>
                                    <li><a class="dropdown-item btn-warn" href="/reset_password/{{$user->id}}"><i class='bx bx-key'></i> Reset password</a></li>
                                    <li><a class="dropdown-item btn-warn-delete" href="/delete_user/{{$user->id}}"><i class='bx bx-trash'></i> Delete user</a></li>
                                </ul>
                                <button class="btn btn-primary btn-sm dropdown-toggle mb-2 mr-3" type="button" id="dropdown-user-point-{{$i}}" data-bs-toggle="dropdown" aria-expanded="false"><i class='bx bxs-star mr-3'></i> Point &nbsp;</button>
                                <ul class="dropdown-menu" aria-labelledby="dropdown-user-point-{{$i}}">
                                    <li><a class="dropdown-item btn-point-add" href="{{$user->id}}"><i class='bx bxs-star'></i> Add</a></li>
                                    <li><a class="dropdown-item btn-point-reduce" href="{{$user->id}}"><i class='bx bx-star'></i> Reduce</a></li>
                                    <li><a class="dropdown-item btn-point-reset" href="{{$user->id}}"><i class='bx bx-reset'></i> Reset</a></li>
                                </ul>
                            </td>
                            @endif
                            <?php $i++; ?>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No data found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <p class="text-muted fst-italic">*Click on user's group name to change that spesific user's group</p>
                
                <!-- modal change group -->
                <div class="modal fade" id="modal-change_group" aria-hidden="true"> 
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <form action="/change_group" method="post">
                            @csrf
                                <div class="modal-header d-flex justify-content-between vertical-center">
                                    <h4 class="modal-title">Change User Group</h4>
                                    <button type="button" id="cancel-change_group" class="btn btn-secondary btn-sm mr-4"><i class="fa-solid fa-x"></i></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="user_id" id="user_id" value="">
                                    <select name="group" id="select-change_group" class="form-control form-select">
                                        <option value="-" selected disabled hidden>Select Group</option>
                                        @forelse($groups as $group)
                                        <option value="{{$group->name}}">{{$group->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class='bx bx-arrow-back'></i> Cancel</button>
                                    <button type="submit" class="btn btn-primary" id="submit-change_group"><i class='bx bx-edit-alt' ></i> Change</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- modal change group end --> 

            </div> <!-- end col -->
            <div id="container-user-profile" class="col-md-12 mb-4"></div>
            </div> <!-- end col -->
        </div>
    </div>
</section>
<!-- section-users end -->

<!-- section-groups -->
<section id="section-groups" class="ptb-40 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 mb-3 text-center">
                <i class='bx bx-group title-icon icon-dark mb-2' ></i>
                <h2 class="section-title title-dark">Groups Controller</h2>
            </div>
            <div class="col-md-12">
                <h4 class="mb-3">Group List</h4>

                <!-- group item -->
                <?php $i = 1; ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="groupItem-heading-{{$i}}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#groupItem-collapse-{{$i}}" aria-expanded="false" aria-controls="groupItem-collapse-{{$i}}">
                            <b><i class='bx bx-message-square-add' ></i> Add New Group</b>
                        </button>
                    </h2>
                    <div id="groupItem-collapse-{{$i}}" class="accordion-collapse collapse" aria-labelledby="groupItem-heading-{{$i}}">
                        <div class="accordion-body">
                            <form action="/new_group" method="post">
                            @csrf
                            <p class="form-floating">
                                <input id="input-group-name-{{$i}}" type="text" class="form-control" name="name" value="" placeholder="Name">
                                <label for="input-group-name-{{$i}}" class="form-label">Name</label>
                            </p>
                            <p class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mr-8"><i class='bx bx-message-square-add' ></i> Create a new group</button>
                            </p>
                            </form>
                        </div>
                    </div>
                </div>
                <?php $i++; ?>
                <!-- group item end -->
                <!-- group item -->
                @forelse($groups as $group)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="groupItem-heading-{{$i}}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#groupItem-collapse-{{$i}}" aria-expanded="false" aria-controls="groupItem-collapse-{{$i}}">
                            <b>{{$group->name}}</b>
                        </button>
                    </h2>
                    <div id="groupItem-collapse-{{$i}}" class="accordion-collapse collapse" aria-labelledby="groupItem-heading-{{$i}}">
                        <div class="accordion-body">
                            <label class="form-label"><i class='bx bx-user mr-4' ></i> Admins</label>
                            <p id="container-group-admin-{{$group->id}}" class="mb-3 d-flex flex-wrap">
                                @forelse($group->group_admin as $admin)
                                    <a id="group-admin-{{$admin->id}}" class="btn btn-secondary btn-sm mb-2 mr-4 popper btn-group-admin-remove @if(Auth::user()->role != 'superadmin') disabled @endif" href="{{$admin->id}}" title="Remove group admin">{{$admin->email}}</a>
                                @empty
                                @endforelse
                                <a class="btn btn-primary btn-sm mb-2 mr-4 btn-group-admin @if(Auth::user()->role != 'superadmin') disabled @endif" href="{{$group->id}}"><i class='bx bx-user-plus mr-3' ></i> Assign admin</a>
                            </p>
                            <label class="form-label"><i class='bx bx-group mr-4' ></i> Members</label>
                            <p class="mb-3 d-flex flex-wrap">
                                @forelse($group->user as $user)
                                    <span class="btn btn-secondary btn-sm mb-2 mr-4 disabled">{{$user->email}}</span>
                                @empty
                                @endforelse
                            </p>
                            <label class="form-label"><i class='bx bx-file mr-4' ></i> References</label>
                            <p id="container-group-admin-{{$group->id}}" class="mb-3 d-flex flex-wrap">
                                @forelse($group->reference as $reference)
                                    <a class="btn btn-secondary btn-sm mb-2 mr-4 btn-reference-show" data-url="{{$reference->url}}" data-title="{{$reference->title}}" href="{{$reference->id}}">{{$reference->title}}</a>
                                @empty
                                @endforelse
                                <a class="btn btn-primary btn-sm mb-2 mr-4 btn-reference-add" href="{{$group->id}}"><i class='bx bxs-file-plus mr-3' ></i> Add reference</a>
                            </p>
                            <label class="form-label"><i class='bx bx-file mr-4' ></i> Assignments</label>
                            <p class="mb-3 d-flex flex-wrap">
                                @forelse($group->assignment as $item)
                                    <span class="btn btn-secondary btn-sm mb-2 mr-4 disabled">{{$item->title}}</span>
                                @empty
                                @endforelse
                            </p>
                            <hr class="mb-3">
                            <div class="groupItem-action">
                                <form action="/update_group" method="post">
                                @csrf
                                <input type="hidden" name="group_id" value="{{$group->id}}">
                                <div class="form-group d-flex mb-3">
                                    <div class="col mr-8">
                                        <input id="input-group-name-{{$i}}" type="text" class="form-control" name="group_name" value="{{$group->name}}" placeholder="Name">
                                    </div>
                                        <button type="submit" class="btn btn-primary mr-8 @if(Auth::user()->role != 'superadmin') disabled @endif"><i class='bx bx-edit-alt' ></i> Update group</button>
                                        <a href="/delete_group/{{$group->id}}" class="btn btn-danger btn-warn mr-8 @if(Auth::user()->role != 'superadmin') disabled @endif"><i class='bx bx-trash-alt' ></i> Delete group</a>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $i++; ?>
                @empty
                @endforelse
                <!-- group item end -->
                
                <!-- Modal Group Admin -->
                <div class="modal fade" id="modal-group-admin" aria-hidden="true"> 
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Assign Group Admin</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="/group_admin_assign" id="form-group-admin" method="POST">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="group_id" value="">
                                <div class="form-group mb-3">
                                    <select id="select-group-admin" name="group_admin" class="form-control form-select">
                                        <option value="select" selected disabled hidden>Select user</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->email}} | {{$user->profile->first_name.' '.$user->profile->last_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary mr-4" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-arrow-back'></i> Cancel</button>
                                <button type="submit" class="btn btn-primary" id="submit-group-admin"><i class='bx bx-user-plus' ></i> Assign</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal Group Admin end -->

                <!-- Modal Reference Add -->
                <div class="modal fade" id="modal-reference-add" aria-hidden="true"> 
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Add Reference</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="/reference_add" id="form-reference-add" method="POST">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="group_id" class="group_id" value="">
                                <div class="form-floating mb-3">
                                    <input type="text" name="title" class="form-control" placeholder="Title">
                                    <label for="title" class="form-label">Title</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="url" class="form-control" placeholder="URL">
                                    <label for="url" class="form-label">URL</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary mr-4" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-arrow-back'></i> Cancel</button>
                                <button type="submit" class="btn btn-primary" id="submit-reference-add"><i class='bx bxs-file-plus' ></i> Add</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal Reference Add end -->

                <!-- Modal Reference Show -->
                <div class="modal fade" id="modal-reference-show" aria-hidden="true"> 
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Reference Detail</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="/reference_update" id="form-reference-add" method="POST">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="reference_id" class="reference_id" value="">
                                <div class="form-floating mb-3">
                                    <input type="text" id="reference-edit-title" name="title" class="form-control" placeholder="Title">
                                    <label for="title" class="form-label">Title</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" id="reference-edit-url" name="url" class="form-control" placeholder="URL">
                                    <label for="url" class="form-label">URL</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary mr-4" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-arrow-back'></i> Cancel</button>
                                <a class="btn btn-danger btn-warn mr-4 btn-reference-delete" href="/reference_delete"><i class='bx bx-trash-alt'></i> Delete</a>
                                <a class="btn btn-success btn-reference-url" href="/" target="_blank"><i class='bx bx-link'></i> Visit</a>
                                <button type="submit" class="btn btn-primary" id="submit-reference-show"><i class='bx bx-edit-alt' ></i> Update</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal Reference Show end -->

            </div> <!-- col end -->
        </div> <!-- row end -->
    </div>
</section>
<!-- section-groups end -->

@include('layouts.partials.footer')

@endsection

@push('scripts')
<script src="{{ asset('/vendor/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('/vendor/purecounter/purecounter.js') }}">
$(document).ready(function(){
    var purecounter = new PureCounter({
        selector: ".purecounter",
        duration: 2,
        delay: 10,
        once: true,
    });
});
</script>
<script type="text/javascript">
const lightbox = GLightbox({
    touchNavigation: true,
    loop: true,
    autoplayVideos: true
});
$(document).ready(function(){
    $('.nav-link').removeClass('active');
    $('.nav-link-admin').addClass('active');
    var usersTable = $('#usersTable').DataTable();
    var assignmentsTable = $('#assignmentsTable').DataTable();
    
    usersTable.on('order.dt search.dt', function () {
        let i = 1;
        usersTable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
        });
    }).draw();
    assignmentsTable.on('order.dt search.dt', function () {
        let j = 1;
        assignmentsTable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(j++);
        });
    }).draw();
});
</script>
<script src="{{ asset('/js/ajax_dashboard_3.js') }}"></script>
@endpush