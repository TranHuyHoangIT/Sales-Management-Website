<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Project</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <style>
      
        .js-upfile:hover{
            background: #722040 !important;
        }
    </style>
</head>

<body>
    <!--START THE NAVBAR SECTION-->
    <div class="row">
        @include('includes.drop_quanly')

        <!--START INFO SECTION-->
        <div class="col-md-9">
            <section class="vh-100" style="background-color: #f4f5f7;">
                <div class="container py-5 h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col col-lg-6 mb-4 mb-lg-0">
                            <div class="card mb-3" style="border-radius: .5rem;">
                                <div class="row g-0">
                                    <div class="col-md-4 gradient-custom text-center text-white"
                                        style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                        @if( Session::get('user')->avatar != null)
                                            <img src="{{ asset('storage/assets/images/'.Session::get('user')->avatar) }}"
                                            alt="Avatar" class="img-fluid my-5" style="width: 80px;" />
                                        @else
                                            <img src="{{ asset('assets/images/default.jpg') }}"
                                            alt="Avatar" class="img-fluid my-5" style="width: 80px;" />
                                        @endif
                                        <i class="far fa-edit mb-5"></i>
                                        <form action="{{ route('change-avatar') }}" class="d-flex flex-column" style="aligin-items:center; justify-content:center" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input class="" type="hidden" name="user" value="{{ Session::get('user')->id}}">
                                            <div class="box js-upfile d-flex" style="margin:0 16px;justify-content:center; align-center:center; background:#d3394c; padding: 8px; border-radius:16px; cursor:pointer !important;">
                                                <input type="file" class="d-none" name="avatar" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple="">
                                                <label style="color:white !important; cursor:pointer !important; font-weight:bold; fill:white;" for="file-1"><svg style=" cursor:pointer !important;color:white !important; font-weight:bold" xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg> <span>Choose a file…</span></label>
                                            </div>
                                        
                                          
                                            <button type="submit" style="margin:0 16px" class="btn btn-primary mt-3">Change Avatar</button>
                                        </form>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body p-4">
                                            <h6>Thông tin</h6>
                                            <hr class="mt-0 mb-4">
                                            <div class="row pt-1">
                                                <div class="col-6 mb-3">
                                                    <h6 class="text-muted">Tên</h6>
                                                    <p class="text-muted">{{ Session::get('user')->name }}</p>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <h6>Email</h6>
                                                    <p class="text-muted">{{ Session::get('user')->email }}</p>
                                                </div>
                                            </div>
                                            <div class="row pt-1">
                                                <div class="col-6 mb-3">
                                                    <h6>Giới tính</h6>
                                                    <p class="text-muted">{{ Session::get('user')->gender}}</p>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <h6>Số điện thoại</h6>
                                                    <p class="text-muted">{{ Session::get('user')->sdt}}</p>
                                                </div>
                                            </div>
                                            <div class="row pt-1">
                                                <div class="col-6 mb-3">
                                                    <h6>Địa chỉ</h6>
                                                    <p class="text-muted">{{ Session::get('user')->address}}</p>
                                                </div>
                                               
                                            </div>
                                            <h6>Chức vụ</h6>
                                            @if( Session::get('user')->role ==1 )
                                            <p>Admin</p>
                                            @else
                                            <p>Nhân viên</p>
                                            @endif
                                            <h6>Đổi mật khẩu</h6>
                                            <hr class="mt-0 mb-4">
                                            <!-- Email input -->
                                            <form id="form-change-pass">
                                            @csrf
                                            <div class="form-outline mb-4">
                                                <input type="password" name="pass" id="password" class="form-control" />
                                                <label class="form-label" for="password">Mật khẩu cũ</label>
                                            </div>

                                            <!-- Password input -->
                                            <div class="form-outline mb-4">
                                                <input type="password" name="newpass" id="newpassword" class="form-control" />
                                                <label class="form-label" for="newpassword">Mật khẩu mới</label>
                                            </div>

                                            <div class="form-outline mb-4">
                                                <input type="password"  id="renewpassword" class="form-control" />
                                                <label class="form-label" for="renewpassword">Nhập lại mật khẩu mới</label>
                                            </div>
                                            <button type="button" class= "js-submit-change-pass btn btn-primary btn-block mb-4">Xác
                                                nhận</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>
        $('.js-submit-change-pass').click(function(){
           
            let $newpass= $('#newpassword').val();
            let $renewpass =$('#renewpassword').val();
            if($newpass != $renewpass){
                alert("Mật khẩu mới nhập lại chưa khớp !");
            }else{
              let $data = $('#form-change-pass').serialize();
                $.ajax({
                url: "{{ route('change_pass') }}",
                type: "POST",
                data: $data,
                success: function (data) {
                    if (data.status == 1) {
                        alert('mật khẩu thay đổi thành công');
                        location.reload();
                    } else {
                        alert('mật khẩu cũ bạn nhập vào sai');
                    }
                }
            });
            }
        })
    </script>
</body>

</html>
