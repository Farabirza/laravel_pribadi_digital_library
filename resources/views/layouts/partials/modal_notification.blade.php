<style>
</style>

@if(Auth::check() && count(Auth::user()->notification) > 0)
@php
    $count_notification = 0;
    foreach(Auth::user()->notification as $notif) {
        if($notif->read == 0) {
            $count_notification++;
        }
    }
@endphp
<i id="btn-notification" class="bx bx-bell shadow" role="button" onclick="showNotification()">
    @if($count_notification > 0)
    <span class="translate-middle badge rounded-pill">{{$count_notification}}</span>
    @endif
</i>

<!-- Modal notification start -->
<div class="modal fade" id="modal-notification" aria-hidden="true"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mb-3 d-flex align-items-center justify-content-between">
                    <h5 class="modal-title d-flex align-items-center gap-2"><i class='bx bx-bell'></i>Notification</h5>
                    <span class="text-primary d-flex align-items-center gap-2" data-bs-dismiss="modal" aria-label="Close" role="button" onclick="notificationRead()"><i class="bx bx-check-double"></i>Mark as read</span>
                </div>
                <div id="container-notifications" class="list-group mb-3">
                    @foreach(Auth::user()->notification->sortByDesc('created_at') as $notification)
                    @if($notification->read == 0)
                    <div class="notification-item list-group-item">
                    @else
                    <div class="notification-item list-group-item" style="background: #f1f1f1">
                    @endif
                        <p class="fs-9 text-secondary mb-0">{{date('d/m/Y', strtotime($notification->created_at))}}</p>
                        <p class="fs-11 text-primary mb-0">{{$notification->subject}}</p>
                        <p class="fs-10 mb-0">{!! $notification->message !!}</p>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-end">
                    <a href="/notification/clear" class="btn btn-secondary btn-sm gap-2"><i class="bx bx-trash-alt"></i>Clear all</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal notification end -->

@endif

@push('scripts')
<script type="text/javascript">
const notificationRead = () => {
    let config = {
        method: 'post', url: domain + 'action/notification',
        data: { action: 'mark_read' }
    }
    axios(config)
    .then((response) => {
        $('.notification-item').css({'background-color': '#f1f1f1'});
    })
    .catch((error) => {
        console.log(error);
    });
};

const showNotification = () => {
    $('#modal-notification').modal('show');
};
</script>
@endpush