
<section id="section-wizard-config" class="section-wizard px-3 d-none">
    <div class="container">

        <div class="row bg-white p-4 rounded shadow mb-4">
            <div class="col-md-12">
                <h2 class="section-title mt-3 mb-4">Config</h2>
                <div class="mb-3">
                    <label class="form-label">Profile and cover image</label>
                    <div id="container-cover_image" class="px-4 py-5 text-center rounded">
                        <label for="input-user-picture">
                        @if(Auth::user()->profile && Auth::user()->profile->cover_image != null)
                        <img id="config-user-picture" src="{{asset('img/profiles/'.Auth::user()->picture)}}" class="rounded rounded-circle shadow popper" style="max-height:160px;" type="button" title="change profile image">
                        @else
                        <img id="config-user-picture" src="{{asset('img/profiles/user.jpg')}}" class="rounded rounded-circle shadow popper" style="max-height:160px;" type="button" title="change profile image">
                        @endif
                        </label>
                        <input id="input-user-picture" class="absolute d-none" name="input-user-picture" type="file" accept="image/*">
                        <p class="mt-4 mb-0">
                            <label for="config-cover_image" class="btn btn-sm btn-light"><span class="d-flex align-items-center"><i class="bx bx-image-alt me-2"></i>Change cover image</span></label>
                        </p>
                    </div>
                </div>

                <!-- form config start -->
                @if(Auth::user()->config)
                <form action="ajax/config/{{Auth::user()->config->id}}" method="put" id="form-config" class="m-0">
                @else
                <form action="ajax/config" method="post" id="form-config" class="m-0">
                @endif
                <div class="mb-3">
                    <label for="accessibility" class="form-label">Accessibility</label>
                    <select name="accessibility" id="config-accessibility" class="form-select form-select-sm mb-2">
                        <option value="public">Public</option>
                        <option value="registered">Registered</option>
                        <option value="private">Private</option>
                    </select>
                    <p class="mb-2 fs-9 text-muted fst-italic">*) decide who can access your cv page</p>
                </div>
                </form>
                <!-- form config end -->

                <div class="mb-3">
                    <label class="form-label">Select theme</label>
                    <div class="row">
                        @forelse($themes as $key => $theme)
                        <div class="col-md-3 px-2 pb-3">
                            <div class="card">
                                <img src="{{asset('img/theme_preview/'.$theme->image)}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{$theme->title}}</h5>
                                    @if($theme->description)
                                    <p class="card-text fs-10 text-muted">{{$theme->description}}</p>
                                    @else
                                    <p class="card-text fs-10 text-muted">{{$theme->title}} is a cool and interactive online portfolio layout that will blow your mind</p>
                                    @endif
                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                        @if(Auth::user()->config && Auth::user()->config->preference->theme_id == $theme->id)
                                        <button id="btn-select-theme-{{$key+1}}" class="btn-select-theme btn btn-primary btn-sm d-flex align-items-center" onclick="selectTheme('{{$theme->id}}', '{{$key+1}}')"><i class="bx bx-check-double me-2"></i>Selected</button>
                                        @else
                                        <button id="btn-select-theme-{{$key+1}}" class="btn-select-theme btn btn-outline-primary btn-sm d-flex align-items-center" onclick="selectTheme('{{$theme->id}}', '{{$key+1}}')"><i class="bx bx-check me-2"></i>Select</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <hr class="col me-3"/>
                    <button id="config-btn-submit" type="button" class="btn btn-success d-flex align-items-center" onclick="submitConfig()"><i class='bx bxs-save me-2' ></i>Save</button>
                </div>
            </div>
        </div>
        
        <div class="row mb-5">
            <div class="col-md-12 d-flex align-items-center justify-content-between">
                <span class="text-primary fs-14 d-flex align-items-center" role="button" onclick="navWizard('skill', 80)"><i class='bx bx-chevrons-left me-2' ></i>Previous</span>
                <div id="btn-config-finish">
                    @if(Auth::user()->config)
                    <a href="/cv/{{Auth::user()->username}}?success=your page is now live!" class="text-primary fs-14 d-flex align-items-center">Finish<i class='bx bx-chevrons-right ms-2' ></i></a>
                    @else
                    <span class="text-secondary fs-14 d-flex align-items-center popper" role="button" title="please save your configuration to continue">Finish<i class='bx bx-chevrons-right ms-2' ></i></span>
                    @endif
                </div>
            </div>
        </div>

    </div>
</section>

<!-- modal user picture cropper -->
<div class="modal fade" id="modal-user-picture-cropper" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title d-flex align-items-center fw-semibold"><i class='bx bx-selection me-2'></i><span>Select Picture</span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img id="img-crop" src="">
                        </div>
                        <div class="col-md-4">
                            <div class="user-picture-cropper-preview mx-3 mb-3" style="overflow: hidden; height: 180px; border: 1px solid #404040"></div>
                            <p class="mb-0 mx-3 fs-11">Select and crop image</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary d-flex align-items-center" data-bs-dismiss="modal"><i class='bx bx-exit me-2' ></i>Cancel</button>
                <button type="button" class="btn btn-primary d-flex align-items-center" id="user-picture-crop"><i class='bx bx-crop me-2' ></i>Crop</button>
            </div>
        </div>
    </div>
</div>
<!-- modal user picture cropper end -->

<!-- modal cover image start cropper -->
<div class="modal fade" id="modal-cover_image" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title d-flex align-items-center fw-semibold"><i class='bx bx-image-alt me-2'></i><span>Cover Image</span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="action/profile" method="post" id="form-cover_image" class="m-0">
                <img id="preview-cover_image" src="" class="rounded mb-3">
                <input type="file" name="cover_image" accept="image/*" id="config-cover_image" class="form-control mb-2">
                <p class="mb-2 fs-9 text-muted fst-italic">*) maximum file size: 2 MB</p>
                <p class="mb-2 fs-9 text-muted fst-italic">*) recommended aspect ratio: 16:9 or 1920x1080px</p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary d-flex align-items-center" data-bs-dismiss="modal"><i class='bx bx-exit me-2' ></i>Cancel</button>
                <button type="button" class="btn btn-primary d-flex align-items-center" onclick="submitCover()"><i class='bx bx-save me-2' ></i>Save</button>
            </div>
        </div>
    </div>
</div>
<!-- modal cover image cropper end -->
@if(Auth::user()->config)
<script type="text/javascript">
$(document).ready(function() { 
    $(`[name="accessibility"] option[value="`+'{{Auth::user()->config->accessibility}}'+`"]`).prop('selected', true);
});
</script>
@endif
<script type="text/javascript">
var username = '{{Auth::user()->username}}';
</script>
