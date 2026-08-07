<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryControllerontroller extends Controller
{
    public function sport()
    {
        return "<h1>This is sport Category Page</h1>";
    }

    public function politic()
    {
        return "<h1>This is politic Category Page</h1>";
    }

    public function entertain()
    {
        return "<h1>This is entertain Category Page</h1>";
    }

    public function auto()
    {
        return "<h1>This is auto Category Page</h1>";
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // FILTER BY INPUT SEARCH        
        $keyword = $request->get('search', '');
        $query = Movie::where('title', 'LIKE', "%$keyword%")
                    ->orWhere('actor', 'LIKE', "%$keyword%");
        
        // PAGINATION
        $perPage = 25;
        $movie = $query->paginate($perPage);
        
        return view('movie.index', compact('movie'));
    }

    public function indexFilter(Request $request)
    {
        // FILTER BY INPUT SEARCH        
        $keyword = $request->get('search', '');
        $query = Movie::where(function ($q) use ($keyword) {
            $q->where('title', 'LIKE', "%$keyword%")
                ->orWhere('actor', 'LIKE', "%$keyword%");
        });
        // FILTER BY PRICE        
        $priceMin = $request->get('priceMin', 0);
        $priceMax = $request->get('priceMax', 10000);
        $query = $query->whereBetween('price', [$priceMin, $priceMax]);
        // FILTER BY CATEGORIES
        $category_ids = $request->get('category_ids', []);
        if (!empty($category_ids)) {
            $query = $query->whereIn('category_id', $category_ids);
        }
        // ORDER BY : default with best-seller
        $sort = $request->get('sort', 'best-seller');
        switch ($sort) {
            case "best-seller":
                $query = $query->orderBy('sold', 'desc');
                break;
            case "price-asc":
                $query = $query->orderBy('price', 'asc');
                break;
            case "price-desc":
                $query = $query->orderBy('price', 'desc');
                break;
        }
        // PAGINATION
        $perPage = 25;
        $movie = $query->paginate($perPage);
        // Category
        $category = Category::get();
        return view('movie.index2', compact('movie', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}