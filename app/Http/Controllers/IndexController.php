<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Auth;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index()
    {
        // dd(
        //     Listing::where('beds', '>=', 4)
        //         ->orderBy('price', 'ASC')
        //         ->first()
        // );
        // Listing::make([
        //     'beds' => 2, 'baths' => 2, 'area' => 100, 'city' => 'North', 'street' => 'Tinker st', 'street_nr' => 20, 'code' => 'TS', 'price' => 200_000
        // ])

        //dd(Auth::user());
        //dd(Auth::check());
        return inertia('Index/Index', ['message' => 'Hello from Laravel!']);
    }
    public function show()
    {
        return inertia('Index/Show');
    }
}
