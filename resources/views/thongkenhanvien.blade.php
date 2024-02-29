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
            <form class="mt-2" action="{{route('thongkenhanvien')}}">
                    <div class="d-flex">
                        Từ ngày
                        <input  style="margin-left:8px" value="{{$dateStart}}" type="date" name="date_start">
                    
                    </div>
                    <div>
                        Đến ngày
                    <input style="margin-left:8px"  value="{{$dateEnd}}" type="date" name="date_end">

                    </div>
                    <button class="btn btn-primary"> Lọc</button>
            </form>
            <h1 class="display-4 my-4 text-info">Thống kê doanh thu nhân viên</h1>
            <div class="chart-container">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>

    <!--START INFO SECTION-->

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
<script>
    var StringDat = "{{($chartData)}}"
    var StringLabel = "{{$chartLabel}}"

    var arrdata = StringDat.split(",")
    var arrlabel = StringLabel.split(",")

    var data = {
        labels:arrlabel,
        datasets: [{
            label: "Tổng doanh thu bán được",
            backgroundColor: "rgba(136,213,126,0.2)",
            borderColor: "rgb(72,216,104)",
            borderWidth: 2,
            hoverBackgroundColor: "rgba(131,223,143,0.4)",
            hoverBorderColor: "rgb(108,213,91)",
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

    new Chart('myChart', {
        type: 'bar',
        options: options,
        data: data
    });

</script>
</body>

</html>
