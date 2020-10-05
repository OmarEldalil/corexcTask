<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $products = DB::table('products');
        if($request->has('search')){
            $products->where('title', 'like', "%".$request->get('search') ."%");
        }
        $products = $products->paginate(20);
        return view('index', [
            'products' => $products
        ]);
    }
}
