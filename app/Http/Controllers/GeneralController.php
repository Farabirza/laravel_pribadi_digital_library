<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\LogVisit;
use App\Models\Book;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Response;

class GeneralController extends Controller
{
    public function __construct() {
        $this->metaTags = [
            'title' => 'Digital Library',
            'description' => 'Unlock the World of Knowledge!',
        ];
    }
    public function index()
    {   
        return redirect('/book');
    }
    public function action(Request $request)
    {
        switch ($request->action) {
        }
    }
}
