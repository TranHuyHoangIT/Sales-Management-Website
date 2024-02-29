<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Project</title>
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
        .col-md-5{
            border:1px solid #c9c9c9;
            border-radius:8px;
        }
    </style>
</head>

<body>
<!--START THE NAVBAR SECTION-->
<div class="row">
    @include('includes.drop_quanly')
    <div class="col-md-5">
        <div class="container-fluid">
            <h1 class="display-4 my-4 text-info" style="height: 100px;">Sản phẩm</h1>
            
            <div class="d-flex mt-5">
                <select class="js-option-product">
                    <option value="id">Theo mã ID</option>
                    <option value="name">Theo tên Sản phẩm</option>
                    <option value="sup">Theo nhà cung cấp</option>
                </select>
                <input type="text" id="search-product" placeholder="Tìm kiếm">
                <div style="margin-left:auto">
                    Số sản phẩm đã chọn: <span class="js-number-product fw-bold">0</span>
                </div>
            </div>
           

            <table id="tableProduct" style="width: 100%;text-align: center">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Nhà Cung cấp </th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thao tác</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $cus)
                    <tr>
                        <td class="js-id">
                            {{$cus->id}}
                        </td>
                        <td class="js-name">
                            {{$cus->name}}
                        </td>
                        <td class="js-sup">
                            {{$cus->supplier}}
                        </td>
                        <td class="js-quality">
                            {{$cus->quantity}}
                        </td>
                        <td class="js-price">
                            {{$cus->price}}
                        </td>
                        <td>
                            <input type="checkbox" value="{{$cus->id}}" name="product[]">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-5">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-center">
                <h1 class="display-4 my-4 text-info">Khách hàng</h1>
                <div class="d-flex flex-column justify-content-between p-2">

                    <button class="btn btn-warning js-reset" style="height: 40px">Đặt lại</button>
                <button class="btn btn-success js-thanhtoan" style="height: 40px">Thanh toán</button>

                </div>
            </div>


            <div class="d-flex mt-5">
            <select class="js-option-customer">
                    <option value="id">Theo mã ID</option>
                    <option value="name">Theo tên khách hàng</option>
                </select>
                <input type="text" id="search-customer" placeholder="Tìm kiếm">
                <div style="margin-left:auto">
                    Số khách hàng đã chọn: <span class="js-number-customer fw-bold">0</span>
                </div>
            </div>

            <table id="tableCustomer" style="width: 100%;text-align: center">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>EMAIL/SDT</th>
                    <th>Địa chỉ</th>
                    <th>Note</th>
                    <th>Thao tác</th>
                </tr>
                </thead>
                <tbody>
                @foreach($customers as $cus)
                    <tr>
                        <td class="js-id">
                            {{$cus->id}}
                        </td>
                        <td class="js-name">
                            {{$cus->name}}
                        </td>
                        <td>
                            {{$cus->email}} / {{$cus->phone}}
                        </td>
                        <td>
                            {{$cus->address}}
                        </td>
                        <td>
                            {{$cus->note}}
                        </td>
                        <td>
                            <input type="radio" value="{{$cus->id}}" name="customer">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


        <!--START INFO SECTION-->

    <!-- </div> -->
    <div id="myModal" class="modal">
        <div class="modal-content modal-sm" style="justify-content: center; align-items:center">
            <span class="close" onclick="closeModal()">&times;</span>
            <form id="form" action="{{ route('add_bill') }}" method="post">
                @csrf
                <div>
                    <input type="hidden" name="customer_id" id="customer_id">
                    Khách hàng: <span class="js-name-customer"></span>
                </div>
                <p class="mt-3 mb-0 fw-bold">Danh sách Sản phẩm: </p>
                <div class="js-product-list"></div>
                <div class="d-flex">
                    Tổng cộng: <div class="js-total-bill fw-bold"></div>
                </div>
                <label for="price_cus_give">
                    Tiền khách đưa:
                    <input name="price_cus_give" id="price_cus_give" value="">
                </label>
                <div class="d-flex mt-3">
                    <button type="button" class="js-confirm">Xác nhận</button>

                </div>
            </form>
        </div>
    </div>


    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script>
        var modal = document.getElementById("myModal");
        $(document).on("keyup", '#search-customer', function (e) {
            let search = $(e.target).val();
            let $select = $('.js-option-customer').val();
            let $class = '.js-' + $select;
            if (search.length >= 0) {
                $('#tableCustomer tbody tr').each((index, element) => {
                    let titleSearch = $(element).find($class).html().toLowerCase();

                    if (titleSearch.indexOf(search.toLowerCase()) !== -1) {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
            } else {
                $('.item-task').removeClass('d-none');
            }
        });
        $(document).on('click','.js-confirm',function (e) {
            e.preventDefault();
            let $customerGive = parseInt($('#price_cus_give').val());
            let $totalBill = parseInt($('.js-total-bill').html());
            let $list =  $(document).find('.js-quality-product');
            let $status = 0;
            $list.each((index,element) => {
                let $this = $(element);
                let $item = $(element).parent().find(".js_quality").val();
                if(parseInt($this.val()) > parseInt($item )){
                    alert('Số lượng sản phẩm '+ $(element).parent().find(".js-p-name").html().trim() + " vượt quá số lượng trong kho" );
                    
                    $status = 1;
                }
            });
            if($status == 0 ){
                if($customerGive < $totalBill){
                alert('Tiền khách đưa không đủ');
                return false;
            }else if($customerGive > $totalBill){
                alert('Trả lại tiền thừa: ' + ($customerGive - $totalBill));
            }

            let $data = $('#form').serializeArray();

            $.ajax({
                url: "{{ route('add_bill') }}",
                type: "POST",
                data: $data,
                success: function (data) {
                    if (data.status == 1) {
                        alert(data.message);
                        location.reload();
                    } else {
                        // alert(data.message);
                    }
                }
            });
            }
        
        })
        $(document).on("keyup", '#search-product', function (e) {
            let search = $(e.target).val();
            let $select = $('.js-option-product').val();
            let $class = '.js-' + $select;
            if (search.length >= 0) {
                $('#tableProduct tbody tr').each((index, element) => {
                    let titleSearch = $(element).find($class).html().toLowerCase();

                    if (titleSearch.indexOf(search.toLowerCase()) !== -1) {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
            } else {
                $('.item-task').removeClass('d-none');
            }
        });

        $('input[type="checkbox"]').change(function () {
            let number = $('input[type="checkbox"]:checked').length;
            $('.js-number-product').html(number);
        })
        $('input[type="radio"]').change(function () {
            let number = $('input[type="radio"]:checked').length;
            $('.js-number-customer').html(number);
        })

        $('.js-thanhtoan').click(function () {
           if($('input[type="checkbox"]:checked').length ==0 || $('input[type="radio"]:checked').length ==0) {
               alert('Bạn chọn thiếu mục, vui lòng chọn đủ cả sản phẩm và khách hàng')
           }else if ($('input[type="checkbox"]:checked').length > 0 && $('input[type="radio"]:checked').length ==1) {
                $('.js-total-bill').html('');
                $('.js-product-list').html('');
                $('#customer_id').val('');
                $('.js-name-customer').html('');
                $('#price_cus_give').val('');


               let $dataProduct = $('input[type="checkbox"]:checked');
                let $dataCustomer = $('input[type="radio"]:checked');
                let $total = 0;
                $dataProduct.each(function (index, element) {
                    $total += parseInt($(element).parent().parent().find('.js-price').html());

                    if(index == 0) {
                        $html = `
                        <div class="d-flex  align-center border ">
                            <div class="d-flex flex-column ">
                                <span class="fw-bold">Sản phẩm:</span>
                                <span class="fw-bold">Giá:</span>
                                <span>Số lượng:</span>
                            </div>
                            <div class="d-flex flex-column" style="margin-left:40px">
                                <input type="hidden" class="js_quality" value="${$(element).parent().parent().find('.js-quality').html()}">
                        
                                <span class="fw-bold js-p-name">${$(element).parent().parent().find('.js-name').html()}</span>
                                <span class="js-product-price-form fw-bold">${$(element).parent().parent().find('.js-price').html()}</span>
                                <input type="number" class="js-quality-product" name="quality-product-${$(element).val()}" style="width:40px;height:32px" value="1">
                            </div>
                        </div>
                    `;
                    }else{
                        $html = `
                        <div class="d-flex  align-center mt-3 border ">
                            <div class="d-flex flex-column ">
                                <span class="fw-bold">Sản phẩm</span>
                                <span class="fw-bold">Giá</span>
                                <span>Số lượng</span>
                            </div>
                            <div class="d-flex flex-column" style="margin-left:40px">
                                 <input type="hidden" class="js_quality" value="${$(element).parent().parent().find('.js-quality').html()}">

                                <span class="fw-bold">${$(element).parent().parent().find('.js-name').html()}</span>
                                <span class="js-product-price-form fw-bold js-p-name">${$(element).parent().parent().find('.js-price').html()}</span>
                                <input type="number" class="js-quality-product" name="quality-product-${$(element).val()}" style="width:40px;height:32px" value="1">
                            </div>
                        </div>
                    `;
                    }
                    $('.js-total-bill').html($total);
                    $('.js-product-list').append($html);
                })
                $dataCustomer.each(function (index, element) {
                    $('#customer_id').val($(element).val());
                    $('.js-name-customer').html($(element).parent().parent().find('.js-name').html());
                })

               openModal();
           }
        })
        $(document).bind('keyup mouseup',"js-quality-product",function(event){
            let $total = 0;
            $('.js-quality-product').each(function (index, element) {
                $total += parseInt($(element).parent().find('.js-product-price-form').html()) * parseInt($(element).val());
            })
            $('.js-total-bill').html($total);
        })
        $('.js-reset').click(function(){
            $('input[type="checkbox"]').prop('checked', false);
            $('input[type="radio"]').prop('checked', false);
            $('.js-number-customer').html(0);
            $('.js-number-product').html(0);
        })
        function openModal() {
            modal.style.display = "block";
        }
        function closeModal() {
            $('#form').attr('method', 'post');
            $('#form').attr('action', 'add_products');
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>

</body>

</html>
