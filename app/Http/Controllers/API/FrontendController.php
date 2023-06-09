<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Catch_;
use Illuminate\Support\Facades\DB;
class FrontendController extends Controller
{
    //
    public function category()
    {
        $category = Category::where('status','0')->get();
        return response()->json([
            'status'=>200,
            'category'=>$category
        ]);
    }
    public function categoryHome()
    {
        $category = Category::where('status','0')->limit(8)->get();
        return response()->json([
            'status'=>200,
            'category'=>$category
        ]);
    }
    public function product($slug)
    {
        $category= Category::where('slug',$slug)->where('status','0')->first();
        if($category)
        {
            $product =Product::where('category_id',$category->id)->where('status','0')->get();
            if($product)
            {
                return response()->json([
                    'status'=>200,
                    'product_data'=>[
                        'product'=>$product,
                        'category'=>$category
                    ]
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>400,
                    'message'=>'No Product Available'
                ]);
            }
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No such Category Found'
            ]);
        }
    }
    public function viewproduct($category_slug,$product_slug)
    {
        $category= Category::where('slug',$category_slug)->where('status','0')->first();
        if($category)
        {
            $product = Product::where('category_id',$category->id)
                        ->where('slug',$product_slug)
                        ->where('status','0')
                        ->first();
            if($product)
            {
                return response()->json([
                    'status'=>200,
                    'product'=>$product
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>400,
                    'message'=>'No Product Available'
                ]);
            }
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No such Category Found'
            ]);
        }
    }
    public function allproduct()
    {

        $products= Product::limit(8)->orderBy(DB::raw('RAND()'))->get();
        return response()->json([
            'status'=>200,
            'products'=>$products,
        ]);
    }
    public function allproductother()
    {
        $products= Product::limit(3)->orderBy(DB::raw('RAND()'))->get();
        return response()->json([
            'status'=>200,
            'products'=>$products,
        ]);
    }

}
