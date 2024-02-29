<div class="col-md-2">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark dashboard" style="width: auto; height: 100vh">
        <a href="/"
           class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <svg class="bi pe-none me-2" width="40" height="32">
                <use xlink:href="#bootstrap"></use>
            </svg>
            <span class="fs-4">Danh mục</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{route('index')}}" class="nav-link active" aria-current="page">
                    <svg class="bi pe-none me-2" width="20" height="20">
                        <use xlink:href="#home"></use>
                    </svg>
                    Trang cá nhân
                </a>
            </li>
            <li>
                <div class="dropdown">
                    <a href="{{route('banhang')}}" class="nav-link text-white " ><svg
                            class="bi pe-none me-2" width="20" height="20">
                            <use xlink:href="#speedometer2"></use>
                        </svg>
                        Bán hàng</a>

                </div>
            </li>
            <li>
                <div class="dropdown">
                    <a href="#" class="nav-link text-white dropdown-toggle" data-bs-toggle="dropdown"><svg
                            class="bi pe-none me-2" width="20" height="20">
                            <use xlink:href="#speedometer2"></use>
                        </svg>
                        Quản lý</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{route('khachhang')}}">Khách hàng</a></li>
                        @if(Session::get('user')->role == 1)
                            <li><a class="dropdown-item" href="{{route('nhanvien')}}">Nhân viên</a></li>
                            <li><a class="dropdown-item" href="{{route('sanpham')}}">Sản phẩm</a></li>
                        @endif
                            <li><a class="dropdown-item" href="{{route('donhang')}}">Đơn Hàng</a></li>
                    </ul>
                </div>
            </li>
            @if(Session::get('user')->role == 1)
            <li>

                <div class="dropdown">
                    <a href="#" class="nav-link text-white dropdown-toggle" data-bs-toggle="dropdown"><svg
                            class="bi pe-none me-2" width="20" height="20">
                            <use xlink:href="#speedometer2"></use>
                        </svg>
                        Thống kê</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{route('thongke')}}">Thống kê tổng quát</a></li>
                        <li><a class="dropdown-item" href="{{route('thongkeloinhuan')}}">Thống kê theo lợi nhuận</a></li>
                        <li><a class="dropdown-item" href="{{route('thongkenhanvien')}}">Thống kê theo nhân viên </a></li>
                        <li><a class="dropdown-item" href="{{route('thongkekhachhang')}}">Thống kê theo khách hàng </a></li>
                        <li><a class="dropdown-item" href="{{route('thongkesanpham')}}">Thống kê theo sản phẩm </a></li>


                    </ul>
                </div>
            </li>
            @endif
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
               data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('storage/assets/images/'.Session::get('user')->avatar) }}" alt="" width="32" height="32"
                     class="rounded-circle me-2">
                <h5>{{Session::get('user')->name}}</h5>

            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="./">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="{{ route('logout') }}">Sign out</a></li>
            </ul>
        </div>
    </div>
</div>
