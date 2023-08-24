<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Education;
use App\Models\WorkHistory;
use App\Models\Experience;
use App\Models\Certificate;
use App\Models\Skill;
use App\Models\Theme;
use App\Models\LogVisit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct() {
        $this->metaTags = [
            'title' => 'cvkreatif.com',
            'description' => 'Build your personal online portfolio for free!',
        ];
    }
    public function isReady()
    {
        if(!Auth::user()->config) { return redirect('/')->with('error', "Please finish the quick setup before accessing this page"); }
    }
    public function index()
    {
        return view('dashboard.overview', [
            'metaTags' => $this->metaTags,
            'page_title' => 'cvkreatif.com | Dashboard',
            'dashboard_header' => '<i class="bx bxs-dashboard me-3"></i><span>Overview</span>',
        ]);
    }
    public function config()
    {
        return view('dashboard.edit_config', [
            'metaTags' => $this->metaTags,
            'page_title' => 'cvkreatif.com | Configuration',
            'dashboard_header' => '<i class="bx bx-cog me-3"></i><span>Configuration</span>',
            'themes' => Theme::get(),
        ]);
    }
    public function edit_profile()
    {
        $this->isReady();
        return view('dashboard.edit_profile', [
            'page_title' => 'cvkreatif.com | Edit Profile',
            'dashboard_header' => '<i class="bx bx-edit-alt me-3"></i><span>Edit Profile Data</span>',
            'profile' => Auth::user()->profile,
        ]);
    }
    public function edit_education()
    {
        $this->isReady();
        return view('dashboard.edit_education', [
            'page_title' => 'cvkreatif.com | Edit Education',
            'dashboard_header' => '<i class="bx bxs-graduation me-3"></i><span>Edit Education Data</span>',
            'educations' => Education::where('user_id', Auth::user()->id)->orderByDesc('year_start')->orderByDesc('year_end')->get(),
        ]);
    }
    public function edit_experience()
    {
        $this->isReady();
        return view('dashboard.edit_experience', [
            'page_title' => 'cvkreatif.com | Edit Education',
            'dashboard_header' => '<i class="bx bxs-graduation me-3"></i><span>Edit Education Data</span>',
            'work_histories' => WorkHistory::where('user_id', Auth::user()->id)->orderByDesc('year_start')->orderByDesc('year_end')->get(),
            'experiences' => Experience::where('user_id', Auth::user()->id)->orderByDesc('year_start')->orderByDesc('year_end')->get(),
        ]);
    }
    public function edit_certificate()
    {
        $this->isReady();
        return view('dashboard.edit_certificate', [
            'page_title' => 'cvkreatif.com | Edit Certificate',
            'dashboard_header' => '<i class="bx bx-file me-3"></i><span>Edit Certificate Data</span>',
            'certificates' => Certificate::where('user_id', Auth::user()->id)->orderByDesc('year_obtained')->get(),
        ]);
    }
    public function edit_skill()
    {
        $this->isReady();
        return view('dashboard.edit_skill', [
            'page_title' => 'cvkreatif.com | Edit Skill',
            'dashboard_header' => '<i class="bx bx-bulb me-3"></i><span>Edit Skill Data</span>',
            'skills' => Skill::where('user_id', Auth::user()->id)->orderBy('name')->get(),
        ]);
    }
}
