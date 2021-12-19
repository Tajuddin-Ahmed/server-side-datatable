<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.css" />
    <title>php crud with ajax</title>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="text-center text-danger">Server Side Data Table</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <h4 class="mt-2 text-primary">All users in Database</h4>
            </div>
            <div class="col-lg-6">
                <button id="#userModal" data-bs-target="#userModal" data-bs-toggle="modal" class="btn  btn-primary m-1 float-end"> <i class="fas fa-user-plus fa-lg"></i>&nbsp;&nbsp; Add New User</button>
                <a href="action.php?export=excel" class="btn btn-success m-1 float-end"> <i class="fas fa-table fa-lg"></i>&nbsp;&nbsp; Export to Excel</a>
            </div>
        </div>
        <hr class="my-1">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive" id="showUser">
                    <h3 class="text-center text-success" style="margin-top:150px;">Loading ...</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Add New User Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <form action="" method="post" id="form-data">
                        <div class="form-group">
                            <input type="text" class="form-control" name="fname" placeholder="First Name" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="text" class="form-control" name="lname" placeholder="Last Name" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="tel" class="form-control" name="phone" placeholder="Phone" required>
                        </div>
                        <br>
                        <div class="form-group d-grid gap-2">
                            <input type="submit" name="insert" class="btn btn-danger" id="insert" value="Add User" placeholder="Phone" required>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- edit User Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <form action="" method="post" id="editform-data">
                        <div class="form-group">
                            <input type="hidden" name="id" id="id">
                            <input type="text" class="form-control" name="fname" id="fname" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="text" class="form-control" name="lname" id="lname" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="tel" class="form-control" name="phone" id="phone" required>
                        </div>
                        <br>
                        <div class="form-group d-grid gap-2">
                            <input type="submit" name="edit" class="btn btn-primary" id="edit" value="Edit User" placeholder="Phone" required>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.js"></script>
    <script src="https://kit.fontawesome.com/a22e82248a.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {

            showAllUser();

            function showAllUser() {
                $.ajax({
                    url: 'action.php',
                    type: "POST",
                    data: {
                        action: "view"
                    },
                    success: function(res) {
                        // console.log(res);
                        $('#showUser').html(res);
                        $("table").DataTable({
                            order: [0, "desc"],
                        });
                    }
                });
            }
            // insert data 
            $('#insert').click(function(e) {
                if ($('#form-data')[0].checkValidity()) {
                    e.preventDefault();
                    $.ajax({
                        url: 'action.php',
                        type: "POST",
                        data: $("#form-data").serialize() + "&action=insert",
                        success: function(res) {
                            Swal.fire({
                                title: "User Added Successfully",
                                icon: 'success',
                            });
                            $('#userModal').modal('hide');
                            $("#form-data")[0].reset();
                            showAllUser();
                        }
                    });
                }
            });
            // edit User 
            $('body').on("click", ".editBtn", function(e) {
                e.preventDefault();
                edit_id = $(this).attr('id');
                $.ajax({
                    url: "action.php",
                    type: "POST",
                    data: {
                        edit_id: edit_id
                    },
                    success: function(res) {
                        data = JSON.parse(res);
                        $('#id').val(data.id);
                        $('#fname').val(data.first_name);
                        $('#lname').val(data.last_name);
                        $('#email').val(data.email);
                        $('#phone').val(data.phone);
                    }
                });
            });
            // update data 
            $('#edit').click(function(e) {
                if ($('#editform-data')[0].checkValidity()) {
                    e.preventDefault();
                    $.ajax({
                        url: 'action.php',
                        type: "POST",
                        data: $("#editform-data").serialize() + "&action=edit",
                        success: function(res) {
                            Swal.fire({
                                title: "User Updated Successfully",
                                icon: 'success',
                            });
                            $('#editModal').modal('hide');
                            $("#editform-data")[0].reset();
                            showAllUser();
                        }
                    });
                }
            });
            // delete ajax request 
            $("body").on("click", ".delBtn", function(e) {
                e.preventDefault();
                let tr = $(this).closest('tr');
                del_id = $(this).attr('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "action.php",
                            type: "POST",
                            data: {
                                del_id: del_id
                            },
                            success: function(res) {
                                tr.css('background-color', '#ff6666');
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                                showAllUser();
                            }
                        });
                    }
                })
            });
            // show user details 
            $('body').on("click", ".infoBtn", function(e) {
                e.preventDefault();
                info_id = $(this).attr('id');
                $.ajax({
                    url: "action.php",
                    type: "POST",
                    data: {
                        info_id: info_id
                    },
                    success: function(res) {
                        data = JSON.parse(res);
                        Swal.fire({
                            title: '<strong>User info: ID(' + data.id + ')</strong>',
                            icon: "info",
                            html: '<b>First Name: </b>' + data.first_name + '<br><b>Last Name : </b>' + data.last_name + '<br><b>Email: </b>' + data.email + '<br><b>Phone: </b>' + data.phone,
                            showCancelButton: true,
                        })
                    }
                });
            });
        });
    </script>
</body>

</html>