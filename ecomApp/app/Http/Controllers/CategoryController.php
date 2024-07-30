<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\Size;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CategoryController extends Controller
{
    public function add_category(){
        $categories = Category::all();
        return view('category.category',[
            'categories'=>$categories

        ]);
    }
    public function add_category_post(Request $request){
        $request->validate([
            'category_name'=> 'required',
            'category_img'=> 'required',

        ]);
        $image=$request->category_img;
        $extension=$image->extension();
        $file_name=Str::lower(str_replace(' ', '-', $request->category_name)).'-'.random_int(100, 1000000).'.'.$extension;
        $image->move(public_path('uploads/'),$file_name);
        Category::insert([
            'category_name'=>$request->category_name,
            'category_img'=>$file_name,

        ]);
        return back()->with('category_status','Category Added Successfully');




    }
    public function add_subcategory(){
        $categories = Category::all();
        return view('category.subcategory',[
            'categories'=>$categories

        ]);
    }
    public function add_subcategory_post(Request $request){
        $request->validate([
            'subcategory_name'=> 'required',
            'category_id'=> 'required',

        ]);

        Subcategory::insert([
            'subcategory_name'=>$request->subcategory_name,
            'category_id'=>$request->category_id,

        ]);
        return back()->with('category_status','Subcategory Added Successfully');




    }
    public function add_brand(){
        $categories = Category::all();
        return view('category.brand',[
            'categories'=>$categories

        ]);
    }
    public function add_brand_post(Request $request){
        $request->validate([
            'brand_name'=> 'required',
            'brand_img'=> 'required',

        ]);
        $image=$request->brand_img;
        $extension=$image->extension();
        $file_name=Str::lower(str_replace(' ', '-', $request->brand_name)).'-'.random_int(100, 1000000).'.'.$extension;
        $image->move(public_path('uploads/brand'),$file_name);
        Brand::insert([
            'brand_name'=>$request->brand_name,
            'brand_img'=>$file_name,

        ]);
        return back()->with('category_status','Brand Added Successfully');




    }
    public function add_product(){
        $categories=Category::all();
        $brands = Brand::all();
        return view('product.product',[
            'categories'=>$categories,
            'brands'=>$brands
        ]);
    }
    public function getsubcategory(Request $request){
        $str='<option value="">Select Subcategory</option>';
        $subcategories=Subcategory::where('category_id',$request->category_id)->get();
        foreach($subcategories as $subcategory){
            $str.='<option value="'.$subcategory->id.'">'.$subcategory->subcategory_name.'</option>';

        }
        echo $str;

    }
    function product_store(Request $request){
        $after_implode=implode(' ',$request->tags);
        $preview=$request->preview;
            $extension=$preview->extension();
            $file_name=Str::lower(str_replace(' ','-',$request->product_name)).'-'.random_int(100000,900000).'.'.$extension;
           $preview->move(public_path('uploads/preview/'),$file_name);
            $product_id=Product::insertGetId([
                'category_id'=>$request->category_id,
                'subcategory_id'=>$request->subcategory_id,
                'brand_id'=>$request->brand_id,
                'price'=>$request->price,
                'product_name'=>$request->product_name,
                'discount'=>$request->discount,
                'after_discount'=>$request->price - ($request->price*$request->discount/100),
                'tags'=>$after_implode,
                'short_desp'=>$request->short_desp,
                'long_desp'=>$request->long_desp,
                'addi_info'=>$request->addi_info,
                'preview'=>$file_name,
                'slug'=>Str::lower(str_replace(' ','-',$request->product_name)).'-'.random_int(1000000,9000000),

            ]);
            $gallery=$request->gallery;

            foreach($gallery as $gal){


                $extension=$gal->extension();
                $file_name=Str::lower(str_replace(' ','-',$request->product_name)).'-'.random_int(100000,900000).'.'.$extension;
                $gal->move(public_path('uploads/gallery/'),$file_name);
                ProductGallery::insert([
                    'product_id'=>$product_id,
                    'gallery'=>$file_name,
                ]);
            }
            return back();
    }
    function add_variation(){
        $colors=Color::all();
        $categories=Category::all();
        return view('category.variation',[
            'colors'=>$colors,
            'categories'=>$categories
        ]);
    }
    function size_store(Request $request){
        Size::insert([
            'size_name'=>$request->size_name,
            'category_id'=>$request->category_id,
            'created_at'=>Carbon::now(),
        ]);

    }
    function product_list(){
        $products=Product::all();
        return view('category.list',[
            'products'=>$products,
        ]);
    }
    function inventory($id){
        $product=Product::find($id);
        $colors=Color::all();
        return view('category.inventory',[
            'product'=>$product,
            'color'=>$colors,
        ]);

    }

    function inventory_store(Request $request,$id){
        Inventory::insert([
            'product_id'=>$id,
            'color_id'=>$request->color_id,
            'size_id'=>$request->size_id,
            'quantity'=>$request->quantity,

        ]);
        return back();
    }
    function product_details($slug){
        $product_id=Product::where('slug', $slug)->first()->id;
        $product_details=Product::find( $product_id);
        $available_color=Inventory::where('product_id',$product_id)->groupBy('color_id')->selectRaw('count(*) as total,color_id')->get();
        $available_size=Inventory::where('product_id',$product_id)->groupBy('size_id')->selectRaw('count(*) as total,size_id')->get();
        $cookie_info=Cookie::get('recent_view');
        if(!$cookie_info){
            $cookie_info='[]';

        }
        $all_info=json_decode($cookie_info, true);
        $all_info=Arr::prepend($all_info, $product_id);
        $recent_viewed_id=json_encode($all_info);
        Cookie::queue('recent_view',$recent_viewed_id, 10000);


        return view('frontend.product_details',[
            'product_details'=>$product_details,
            'available_color'=>$available_color,
            'available_size'=>$available_size,
        ]);
    }
    function register(){
        return view('customerAuth.register');
    }
    function login(){
        return view('customerAuth.login');
    }
    function register_store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|captcha'
        ]);
        Customer::insert([
            'fname'=>$request->fname,
            'lname'=>$request->lname,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),



        ]);
        if(Auth::guard('customer')->attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect()->route('index');
         }

    }
    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
    function login_store(Request $request){
        if(Customer::where('email',$request->email)->exists()){
            if(Auth::guard('customer')->attempt(['email'=>$request->email, 'password'=>$request->password])){
                return redirect()->route('index');

            }
        }
        else{
            echo 'Email Does Not Exist';
        }
    }
    function index(){
        return view('frontend.index');
    }
    function profile(){
        return view('frontend.profile');
    }
    function logout(){
        Auth::guard('customer')->logout();
        return redirect('/');




    }
    function cart_store(Request $request){

        Cart::insert([
            'customer_id'=>Auth::guard('customer')->id(),
            'product_id'=>$request->product_id,
            'color_id'=>$request->color_id,
            'size_id'=>$request->size_id,
            'quantity'=>$request->quantity,

           ]);
           return back()->with('card_success','Card Added Successfully');

    }
    function recent_view(){
        $recent_view=json_decode(Cookie::get('recent_view'));
        if($recent_view==Null){
            $recent_view=[];
            $after_unique=array_unique($recent_view);
        }
        else{
            $after_unique=array_unique($recent_view);
        }
        $recent_view_product=Product::find($after_unique);
        return view('frontend.recent_view',[
            'recent_viewed_product'=>$recent_view_product
        ]);
    }

}


