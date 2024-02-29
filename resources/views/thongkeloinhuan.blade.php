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
            <h1 class="display-4 my-4 text-info">Thống kê lợi nhuận</h1>
        <div>
            <form id="form-select-time" action="{{route('thongkeloinhuan')}}" method="get">
                <select name="time" onchange="myFunction()">
                    <option class="js-select-time" value="3" @if($timeSelect == 3) selected @endif>3 ngày gần nhất</option>
                    <option class="js-select-time" value="7" @if($timeSelect == 7) selected @endif>7 ngày gần nhất</option>
                    <option class="js-select-time" value="15" @if($timeSelect == 15) selected @endif>15 ngày gần nhất</option>
                    <option class="js-select-time" value="30" @if($timeSelect == 30) selected @endif>30 ngày gần nhất</option>
                    <option class="js-select-time" value="year" @if($timeSelect == "year") selected @endif>Trong năm nay</option>

                </select>
            </form>
        </div>
            <div class="chart-container">
                <canvas id="myChart"></canvas>
            </div>
        </div>
        <div class="d-flex row">

            <div class="col-3 border mt-3 p-3 ">
                <p>Tổng doanh thu:</p>
                <span class="fw-bold" style="color:#fd7e14">{{$totalPrice}}</span>
            </div>
            <div class="col-3 border mt-3 p-3 ">
                <p>Tổng lợi nhuận:</p>
                <span class="fw-bold" style="color:green">{{$totalCost}}</span>
            </div>

        </div>
    </div>

    <!--START INFO SECTION-->

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
<script>
    var StringDat = "{{($dataChart)}}"
    var StringDat2 = "{{($dataChart2)}}"
    var StringLabel = "{{($labelChart)}}"
    var arrdata = StringDat.split(",")
    var arrdata2 = StringDat2.split(",")
    var arrlabel = StringLabel.split(",")
    var ctx = document.getElementById("myChart").getContext('2d');


    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: arrlabel,
            datasets: [
                {
                label: 'Doanh số ', // Name the series
                data: arrdata, // Specify the data values array
                fill: false,
                borderColor: '#2196f3', // Add custom color border (Line)
                backgroundColor: '#2196f3', // Add custom color background (Points and Fill)
                borderWidth: 1 // Specify bar border width
            },
                {
                    type: 'bar',
                    label: 'Lợi nhuận ', // Name the series
                    data: arrdata2, // Specify the data values array
                    fill: false,
                    borderColor: '#1bc508', // Add custom color border (Line)
                    backgroundColor: '#1bc508', // Add custom color background (Points and Fill)
                    borderWidth: 1 // Specify bar border width
                }
            ]},
        options: {
            responsive: true, // Instruct chart js to respond nicely.
            maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height
        }
    });

    function myFunction(){
        $('#form-select-time').submit();
    }
</script>
</body>

</html>
