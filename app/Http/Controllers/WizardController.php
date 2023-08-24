<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Education;
use App\Models\WorkHistory;
use App\Models\Skill;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WizardController extends Controller
{
    public function __construct() {
        $this->metaTags = [
            'title' => 'Digital Library',
            'description' => 'Unlock the World of Knowledge!',
        ];
    }
    public function index() {
        return view('dashboard.wizard', [
            'metaTags' => $this->metaTags,
            'page_title' => 'Digital Library | Wizard',
            'dashboard_header' => '<i class="bx bxs-cog me-3"></i><span>Wizard</span>',
        ]);
    }
}
