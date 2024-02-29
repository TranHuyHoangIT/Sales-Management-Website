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
            <h1 class="display-4 my-4 text-info">Danh sách khách hàng thân thiết</h1>
            <table class="table table-striped" id="users" style="width: 100%;">
                <thead >
                <tr id="list-header">
                    <th scope="col">TOP</th>
                    <th scope="col">Name</th>
                    <th scope="col">ID</th>
                    <th scope="col">Tổng số tiền sử dụng</th>
                </tr>
                </thead>
                <tbody>
                 @foreach($results as $key => $value)
                     <tr id="list-header">
                            <th scope="col">{{$key+1}}</th>
                            <th scope="col">{{$value->name}}</th>
                            <th scope="col">{{$value->customer_id}}</th>
                            <th scope="col">{{$value->total_cus_price}}</th>
                     </tr>
                 @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!--START INFO SECTION-->

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
<script>
</script>
</body>

</html>
