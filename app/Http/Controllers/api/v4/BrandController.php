<?php

namespace App\Http\Controllers\api\v4;

use App\CPU\BrandManager;
use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;

class BrandController extends Controller
{
    public function get_brands()
    {
        try {
            $brands = BrandManager::get_active_brands();
        } catch (\Exception $e) {
        }

        return response()->json($brands,200);
    }

    public function get_products(Request $request, $brand_id)
    {
        try {
            $products = BrandManager::get_products($brand_id, $request);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }

        return response()->json($products,200);
    }

    public function refurbished_products(Request $request)
    {
        try {
            $products = Product::where('used_or_new',1)->get();
           
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
        if(count($products)>0){

            return response()->json($products,200);
        }
        else
        {
            return response()->json(translate('There is no refurbished products'));
        }
    }

}
