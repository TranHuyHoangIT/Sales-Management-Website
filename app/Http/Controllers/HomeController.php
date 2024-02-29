<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;


class HomeController extends Controller
{


    public function banhang()
    {
        $products = DB::table('products')->get();
        foreach($products as $item){
            $item->supplier = DB::table("brands")->find($item->supplier)->name;
        }
        return view('banhang',[
            'products' => $products,
            'customers' => DB::table('customers')->get(),
        ]);
    }
    public function add_products(Request $request)
    {
        $name = $request->get('name');
        $quantity = $request->get('quantity');
        $price = $request->get('price');
        $price_cost = $request->get('price_cost');
        $category = $request->get('category');
        $sup = $request->get('sup');
       
        DB::table('products')->insert([
            [
                'name' => $name,
                'quantity' => $quantity,
                'price' => $price,
                'price_cost' => $price_cost,
                'category_id' =>  $category,
                'supplier' => $sup,
                'status'=> 1,
            ]

        ]);
        return redirect()->route('sanpham');
    }


    public function delete_products($id)
    {
        DB::table('products')->where('id', '=', $id)->update('status',0);
        return redirect()->route('sanpham');
    }

    public function delete_bill($id)
    {
        DB::table('bill')->where('id', '=', $id)->delete();
        return redirect()->route('donhang');
    }
    public function update_products($id)
    {
        $products =  DB::table('products')->where('id', '=', $id)->get();
        return response()->json([
            'products' => $products
        ]);
    }
    public function edit_products(Request $request, $id)
    {
        $name = $request->get('name');
        $quantity = $request->get('quantity');
        $price = $request->get('price');
        $category = $request->get('category');
        $price_cost = $request->get('price_cost');
        $sup = $request->get('sup');
        DB::table('products')
            ->where('id', $id)
            ->update([
                'name' => $name,
                'quantity' => $quantity,
                'price' => $price,
                'price_cost' => $price_cost,
                'category_id' =>  $category,
                'supplier' => $sup
            ]);
        return redirect()->route('sanpham');
    }
    public function add_employee(Request $request)
    {
        $randomString = strval(rand(10000, 99999));
        $email = $request->get('email');
        $name = $request->get('name');
        $gender = $request->get('gender');
        $address= $request->get("address");
        $sdt = $request->get("sdt");
        DB::table('users')->insert([
            [
                'email' => $email,
                'name' =>$name,
                'sdt' =>$sdt,
                'gender' => $gender,
                'address' => $address,
                'role' => 0,
                'password' => Hash::make($randomString)
            ]
        ]);
        $details = [
            'title' => 'Mật khẩu của bạn là',
            'body' => $randomString
        ];

        Mail::to($email)->send(new \App\Mail\MyTestMail($details));
        return redirect()->route('nhanvien');
    }

    public function add_customer(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $address = $request->address;
        $phone = $request->phone;
        $note = $request->note;
        DB::table('customers')->insert([
            [
                'email' => $email,
                'name' => $name,
                'address' => $address,
                'phone' => $phone,
                'note'  => $note
            ],
        ]);

        return redirect()->route('khachhang');
    }

    public function add_bill(Request $request)
    {
        $customer_id = null;
        $array_product = [];
    
        foreach ($request->all() as $name => $value){
            if($name =='customer_id'){
                $customer_id = $value;
            }
            if(str_contains($name, 'quality-product-')){
                $id= str_replace('quality-product-','',$name);
                $array_product[$id] = $value;
            }
        }
        $totalCost = 0;
        $totalPrice = 0;
        foreach ($array_product as $key => $value){
            $product = DB::table('products')->where('id', '=', $key)->first();
            $totalPrice += $product->price * $value;
            $totalCost += $product->price_cost * $value;
        }
        $billdata = DB::table('bill')->insertGetId(
            [
                'customer_id' => $customer_id,
                'nv_id' => Session::get('user')->id ?? 1,
                'total_price' => $totalPrice,
                'total_cost' =>  $totalCost,
                'created_at' => date('Y-m-d')
            ]
        );
        foreach ($array_product as $key => $value){
            $product = DB::table('products')->where('id', '=', $key)->first();
            if($product->quantity < $value){
                return response()->json([
                    'status' => -1,
                    'message' => 'Số lượng sản phẩm '.$product->name .' không đủ'
                ]);
            }
            $quantity = $product->quantity - $value;
            DB::table('products')
                ->where('id', $key)
                ->update([
                    'quantity' => $quantity,
                ]);
            DB::table('bill_detail')->insert(
                [
                    'bill_id' => $billdata,
                    'product_id' => $key,
                    'quality' => $value,
                    'total_price' => $product->price * $value,
                    'total_cost' => $product->price_cost * $value,
                ]
            );
        
            $day = now()->day;
            $month = now()->month;
            $year = now()->year;
            $check = DB::table('satistic')->where('product_id', '=', $key)->where('day', '=', $day)->where('month', '=', $month)->where('year', '=', $year)->first();
            if(!$check){
                DB::table('satistic')->insert(
                    [
                        'product_id' => $key,
                        'quality' => $value,
                        'total' => $product->price * $value,
                        'cost' => $product->price_cost * $value,
                        'day' => $day,
                        'month' => $month,
                        'year' => $year,
                    ]
                );
            }else{
                $total = $check->total + ($product->price * $value);
                $cost = $check->cost + ($product->price_cost * $value);
                $quality = $check->quality + $value;
                DB::table('satistic')
                    ->where('id', $check->id)
                    ->update([
                        'quality' => $quality,
                        'total' => $total,
                        'cost' => $cost,
                    ]);
            }
        }
        return response()->json([
            'status' => 1,
            'message' => 'Đã thêm thành công'
        ]);
    }

    public function bill_detail(Request $request){
        $id = $request->id;
        $data = DB::table('bill_detail')->where("bill_id",$id)->get();
        foreach($data as $item){
            $item->name = DB::table('products')->find($item->product_id)->name;
        }
        return view('donhangchitiet',[
            'data' => $data
        ]);
    }

    public function delete_users(Request $request, $id){
        DB::table('users')->where('id', '=', $id)->delete();
        return redirect()->route('nhanvien');
    }

    public function delete_customer(Request $request, $id){
        DB::table('customers')->where('id', '=', $id)->delete();
        return redirect()->route('khachhang');
    }
    public function update_users(Request $request){
        $products =  DB::table('users')->where('id', '=', $request->id)->get();
        return response()->json([
            'products' => $products
        ]);
    }

    public function update_customer(Request $request){
        $products =  DB::table('customers')->where('id', '=', $request->id)->get();
        return response()->json([
            'products' => $products
        ]);
    }
    public function edit_users(Request $request,$id){
        $email = $request->get('email');
        $name = $request->get('name');
        $gender = $request->get('gender');
        $address= $request->get("address");
        $sdt = $request->get("sdt");
        DB::table('users')
            ->where('id', $id)
            ->update([
                'email' => $email,
                'name' =>$name,
                'sdt' =>$sdt,
                'gender' => $gender,
                'address' => $address,
            ]);
        return redirect()->route('nhanvien');
    }

    public function edit_customer(Request $request,$id){
        $email = $request->get('email');
        $name = $request->get('name');
        $address = $request->get('address');
        $phone = $request->get('phone');
        $note = $request->get("note");

        DB::table('customers')
            ->where('id', $id)
            ->update([
                'email' => $email,
                'name' => $name,
                'address' => $address,
                'phone' => $phone,
                'note' => $note,
            ]);
        return redirect()->route('khachhang');
    }

}
