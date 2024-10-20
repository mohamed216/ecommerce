<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->query('size')?$request->query('size'):12;
        $o_column = "";
        $o_order = "";
        $order = $request->query('order') ? $request->query('order') : -1;
       switch ($order)
       {
           case 1:
               $o_column = 'created_at';
               $o_order='DESC';
               break;
           case 2:
               $o_column = 'created_at';
               $o_order='ASC';
               break;
           case 3:
               $o_column = 'sale_price';
               $o_order='ASC';
               break;
           case 4:
               $o_column = 'sale_price';
               $o_order='DESC';
               break;
           default:
               $o_column = 'id';
               $o_order='DESC';
               break;
       }
        $brands = Brand::orderBy("name","ASC")->get();
        $f_brands = $request->query('brands');
        $f_categories = $request->query('categories');
        $sorting = $request->query('sorting')?$request->query('sorting'):'default';
        $categories = Category::orderBy('name','ASC')->get();
        $min_price = $request->query('min')?$request->query('min'):1;
        $max_price = $request->query('max')?$request->query('max'):10000;
        if($sorting=='date')
        {
            $products = Product::whereBetween('regular_price',[$min_price,$max_price])
                ->where(function($query) use ($f_brands){
                    $query->whereIn('brand_id',explode(',',$f_brands))->orWhereRaw("'".$f_brands."' = ''");
                })
                ->where(function($query) use ($f_categories){
                    $query->whereIn('category_id',explode(',',$f_categories))->orWhereRaw("'".$f_categories."' = ''");
                })
                ->orderBy('created_at','DESC')->paginate($size);
        }
        else if($sorting=="price")
        {
            $products = Product::whereBetween('regular_price',[$min_price,$max_price])
                ->where(function($query) use ($f_brands){
                    $query->whereIn('brand_id',explode(',',$f_brands))->orWhereRaw("'".$f_brands."' = ''");
                })
                ->where(function($query) use ($f_categories){
                    $query->whereIn('category_id',explode(',',$f_categories))->orWhereRaw("'".$f_categories."' = ''");
                })
                ->orderBy('regular_price','ASC')->paginate($size);
        }
        else if($sorting=="price-desc")
        {
            $products = Product::whereBetween('regular_price',[$min_price,$max_price])
                ->where(function($query) use ($f_brands){
                    $query->whereIn('brand_id',explode(',',$f_brands))->orWhereRaw("'".$f_brands."' = ''");
                })
                ->where(function($query) use ($f_categories){
                    $query->whereIn('category_id',explode(',',$f_categories))->orWhereRaw("'".$f_categories."' = ''");
                })
                ->orderBy('regular_price','DESC')->paginate($size);
        }
        else{
            $products = Product::whereBetween('regular_price',[$min_price,$max_price])
                ->where(function($query) use ($f_brands){
                    $query->whereIn('brand_id',explode(',',$f_brands))->orWhereRaw("'".$f_brands."' = ''");
                })
                ->where(function($query) use ($f_categories){
                    $query->whereIn('category_id',explode(',',$f_categories))->orWhereRaw("'".$f_categories."' = ''");
                })
                ->paginate($size);
        }

        return view('shop',compact("products","min_price","max_price","size","sorting","categories","brands","f_brands","f_categories","order"));
    }

    public function product_details($product_slug)
    {
        $product = Product::where("slug",$product_slug)->first();
        $rproducts = Product::where("slug","<>",$product_slug)->get()->take(8);


        return view('details',compact("product","rproducts"));
    }
}
