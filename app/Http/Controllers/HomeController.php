<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredServices = Service::with('category')
            ->active()
            ->featured()
            ->latest()
            ->take(6)
            ->get();
            
        $categories = ServiceCategory::active()
            ->orderBy('sort_order')
            ->take(6)
            ->get();
            
        return view('home', compact('featuredServices', 'categories'));
    }
    
    public function about()
    {
        return view('about');
    }
    
    public function contact()
    {
        return view('contact');
    }
    
    public function terms()
    {
        return view('terms');
    }
    
    public function privacy()
    {
        return view('privacy');
    }
}
