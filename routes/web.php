<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\CheckLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;


// use GuzzleHttp\Psr7\Request;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('viewlogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/miss-pass',function(Request $request){
    $email = $request->email;
    $randomString = strval(rand(10000, 99999));
    DB::table('users')->where('email',$email)->update(
        ['password' =>Hash::make($randomString)]
    );
    $details = [
        'title' => 'Mật khẩu mới của bạn là:',
        'body' => $randomString
    ];
    Mail::to($email)->send(new \App\Mail\MyTestMail($details));
    return redirect()->back()->withSucsesss('Email hoặc mật khẩu không đúng');
})->name('miss_pass');
Route::middleware([CheckLogin::class])->group(function ()
{
    Route::get('/', function ()
    {
        return view('index');
    })->name('index');

    Route::post('/change_pass', function (Request $request)
    {
        $pass = $request->pass;
        $passNew = $request->newpass;
        $user = Session::get('user');

        if( Hash::check($pass,$user->password)){
            $passnew = Hash::make($passNew);
            DB::table('users')->where('id',$user->id)->update(['password' => $passnew]);
            return response()->json([
            'status' => 1
            ]);
        }else{
            return response()->json([
                'status' => -1
                ]);
        }
        
    })->name('change_pass');
    Route::get('/sanpham', function ()
    {
        $products = DB::table('products')->get();
        $categorys = DB::table('category')->get();
        $sup = DB::table('brands')->get();
        // return response()->json([
        //     'products' => $products
        // ]);
        return view('sanpham', [
            'products'=>$products,
            'categorys'=>$categorys,
            'sup' => $sup
        ]);
    })->name('sanpham');

    Route::get('/thongkesanpham', function (){
        $results = DB::table('bill_detail')
            ->select('product_id', DB::raw('SUM(quality) AS quality_product'))
            ->groupBy('product_id')
            ->orderByDesc('quality_product')
            ->limit(10)
            ->get();
        foreach ($results as $item){
            $item->name = DB::table('products')->where('id', '=', $item->product_id)->first()->name;
        }

        return view('thongkesanpham', [
            'results' => $results
        ]);
    })->name('thongkesanpham');

    Route::get('/thongkekhachhang', function (){
        $results = DB::table('bill')
            ->select('customer_id', DB::raw('SUM(total_price) AS total_cus_price'))
            ->groupBy('customer_id')
            ->orderByDesc('total_cus_price')
            ->limit(5)
            ->get();
        foreach ($results as $item){
            $item->name = DB::table('customers')->where('id', '=', $item->customer_id)->first()->name;
        }
        return view('thongkekhachhang', [
            'results' => $results
        ]);
    })->name('thongkekhachhang');
    Route::get('/thongkenhanvien', function (Request $request)
    {
        $currentDate = new DateTime();
        $currentDate->modify('-7 days');

        $dateEnd = date('Y-m-d');
        $dateStart = $currentDate->format('Y-m-d');

        if($request->date_start && $request->date_end){
            $dateStart = $request->date_start;
            $dateEnd = $request->date_end;
        }

        $results = DB::table('bill')
            ->select('nv_id', DB::raw('SUM(total_price) AS total_revenue'))
            ->whereBetween('created_at', [$dateStart, $dateEnd])
            ->groupBy('nv_id')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();
        $data = [];
        foreach ($results as $item){
                $user =  DB::table('users')->where('id', '=', $item->nv_id)->first();
            $item->name = $user->name . " (" . $user->id . ")";
            $data[$item->nv_id] = $item;
        }
        
        $arrLalbe =[];
        $stringLable ='';
        $dataKeys = array_keys($data);
        $arrData = [];
        $users = DB::table('users')->get();
        foreach ($users as $user){
            $stringLable  .= $user->name . '('.$user->id.') ,';
            if(in_array($user->id,$dataKeys)){
                $count = $data[$user->id]->total_revenue;
            }else{
                $count = 0;
            }
            $arrData[] = $count;
        }
          
    
        return view('thongkenhanvien', [
            'chartLabel' =>             $stringLable,

            'chartData' =>             implode(', ', ($arrData)),
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,

        ]);
    })->name('thongkenhanvien');

    Route::get('/thongkeloinhuan', function (Request $request)
    {
        $timeSelect = 7;
        if($request->time){
        
            $timeSelect = $request->time;
            
        }
        $totalPrice              = DB::table('bill')->sum('total_price');
        $totalCost               = $totalPrice - DB::table('bill')->sum('total_cost');

        $data = [];
        $data2= [];
        $label = [];
        if($timeSelect == 'year'){
            for($i = 0; $i < 12; $i++)
            {
                $timenow = now();
                $year = $timenow->year;
                $label[] = 'Tháng '.($i+1);

                $data[$i] = DB::table('satistic')
                    ->where('month', '=', $i+1)
                    ->where('year', '=', $year)
                    ->sum('total');
                $cost =DB::table('satistic')
                    ->where('month', '=', $i+1)
                    ->where('year', '=', $year)
                    ->sum('cost');
                $data2[$i] = $data[$i] - $cost;
            }
            $label = array_reverse($label);
            $data = array_reverse($data);
            $data2 = array_reverse($data2);
        }else{
            for($i = 0; $i < $timeSelect; $i++)
            {
                $timenow = now();
                
                $dataTime = $timenow->subDay($i);
                $date = $dataTime;
                $label[] = $date->format('d-m-Y');
                $day = $dataTime->day;
                $month = $dataTime->month;
                $year = $dataTime->year;
                $data[$i] = DB::table('satistic')
                    ->where('day', '=', $day)
                    ->where('month', '=', $month)
                    ->where('year', '=', $year)
                    ->sum('total');
                $cost =DB::table('satistic')
                    ->where('day', '=', $day)
                    ->where('month', '=', $month)
                    ->where('year', '=', $year)
                    ->sum('cost');
                $data2[$i] = $data[$i] - $cost;
            }
        }
      

        return view('thongkeloinhuan',
            [

                'totalPrice'        => $totalPrice,
                'totalCost'         => $totalCost,
                'dataChart'              => implode(', ', array_reverse($data)),
                'dataChart2'              => implode(', ', array_reverse($data2)),
                'labelChart'              => implode(', ', array_reverse($label)),
                'timeSelect'        => $timeSelect,
            ]
        );
    })->name('thongkeloinhuan');

    Route::get('/thongke', function ()
    {
        $totalProductBIll        = DB::table('bill_detail')->sum('quality');
        $totalPrice              = DB::table('bill')->sum('total_price');
        $totalCustomerBest       = DB::table('bill')
            ->select('customer_id', DB::raw('SUM(total_price) as total_spent'))
            ->groupBy('customer_id')
            ->orderByDesc('total_spent')
            ->first();
        $totalCustomerBest->name = DB::table('customers')->where('id', '=', $totalCustomerBest->customer_id)->first()->name;
        $productBest             = DB::table('bill_detail')
            ->select('product_id', DB::raw('SUM(quality) as total_quality'))
            ->groupBy('product_id')
            ->orderByDesc('total_quality')
            ->first();
        $productBest->name       = DB::table('products')->where('id', '=', $productBest->product_id)->first()->name;

        $time = now();
        $data = [];
        for($i = 0; $i < 7; $i++)
        {
            $dataTime = $time->subDay($i);
            $day = $dataTime->day;
            $month = $dataTime->month;
            $year = $dataTime->year;
            $data[$i] = DB::table('satistic')
                ->where('day', '=', $day)
                ->where('month', '=', $month)
                ->where('year', '=', $year)
                ->sum('quality');
        }
        return view('thongke',
            [
                'totalProductBIll'  => $totalProductBIll,
                'totalPrice'        => $totalPrice,
                'totalCustomerBest' => $totalCustomerBest,
                'productBest'       => $productBest,
                'dataChart'              => implode(', ', array_reverse($data))
        ]
        );
    })->name('thongke');


   

    Route::get('/api/sanpham', function (Request $request)
    {
        $keyword = $request->id;
        $type = $request->type;

        $products = DB::table('products')->leftJoin('brands', 'products.supplier', '=', 'brands.id')->select('products.*', 'brands.name as supname');
            if( $type ){
                $products->where( $type, 'like', '%' . $keyword . '%');
            }
            
            $products= $products->where('status',1)
            ->get();
        foreach($products as $product){
            $product->category = DB::table('category')->where('id',$product->category_id)->first()->name;
            $product->supplierName =  DB::table('brands')->where('id',$product->supplier)->first()->name;
        }
        return response()->json([
            'products' => $products
        ]);
    });
    Route::get('/api/nhanvien', function (Request $request)
    {
        $keyword  = $request->id;
        $products = DB::table('users')
            // ->where('role', '=', '0')
            ->where(function ($query) use ($keyword)
            {
                $query->orWhere('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            })
            ->get();
        return response()->json([
            'products' => $products
        ]);
    });
    Route::get('/nhanvien', function ()
    {

        return view('quanlynhanvien');
    })->name('nhanvien');

    Route::get('/donhang', function ()
    {
        $bill = DB::table('bill')->get();
        foreach ($bill as $item)
        {
            $item->customer_name = DB::table('customers')->where('id', '=', $item->customer_id)->first()->name;
        }
        return view('donhang', [
            'bill' => $bill

        ]);
    })->name('donhang');

    Route::post('/change-avatar', function (Request $request) {
        $user = $request->user;
        $avatarFile = $request->file('avatar');
        $user = DB::table('users')->where('id',$user)->first();
        if ($avatarFile) {
            $extension = $avatarFile->getClientOriginalExtension();
            $avatarName = Str::random(40).'.'.$extension;

            // // Xóa avatar cũ (nếu có)
            // if ($user->avatar != null) {
            //     Storage::disk('public/assets/images')->delete($user->avatar);
            // }

            $avatarPath = $avatarFile->storeAs('public/assets/images', $avatarName); 

            $user = DB::table('users')->where('id',$user->id)->update(['avatar'=> $avatarName]);
            // $user->save();
            return redirect()->route('logout');


        }

        return redirect()->back();
    })->name('change-avatar');

    Route::get('/khachhang', function ()
    {

        return view('quanlykhachhang');
    })->name('khachhang');
    Route::get('/api/khachhang', function (Request $request)
    {
        $keyword  = $request->id;
        $products = DB::table('customers')
            ->where(function ($query) use ($keyword)
            {
                $query->orWhere('id', 'like', '%' . $keyword . '%')
                    ->orWhere('name', 'like', '%' . $keyword . '%');
            })
            ->get();
        return response()->json([
            'products' => $products
        ]);
    });
    Route::get('/banhang', [HomeController::class, 'banhang'])->name('banhang');
    Route::get('/bill_detail', [HomeController::class, 'bill_detail'])->name('bill_detail');

    Route::post('/add_products', [HomeController::class, 'add_products'])->name('add_products');
    Route::post('/add_employee', [HomeController::class, 'add_employee'])->name('add_employee');

    Route::post('/add_customer', [HomeController::class, 'add_customer'])->name('add_customer');
    Route::post('/add_bill', [HomeController::class, 'add_bill'])->name('add_bill');
    Route::get('/check_bill', [HomeController::class, 'check_bill'])->name('check_bill');

    Route::get('/delete_products/{id}', [HomeController::class, 'delete_products'])->name('delete_products');
    Route::get('/delete_users/{id}', [HomeController::class, 'delete_users'])->name('delete_users');
    Route::get('/update/{id}', [HomeController::class, 'update_products'])->name('update_products');
    Route::get('/update_users/{id}', [HomeController::class, 'update_users'])->name('update_users');
    Route::get('/update_customer/{id}', [HomeController::class, 'update_customer'])->name('update_customer');
    Route::get('/delete_customer/{id}', [HomeController::class, 'delete_customer'])->name('delete_customer');
    Route::get('/delete_bill/{id}', [HomeController::class, 'delete_bill'])->name('delete_bill');

    Route::get('/edit/{id}', [HomeController::class, 'edit_products'])->name('edit_products');
    Route::get('/edit_users/{id}', [HomeController::class, 'edit_users'])->name('edit_users');
    Route::get('/edit_customer/{id}', [HomeController::class, 'edit_customer'])->name('edit_customer');


});
