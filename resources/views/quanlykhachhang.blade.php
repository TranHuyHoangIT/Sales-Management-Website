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
            width: 80%;
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
    </style>
</head>

<body>
<!--START THE NAVBAR SECTION-->
<div class="row">
    @include('includes.drop_quanly')
    <div class="col-md-10">
        <div class="container-fluid">
            <h1 class="display-4 my-4 text-info">Danh sách khách hàng</h1>

            <button onclick="openModal()">Thêm</button>

            <input type="text" id="search" placeholder="Tìm kiếm">

            <table id="mytable" style=" width: 100%;text-align: center">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Ten khach hang</th>
                    <th>SDT/EMAIL</th>
                    <th>DIA CHI</th>
                    <th>Note</th>
                    <th>Thao tac</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>


    <!--START INFO SECTION-->

</div>
<div id="myModal" class="modal">
    <div class="modal-content" style="text-align: center">
        <span class="close" onclick="closeModal()">&times;</span>
        <form id="form" action="{{ route('add_customer') }}" method="post">
            @csrf
            <input type="text" id="name" name="name" placeholder="Ten khach hang" required><br><br>
            <input type="email" id="email" name="email" placeholder="Email" ><br><br>
            <input type="text" id="phone" name="phone" placeholder="SDT" ><br><br>
            <input type="text" id="address" name="address" placeholder="Dia chi" ><br><br>
            <input type="text" id="note" name="note" placeholder="Note" ><br><br>
            <button>Thêm</button>
        </form>
    </div>
</div>
<script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
<script>
    $(document).ready(function() {

        $('#search').on('keyup', function() {
            var value = $(this).val();
            var route = `${window.location.origin}/api/khachhang`;

            $.ajax({
                url: route,
                type: 'get',
                data: {
                    id: value,
                }
            }).done(function(ketqua) {
                $("#mytable tbody").empty();

                // Lặp qua dữ liệu từ API và tạo hàng mới cho mỗi mục
                for (var i = 0; i < ketqua.products.length; i++) {
                    var product = ketqua.products[i];

                    var row = $("<tr></tr>");

                    $("<td></td>").text(product.id).appendTo(row);
                    $("<td></td>").text(product.name).appendTo(row);
                    $("<td></td>").text(product.email + ' - ' + product.phone).appendTo(row);
                    $("<td></td>").text(product.address).appendTo(row);
                    $("<td></td>").text(product.note).appendTo(row);
                    var actionsColumn = $("<td class='actions'></td>");

                    var route_delete = `${window.location.origin}/delete_customer/` +  product.id;
                    var route_update = `${window.location.origin}/update_customer` + product.id;

                    var deleteLink = $("<a></a>").attr("href", route_delete)
                        .addClass("btn btn-danger")
                        .text("Xóa");

                    actionsColumn.append(deleteLink);

                    var editButton = $("<button></button>").addClass("btn btn-dark edit")
                        .val(product.id)
                        .text("Sửa")
                        .click(function() {
                            var value = $(this).val();
                            var route = `${window.location.origin}/update_customer/` + value;

                            $.ajax({
                                url: route,
                                type: 'get',
                                data: {
                                    id: value,
                                }
                            }).done(function(ketqua) {
                                $('#form').attr('method', 'get');
                                $('#form').attr('action', '/edit_customer/' + ketqua
                                    .products[0].id);
                                $("#email").val(ketqua.products[0].email);
                                $("#name").val(ketqua.products[0].name);
                                $("#phone").val(ketqua.products[0].phone);
                                $("#address").val(ketqua.products[0].address);
                                $("#note").val(ketqua.products[0].note);

                            });
                            openModal();
                        });
                    actionsColumn.append(editButton);
                    row.append(actionsColumn);
                    $("#mytable tbody").append(row);
                }
            });
            // console.log(value);

        });
        var route = `${window.location.origin}/api/khachhang`;

        $.ajax({
            url: route,

        }).done(function(ketqua) {
            $("#mytable tbody").empty();

            for (var i = 0; i < ketqua.products.length; i++) {
                var product = ketqua.products[i];

                var row = $("<tr></tr>");
                $("<td></td>").text(product.id).appendTo(row);
                $("<td></td>").text(product.name).appendTo(row);
                $("<td></td>").text(product.email + ' - ' + product.phone).appendTo(row);
                $("<td></td>").text(product.address).appendTo(row);
                $("<td></td>").text(product.note).appendTo(row);
                var actionsColumn = $("<td class='actions'></td>");

                var route_delete = `${window.location.origin}/delete_customer/` + product.id;
                var route_update = `${window.location.origin}/update_customer` + product.id;

                var deleteLink = $("<a></a>").attr("href", route_delete)
                    .addClass("btn btn-danger")
                    .text("Xóa");

                actionsColumn.append(deleteLink);

                var editButton = $("<button></button>").addClass("btn btn-dark edit")
                    .val(product.id)
                    .text("Sửa")
                    .click(function() {
                        var value = $(this).val();
                        var route = `${window.location.origin}/update_customer/` + value;

                        $.ajax({
                            url: route,
                            type: 'get',
                            data: {
                                id: value,
                            }
                        }).done(function(ketqua) {
                            $('#form').attr('method', 'get');
                            $('#form').attr('action', '/edit_customer/' + ketqua
                                .products[0].id);
                            $("#email").val(ketqua.products[0].email);
                            $("#name").val(ketqua.products[0].name);
                            $("#phone").val(ketqua.products[0].phone);
                            $("#address").val(ketqua.products[0].address);
                            $("#note").val(ketqua.products[0].note);
                        });
                        openModal();
                    });

                actionsColumn.append(editButton);

                row.append(actionsColumn);

                // Thêm hàng mới vào tbody
                $("#mytable tbody").append(row);
            }
        });

    });

    var modal = document.getElementById("myModal");
    var btn = document.getElementsByTagName("button")[0];
    var span = document.getElementsByClassName("close")[0];

    function openModal() {
        modal.style.display = "block";
    }

    function closeModal() {
        $('#form').attr('method', 'post');
        $('#form').attr('action', 'add_employee');
        $("#name").val('');
        $("#quantity").val('');
        $("#price").val('');
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
