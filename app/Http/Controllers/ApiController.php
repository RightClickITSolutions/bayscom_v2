<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ApiController extends Controller
{
    //
    public function productList(){
        return Response (Product::all(),200);
    }
}
