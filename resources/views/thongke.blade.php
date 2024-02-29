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


        canvas {
            border: 1px dotted red;
            width: 100%;
            max-height: 400px;
        }

        .chart-container {
            position: relative;
            margin: auto;
            width: 100%;
        }

    </style>
</head>

<body>
<!--START THE NAVBAR SECTION-->
<div class="row">
    @include('includes.drop_quanly')
    <div class="col-md-10">
        <div class="container-fluid">
            <h1 class="display-4 my-4 text-info">Thống kê</h1>
            <div class="chart-container">
                <canvas id="chart"></canvas>
            </div>
            <div class="d-flex row">
                <div class="col-3 border mt-3 p-3 ">
                    <p>Tổng số sản phẩm bán được:</p>
                    <span class="fw-bold" style="color:green">{{$totalProductBIll}}</span>
                </div>
                <div class="col-3 border mt-3 p-3 ">
                    <p>Tổng doanh thu:</p>
                    <span class="fw-bold" style="color:#fd7e14">{{$totalPrice}}</span>
                </div>
                <div class="col-3 border mt-3 p-3 ">
                    <p>Sản phẩm bán chạy nhất:</p>
                    <span class="fw-bold" style="color:#0d6efd">ID:{{$productBest->product_id}} <br> Sản phẩm: {{$productBest->name}}  <br> Số lượng bán: {{$productBest->total_quality}}</span>
                </div>
                <div class="col-3 border mt-3 p-3 ">
                    <p>Khách hàng mua nhiều nhất:</p>
                    <span class="fw-bold" style="color:#6f42c1">ID:{{$totalCustomerBest->customer_id}} <br> Tên: {{$totalCustomerBest->name}}  <br> Tổng giá trị mua: {{$totalCustomerBest->total_spent}}</span>
                </div>
            </div>
        </div>
    </div>


    <!--START INFO SECTION-->

</div>
<div id="myModal" class="modal">
    <div class="modal-content" style="text-align: center">
        <span class="close" onclick="closeModal()">&times;</span>
        <form id="form" action="{{ route('add_products') }}" method="post">
            @csrf
            <input type="text" id="name" name="name" placeholder="Tên" required><br><br>
            <input type="number" id="quantity" name="quantity" placeholder="Số lượng" required><br><br>
            <input type="number" id="price" name="price" placeholder="Giá" required><br><br>
            <button>Thêm</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
<script>
    var StringDat = "{{($dataChart)}}"
    var arrdata = StringDat.split(",")
    console.log(arrdata)
    var data = {
        labels: ["6 ngày trước", "5 ngày trước", "4 ngày trước", "3 ngày trước", "2 ngày trước", "1 ngày trước", "Hôm nay"],
        datasets: [{
            label: "Sản phẩm bán được trong ngày",
            backgroundColor: "rgba(255,99,132,0.2)",
            borderColor: "rgba(255,99,132,1)",
            borderWidth: 2,
            hoverBackgroundColor: "rgba(255,99,132,0.4)",
            hoverBorderColor: "rgba(255,99,132,1)",
            data: arrdata
        }]
    };

    var options = {
        maintainAspectRatio: false,
        scales: {
            y: {
                stacked: true,
                grid: {
                    display: true,
                    color: "rgba(255,99,132,0.2)"
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    };

    new Chart('chart', {
        type: 'bar',
        options: options,
        data: data
    });

</script>
</body>

</html>
