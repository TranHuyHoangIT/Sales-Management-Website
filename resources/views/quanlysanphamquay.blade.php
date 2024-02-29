<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Project</title>
    <link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script
    src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js">
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
  </script>
  <!-- DataTables -->
  <link rel="stylesheet"
    type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <script type="text/javascript"
    charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js">
  </script>
  <!-- My CSS and JQuery -->
  <link href="./assets/css/style.css" rel="stylesheet">
  <script type="text/javascript" src="./jquery/index.js"></script>
</head>
<body>
    <!--START THE NAVBAR SECTION-->
      <div class="row">
          @include('includes.drop_quanly')
        <div class="col-md-7">
          <div class="container d-flex flex-column justify-content-center">
            <div class="container d-flex flex-row justify-content-md-around">
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-2">
                      <p>ID</p>
                  </div>
                  <div class="col-md-10">
                      <div class="form-outline">
                        <input type="text" id="form3Example1" class="form-control" />
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                      <p>Tên</p>
                  </div>
                  <div class="col-md-10">
                      <div class="form-outline">
                          <input type="text" id="form3Example1" class="form-control" />
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                      <p>Loại hàng</p>
                  </div>
                  <div class="col-md-10">
                      <div class="form-outline">
                        <input type="text" name="txtDatetimeLocal" id="txtDatetimeLocal" />
                      </div>
                  </div>
                </div>
              </div>
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-3">
                    <p>Hãng</p>
                </div>
                <div class="col-md-9">
                  <div class="form-outline">
                    <input type="text" id="form3Example1" class="form-control" />
                  </div>
                </div>
              </div>
                <div class="row">
                  <div class="col-md-3">
                      <p>Xuất xứ</p>
                  </div>
                  <div class="col-md-9">
                    <div class="form-outline">
                      <input type="text" id="form3Example1" class="form-control" />
                    </div>
                  </div>
                </div>
                  <div class="row">
                    <div class="col-md-3">
                        <p>Giá nhập</p>
                    </div>
                    <div class="col-md-9">
                      <div class="form-outline">
                        <input type="text" id="form3Example1" class="form-control" />
                      </div>
                    </div>
                  </div>
              </div>
              <div class="col-md-4">
                <button type="button" class="btn btn-primary d-block" id="btnAdd">Thêm</button>
                <button type="button" class="btn btn-primary d-block" id="btnFix">Sửa</button>
                <button type="button" class="btn btn-primary d-block" id="btnAdd">Xóa</button>
                <button type="button" class="btn btn-primary d-block" id="btnAdd">Làm mới</button>
              </div>
          </div>
            <div class="container-fluid">
              <h1 class="display-4 my-4 text-info">List of users</h1>
              <table class="table table-striped" id="users" style="width: 100%;">
                <thead >
                  <tr id="list-header">
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Address</th>
                    <th scope="col">Phone</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
              <button type="button" class="btn btn-primary" id="btnReloadData">Reload data</button>
              <button type="button" class="btn btn-primary" id="btnConfirmCustomer">Xác nhận</button>
            </div>
        </div>
      </div>
    </div>
  <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
</body>
</html>
