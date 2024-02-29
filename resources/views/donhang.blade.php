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
              <h1 class="display-4 my-4 text-info">Đơn hàng</h1>

              <button onclick="openModal()">Tạo đơn hàng</button>

              <input type="text" id="search" placeholder="Tìm kiếm">

              <table id="tableProduct" style="width: 100%;text-align: center">
                  <thead>
                      <tr>
                          <th>Mã đơn hàng</th>
                          <th>Tên Khách hàng</th>
                          <th>Tổng giá tiền</th>
                          @if(Session::get('user')->role == 1)
                          <th>Thao tác</th>
                            @endif
                      </tr>
                  </thead>
                  <tbody>
                        @foreach ($bill as $item)
                            <tr>
                                <td><a href="{{route('bill_detail',['id' =>$item->id])}}"> {{$item->id}} </a></td>
                                <td class="js-name">{{$item->customer_name}}</td>
                        
                                <td>{{$item->total_price}}</td>
                                @if(Session::get('user')->role == 1)
                                <td class="actions">
                                    <a href="{{ route('delete_bill', $item->id) }}"><i class="fas fa-trash-alt"></i></a>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                  </tbody>
              </table>
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
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script>
        $(document).on("keyup", '#search', function (e) {
            let search = $(e.target).val();
            if (search.length >= 0) {
                $('#tableProduct tbody tr').each((index, element) => {
                    let titleSearch = $(element).find('.js-name').html().toLowerCase();

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

      function openModal() {
          document.location.href = '{{route('banhang')}}';
      }

  </script>
</body>

</html>
