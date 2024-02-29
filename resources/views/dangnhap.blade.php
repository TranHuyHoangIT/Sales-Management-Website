<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .actions {
            display: flex;
            justify-content: space-around;
        }

        /* CSS cho modal */
        .modal {
            display: none;
            /* Ẩn modal mặc định */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        @keyframes blink {
            0% { background-color: blue; }
            50% { background-color: white; }
            100% { background-color: blue; }
        }

        .blinking-button {
            animation: blink 1s infinite;
        }
    </style>
</head>

<body>
    <section class="text-center text-lg-start">
        <style>
            /* CSS styles here */
        </style>
        <div class="card mb-3">
            <div class="row g-0 d-flex align-items-center">
                <div class="col-lg-4 d-none d-lg-flex">
                    <img src="https://mdbootstrap.com/img/new/ecommerce/vertical/004.jpg" alt="Trendy Pants and Shoes"
                        class="w-100 rounded-t-5 rounded-tr-lg-0 rounded-bl-lg-5" />
                </div>
                <div class="col-lg-8">
                    <div class="card-body py-5 px-md-5">
                        @if (session('errors'))
                            <div class="alert alert-danger">
                                Tài khoản hoặc mật khẩu không chính xác
                            </div>
                        @endif
                        @if (session('sucsses'))
                            <div class="alert alert-succses">
                                Mật khẩu mới đã được gửi về mail
                            </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            <!-- Email input -->
                            @csrf
                            <div class="form-outline mb-4">
                                <input type="email" name="email" id="form2Example1" class="form-control" required />
                                <label class="form-label" for="form2Example1">Địa chỉ email</label>
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input type="password" name="password" id="form2Example2" class="form-control"
                                    required />
                                <label class="form-label" for="form2Example2">Mật khẩu</label>
                            </div>

                            <!-- 2 column grid layout for inline styling -->
                            <div class="row mb-4">
                                <div class="col d-flex justify-content-center">
                                    <!-- Checkbox -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="form2Example31" checked />
                                        <label class="form-check-label" for="form2Example31"> Nhớ mật khẩu </label>
                                    </div>
                                </div>

                                <div class="col">
                                    <!-- Simple link -->
                                    <a class="js-missing-pass" onclick="openModal()">Quên mật khẩu?</a>
                                </div>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block mb-4 blinking-button" id="login">Đăng
                                nhập</button>
                           
                        </form>
                        <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
                <div id="myModal" class="modal">
                <div class="modal-content modal-sm" style="justify-content: center; align-items:center">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <form id="form" action="{{ route('miss_pass') }}" method="get">
                        <span>Sau khi nhập tài khoản và ấn xác nhận thì mật khẩu sẽ được gửi về gmail của bạn</span>
                        @csrf
                        <div>
                            Tài khoản: <span class="js-name-customer"></span>
                        </div>
                        <input type="email" name="email" id="email">
                    
                        <div class="d-flex mt-3 justify-center">
                            <button class="js-confirm">Xác nhận</button>
        
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script>
        var modal = document.getElementById("myModal");

        function openModal() {
            modal.style.display = "block";
        }

        function closeModal() {
            $('#form').attr('method', 'post');
            $('#form').attr('action', 'add_products');
            modal.style.display = "none";
        }
    </script>
</body>

</html>
