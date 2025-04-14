<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with('category')
            ->active()
            ->when($request->filled('category'), function ($q) use ($request) {
                return $q->whereHas('category', function ($cat) use ($request) {
                    $cat->where('slug', $request->category);
                });
            })
            ->when($request->filled('search'), function ($q) use ($request) {
                return $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('short_description', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('sort'), function ($q) use ($request) {
                if ($request->sort == 'price_low') {
                    return $q->orderBy('price', 'asc');
                } elseif ($request->sort == 'price_high') {
                    return $q->orderBy('price', 'desc');
                } elseif ($request->sort == 'newest') {
                    return $q->latest();
                } elseif ($request->sort == 'rating') {
                    return $q->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating');
                }
                return $q;
            }, function ($q) {
                return $q->latest();
            });
            
        $services = $query->paginate(12)->withQueryString();
        $categories = ServiceCategory::active()->orderBy('sort_order')->get();
        
        return view('services.index', compact('services', 'categories'));
    }

    public function show($slug)
    {
        $service = Service::with(['category', 'reviews' => function ($query) {
                $query->published()->latest();
            }])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();
            
        $relatedServices = Service::with('category')
            ->where('category_id', $service->category_id)
            ->where('id', '!=', $service->id)
            ->active()
            ->take(4)
            ->get();
            
        return view('services.show', compact('service', 'relatedServices'));
    }

    public function categoryShow($slug)
    {
        $category = ServiceCategory::where('slug', $slug)
            ->active()
            ->firstOrFail();
            
        $services = Service::with('category')
            ->where('category_id', $category->id)
            ->active()
            ->paginate(12);
            
        return view('services.category', compact('category', 'services'));
    }
}