<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $blogs = Blog::all()->count(); // Assuming you have a Blog model
        $users = User::all()->count(); // Assuming you have a User model
        return view('dashboard', compact('blogs', 'users'));
    }
}
