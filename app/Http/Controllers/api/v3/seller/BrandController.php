<?php

namespace App\Http\Controllers\api\v3\seller;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Brand;
use Illuminate\Http\Request;
use App\CPU\ImageManager;


class BrandController extends Controller
{
    public function getBrands()
    {
        try {
            $brands = Brand::all();
        } catch (\Exception $e) {
        }

        return response()->json($brands,200);
    }

    public function add_brand(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands,name',
            'image' => 'required',
        ], [
            'name.required'   => 'Brand name is required!',
            'name.unique'     => 'The brand has already been taken.',
        ]);

        try {

            $seller = $request->seller;

            if ($seller) 
            {
                $sellerId = $seller->id;
                $brand = new Brand;
                $brand->name = $request->name;
                $brand->image = ImageManager::upload('brand/', 'webp', $request->file('image'));
                $brand->status = 1;
                $brand->seller_id = $sellerId;
                $brand->save();
                return response()->json(['success' => 'Brand added successfully','Brand'=>$brand], 200);
            } 
            else 
            {
                return response()->json(['error' => 'Seller not authenticated'], 401);
            }
        } 
        catch (\Exception $e) 
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function brand_list(Request $request)
    {
        $seller_id=$request->seller->id;
        try 
        {
            if($seller_id)
            {
                $brands=Brand::where('seller_id',$seller_id)->where('status',1)->get();
                return response()->json(['brands' => $brands, 'status' => 200]);
            }
            else
            {
                return response()->json(['error' => 'Seller not authenticated'], 401);
            }
        }
        catch (\Throwable $th) 
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
