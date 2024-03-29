<?php

namespace App\Http\Controllers\Seller;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Exports\BrandListExport;
use App\Http\Controllers\Controller;
use App\Model\Admin;
use App\Model\Brand;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Translation;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;

class SellerbrandController extends Controller
{
    public function add_new()
    {
         $sellerId = auth('seller')->id();
       // dd($sellerId);
        $br = Brand::latest()->paginate(Helpers::pagination_limit());
        $language=\App\Model\BusinessSetting::where('type','pnc_language')->first();
        $language = $language->value ?? null;
        $default_lang = 'en';

        return view('seller-views.brand.add-new', compact('br', 'language', 'default_lang', 'sellerId'));
    }

    public function store(Request $request)
    {
        //dd($request);
         $sellerId = auth('seller')->id();
        //dd($sellerId);
        $request->validate([
            'name.0' => 'required|unique:brands,name',
        ], [
            'name.0.required'   => 'Brand name is required!',
            'name.0.unique'     => 'The brand has already been taken.',
        ]);

        $brand = new Brand;
        $brand->name = $request->name[array_search('en', $request->lang)];
        $brand->image = ImageManager::upload('brand/', 'webp', $request->file('image'));
        $brand->status = 1;
        $brand->seller_id = $sellerId;
        $brand->save();

        foreach($request->lang as $index=>$key)
        {
            if($request->name[$index] && $key != 'en')
            {
                Translation::updateOrInsert(
                    ['translationable_type'  => 'App\Model\Brand',
                        'translationable_id'    => $brand->id,
                        'locale'                => $key,
                        'key'                   => 'name'],
                    ['value'                 => $request->name[$index]]
                );
            }
        }
        Toastr::success(translate('brand_added_successfully'));
        return back();
    }

    /**
     * Brand list show, search
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    // function list(Request $request)
    // {
    //     $search      = $request['search'];
    //     $query_param = $search ? ['search' => $request['search']] : '';

    //     $br = Brand::withCount('brandAllProducts')
    //         ->with(['brandAllProducts'=> function($query){
    //             $query->withCount('order_details');
    //         }])
    //         ->when($request['search'], function ($q) use($request){
    //             $key = explode(' ', $request['search']);
    //             foreach ($key as $value) {
    //                 $q->Where('name', 'like', "%{$value}%")
    //                   ->orWhere('id', $value);
    //             }
    //         })
    //         ->latest()->paginate(Helpers::pagination_limit())->appends($query_param);

    //     return view('seller-views.brand.list', compact('br','search'));
    // }

    public function list(Request $request)
    {
        $sellerId = auth('seller')->id();

        $search = $request['search'];
        $query_param = $search ? ['search' => $request['search']] : '';

        $br = Brand::withCount('brandAllProducts')
            ->with(['brandAllProducts' => function ($query) {
                $query->withCount('order_details');
            }])
            ->when($request['search'], function ($q) use ($request) {
                $key = explode(' ', $request['search']);
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%")
                        ->orWhere('id', $value);
                }
            })
            ->where('seller_id', $sellerId) 
            ->latest()
            ->paginate(Helpers::pagination_limit())
            ->appends($query_param);

        return view('seller-views.brand.list', compact('br', 'search'));
    }

    /**
     * Export brand list by excel
     * @return string|\Symfony\Component\HttpFoundation\StreamedResponse
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Common\Exception\InvalidArgumentException
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     * @throws \Box\Spout\Writer\Exception\WriterNotOpenedException
     */
    public function export(Request $request){
        $search = $request['search'];
        $brands = Brand::withCount('brandAllProducts')
            ->with(['brandAllProducts'=> function($query){
                $query->withCount('order_details');
            }])
            ->when($search, function ($q) use($search){
                $key = explode(' ', $search);
                foreach ($key as $value) {
                    $q->Where('name', 'like', "%{$value}%")
                      ->orWhere('id', $value);
                }
            })->orderBy('id', 'DESC')->get();

        // $data = array();
        // foreach($brands as $brand){
        //     $data[] = array(
        //         'Brand Name'      => $brand->name,
        //         'Total Product'   => $brand->brand_all_products_count,
        //         'Total Order' => $brand->brandAllProducts->sum('order_details_count'),
        //     );
        // }
        // dd($brands);
        $active = $brands->where('status',1)->count();
        $inactive = $brands->where('status',0)->count();
        $data = [
            'brands'=>$brands,
            'search' =>$search ,
            'active' => $active,
            'inactive' => $inactive,
        ];
        return Excel::download(new BrandListExport($data), 'Brand-list.xlsx') ;
        // return (new FastExcel($data))->download('brand_list.xlsx');
    }

    public function edit($id)
    {
        $b = Brand::where(['id' => $id])->withoutGlobalScopes()->first();
        return view('seller-views.brand.edit', compact('b'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name.0' => 'required|unique:brands,name,'.$id,
        ], [
            'name.0.required'   => 'Brand name is required!',
            'name.0.unique'     => 'The brand has already been taken.',
        ]);

        $brand = Brand::find($id);
        $brand->name = $request->name[array_search('en', $request->lang)];
        if ($request->has('image')) {
            $brand->image = ImageManager::update('brand/', $brand['image'], 'webp', $request->file('image'));
         }
        $brand->save();
        foreach ($request->lang as $index => $key) {
            if ($request->name[$index] && $key != 'en') {
                Translation::updateOrInsert(
                    ['translationable_type' => 'App\Model\Brand',
                        'translationable_id' => $brand->id,
                        'locale' => $key,
                        'key' => 'name'],
                    ['value' => $request->name[$index]]
                );
            }
        }

        Toastr::success(translate('brand_updated_successfully'));
        return back();
    }

    public function status_update(Request $request)
    {
        $brand = Brand::find($request['id']);
        $brand->status = $request['status'] ?? 0;

        if($brand->save()){
            $success = 1;
        }else{
            $success = 0;
        }
        return response()->json([
            'success' => $success,
        ], 200);
    }

    public function delete(Request $request)
    {
        $translation = Translation::where('translationable_type','App\Model\Brand')
                                    ->where('translationable_id',$request->id);
        $translation->delete();
        $brand = Brand::find($request->id);
        ImageManager::delete('/brand/' . $brand['image']);
        $brand->delete();
        return response()->json();
    }
}
