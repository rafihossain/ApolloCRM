<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

use File;
use Image;

class AddsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function addList()
    {
       return view('/admin/ads/adslist');
    }

    public function categorieList()
    {
       return view('/admin/ads/categorie-list');
    }

    public function addCategorie()
    {
       return view('/admin/ads/add-categorie');
    }

    public function brandList()
    {
        $brands = Brand::get()->toArray();
        return view('/admin/ads/brand-list')->with('brands', $brands);
    }

    public function addBrand()
    {
       return view('/admin/ads/add-brand');
    }

    public function saveBrand(Request $request){

        $validatedData = $request->validate([
            'brand_name' => 'required',
            'status' => 'required',
            //'brand_image' => 'required',
            // 'brand_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $request_image = $request->file('brand_image');

        if(!empty($request_image)){

        $image = Image::make($request_image);
        $image_path = public_path('/images/brands/');
        $img_name = time().'.'.$request_image->getClientOriginalExtension();
        $image->save($image_path.$img_name);

        $image_name = $image_path."thumbnail/".$img_name;
        $image->resize(200, 200);

        $image->save($image_name);

        
        }else{
            if(empty($request->pre_image)){
                $img_name = $request->pre_image;
            }
           
        }

        $brand = new Brand();
        $brand->brand_name = $request->brand_name;
        $brand->status = $request->status;
        $brand->brand_image = $img_name;
        $brand->save();

        return redirect()->route('backend.brand-list.brandList')->with('message', 'Brand Stored successfully.');
    }

    public function brandEdit($id){
        $brand = Brand::get()->find($id)->toArray();
        return view('/admin/ads/edit-brand')->with('brand',$brand);
    }

    public function updateBrand(Request $request ,$id){
        $validatedData = $request->validate([
            'brand_name' => 'required',
            'status' => 'required',
            //'brand_image' => 'required',
            // 'brand_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $request_image = $request->file('brand_image');

        if(!empty($request_image)){

        $image = Image::make($request_image);
        $image_path = public_path('/images/brands/');
        $img_name = time().'.'.$request_image->getClientOriginalExtension();
        $image->save($image_path.$img_name);

        $image_name = $image_path."thumbnail/".$img_name;
        $image->resize(200, 200);

        $image->save($image_name);

        
        }else{
            if(!empty($request->pre_image)){
                $img_name = $request->pre_image;
            }
           
        }
        

        $brand = Brand::find($id);
        $brand->brand_name = $request->brand_name;
        $brand->status = $request->status;
        $brand->brand_image = $img_name;
        $brand->update();
        return redirect()->route('backend.brand-list.brandList')->with('message', 'Brand Update successfully.');
    }
}
