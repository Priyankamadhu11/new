<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\AppBanner;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class AppBannerController extends Controller
{
    function list(Request $request)
    {
        $banner_types = [];
        if (theme_root_path() == 'default') {
            $banner_types = ["Main Banner", "Popup Banner", "Footer Banner","Main Section Banner"];
        }else if (theme_root_path() == 'theme_aster') {
            $banner_types = ["Main Banner", "Popup Banner", "Footer Banner","Main Section Banner","Header Banner","Sidebar Banner", "Top Side Banner","Section wise Banner"];
        }if (theme_root_path() == 'theme_fashion') {
            $banner_types = ["Main Banner", "Popup Banner", "Promo Banner Left", "Promo Banner Middle Top", "Promo Banner Middle Bottom", "Promo Banner Right", "Promo Banner Bottom"];
        }

        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $banners = AppBanner::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->Where('banner_type', 'like', "%{$value}%");
                }
            })->orderBy('id', 'desc');
            $query_param = ['search' => $request['search']];
        } else {
            $banners = AppBanner::orderBy('id', 'desc');
        }
        $banners = $banners->where('theme',theme_root_path())->whereIn('banner_type', $banner_types)->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.app_banner.view', compact('banners', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required',
            'image' => 'required',
        ], [
            'url.required' => 'url is required!',
            'image.required' => 'Image is required!',

        ]);

        $banner = new AppBanner;
        $banner->banner_type = $request->banner_type;
        $banner->resource_type = $request->resource_type;
        $banner->resource_id = $request[$request->resource_type . '_id'];
        $banner->title = $request->title;
        $banner->theme = theme_root_path();
        $banner->sub_title = $request->sub_title;
        $banner->button_text = $request->button_text;
        $banner->background_color = $request->background_color;
        $banner->url = $request->url;
        $banner->photo = ImageManager::upload('app-banner/', 'webp', $request->file('image'));
        $banner->save();
        Toastr::success(translate('banner_added_successfully'));
        return back();
    }

    public function status(Request $request)
    {
        if ($request->ajax()) {
            $banner = AppBanner::find($request->id);
            $banner->published = $request->status ?? 0;
            $banner->save();
            $data = $request->status ?? 0;
            return response()->json($data);
        }
    }

    public function edit($id)
    {
        $banner = AppBanner::where('id', $id)->first();
        return view('admin-views.app_banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'url' => 'required',
        ], [
            'url.required' => 'url is required!',
        ]);

        $banner = AppBanner::find($id);
        $banner->banner_type = $request->banner_type;
        $banner->resource_type = $request->resource_type;
        $banner->resource_id = $request[$request->resource_type . '_id'];
        $banner->title = $request->title;
        $banner->sub_title = $request->sub_title;
        $banner->button_text = $request->button_text;
        $banner->background_color = $request->background_color;
        $banner->url = $request->url;
        if ($request->file('image')) {
            $banner->photo = ImageManager::update('app-banner/', $banner['photo'], 'webp', $request->file('image'));
        }
        $banner->save();

        Toastr::success(translate('banner_updated_successfully'));
        return back();
    }

    public function delete(Request $request)
    {
        $br = AppBanner::find($request->id);
        ImageManager::delete('/app-banner/' . $br['photo']);
        AppBanner::where('id', $request->id)->delete();
        return response()->json();
    }
}
