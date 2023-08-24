<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Authority;
use App\Models\Profile;
use App\Models\Book;
use App\Models\Category;
use App\Models\Review;
use App\Models\LogVisit;
use App\Models\Notification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use DateTime;
use File;
use ZipArchive;
use Response;
use DB;

class AdminController extends Controller
{
    public function __construct() {
        $this->metaTags = [
            'title' => 'Digital Library',
            'description' => 'Unlock the World of Knowledge!',
        ];
    }
    public function user()
    {
        $users = (Auth::user()->authority->name == 'superadmin') ? User::get() : User::whereHas('authority', function (Builder $query) {
            $query->where('name', '!=', 'superadmin');
        })->get();
        return view('admin.user', [
            'dashboard_header' => '<i class="bx bxs-user me-3"></i><span>User Controller</span>',
            'metaTags' => $this->metaTags,
            'page_title' => 'Digital Library | Admin',
            'authorities' => Authority::get(),
            'users' => $users,
        ]);
    }
    public function book()
    {
        $logVisits = LogVisit::orderByDesc('created_at')->get();
        $records = [];

        // chartjs
        // $currentYear = date("Y"); 
        // $currentMonth = date("m");
        $startDateTime = new DateTime(date('Y-m-d', strtotime($logVisits->last()->created_at)));
        $currentDateTime = new DateTime(date("Y-m-d"));
        $month_days = date('d');
        // $month_days = cal_days_in_month(CAL_GREGORIAN, $startDateTime->format("m"), $startDateTime->format("Y"));
        // $dateArray = array();
        $days_in_month = array();
        $arr_elementary = array();
        $arr_junior = array();
        $arr_senior = array();
        for($i = 1; $i <= $month_days; $i++) {
            $days_in_month[] = $i;
            $elementary = 0;
            $junior = 0;
            $senior = 0;
            foreach($logVisits as $log) {
                if(date('Y-m-d', strtotime($log->created_at)) == date('Y-m-').$i && $log->role == 'student') {
                    if($log->grade_level == 'elementary') {
                        $elementary++;
                    } elseif($log->grade_level == 'junior') {
                        $junior++;
                    } elseif($log->grade_level == 'senior') {
                        $senior++;
                    }
                }
            }
            $arr_elementary[] = $elementary;
            $arr_junior[] = $junior;
            $arr_senior[] = $senior;
        }
        // while($startDateTime <= $currentDateTime) {
        //     $year = $startDateTime->format("Y");
        //     $month = $startDateTime->format("m");
        //     $monthName = $startDateTime->format("F");
        //     for($date = 1; $date <= $month_days; $date++) {
        //         $full_date = $year.'-'.$month.'-'.$date;
        //         $dateArray[$year][$monthName]['Elementary'][$date] = 0;
        //         $dateArray[$year][$monthName]['Junior High'][$date] = 0;
        //         $dateArray[$year][$monthName]['Senor High'][$date] = 0;
        //         foreach($logVisits as $log) {
        //             if(date('Y-m-d', strtotime($log->created_at)) == date('Y-m-d', strtotime($full_date)) && $log->role == 'student') {
        //                 if($log->grade_level == 'elementary') {
        //                     $dateArray[$year][$monthName]['Elementary'][$date]++;
        //                 } elseif($log->grade_level == 'junior') {
        //                     $dateArray[$year][$monthName]['Junior High'][$date]++;
        //                 } elseif($log->grade_level == 'senior') {
        //                     $dateArray[$year][$monthName]['Senor High'][$date]++;
        //                 }
        //             }
        //         }
        //     }
        //     $startDateTime->modify("+1 month");
        // }
        
        return view('admin.book', [
            'dashboard_header' => '<i class="bx bxs-book me-3"></i><span>Book Controller</span>',
            'metaTags' => $this->metaTags,
            'page_title' => 'Digital Library | Book Controller',
            'books' => Book::get(),
            'categories' => Category::orderBy('name')->get(),
            'reviews' => Review::orderByDesc('created_at')->get(),
            'logVisits' => $logVisits,
            'arr_elementary' => $arr_elementary,
            'arr_junior' => $arr_junior,
            'arr_senior' => $arr_senior,
            'days_in_month' => $days_in_month,
        ]);
    }
    public function suspend($user_id)
    {
        if(Auth::user() == $user_id) {
            return back()->with('error', "You can't suspend yourself");
        }
        $user = User::find($user_id);
        $status = ($user->status == 'suspended') ? 'active' : 'suspended';
        $user->update(['status' => $status]);
        return back()->with('success', "User's status is now : ".$status);
    }
    public function action(Request $request)
    {
        switch($request->action) {
            case 'get_user':
                $user = User::find($request->user_id);
                return response()->json([
                    'user' => $user,
                    'authority' => $user->authority,
                    'profile' => $user->profile,
                ], 200);
            break;
            case 'send_notification':
                $notificaton = Notification::create([
                    'user_id' => $request->user_id,
                    'subject' => ($request->subject) ? $request->subject : '-',
                    'message' => ($request->message) ? $request->message : '-',
                ]);
                return response()->json([
                    'message' => "Notification sent"
                ], 200);
            break;
            case 'change_authority':
                $update = User::find($request->user_id)->update(['authority_id' => $request->authority_id]);
                return response()->json([
                    'message' => 'User authority updated',
                ], 200);
            break;
            case 'reset_password':
                $user = User::find($request->user_id); $messages = []; $error = false;
                $password = $request->password; $password_confirmation = $request->password_confirmation;
                if($password != $password_confirmation) {
                    $error = true;
                    $messages[] = "password confirmation doesnt't match";
                }
                if(strlen($password) < 6) {
                    $error = true;
                    $messages[] = "must consist of at least 6 characters";
                }
                if($error == false) {
                    $user->update([ 'password' => Hash::make($request->password), ]);
                    return response()->json([
                        'message' => "password updated",
                    ], 200);
                }
                return response()->json([
                    'message' => 'An error occured',
                    'messages' => $messages,
                ], 400);
            break;
        }
    }
}
