@extends('layout.app')

@section('content')

    {{-- Start Add Student Modal --}}
<div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <ul id="form_err"></ul>
        <div class="form-group mb-3">
            <label for="">Student Name</label>
            <input type="text" id="name" class="name form-control">
        </div>
        <div class="form-group mb-3">
            <label for="">Student Email</label>
            <input type="text" id="email" class="email form-control">
        </div>
        <div class="form-group mb-3">
            <label for="">Student Phone</label>
            <input type="text" id="phone" class="phone form-control">
        </div>
        <div class="form-group mb-3">
            <label for="">Student Course</label>
            <input type="text" id="course" class="course form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_student" name="add_student" id="add_student">Save</button>
      </div>
    </div>
  </div>
</div>
    {{-- End Add Student Modal --}}


    {{-- Start Edit Student Modal --}}
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Student Info</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <ul id="update_form_err"></ul>

          <input type="hidden" name="" id="edit-student-id">

        <div class="form-group mb-3">
            <label for="">Student Name</label>
            <input type="text" id="edit_name" class="name form-control">
        </div>
        <div class="form-group mb-3">
            <label for="">Student Email</label>
            <input type="text" id="edit_email" class="email form-control">
        </div>
        <div class="form-group mb-3">
            <label for="">Student Phone</label>
            <input type="text" id="edit_phone" class="phone form-control">
        </div>
        <div class="form-group mb-3">
            <label for="">Student Course</label>
            <input type="text" id="edit_course" class="course form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary update_student" name="update_student" id="update_student">Update</button>
      </div>
    </div>
  </div>
</div>
    {{-- End Edit Student Modal --}}


{{-- Start Delete Student Modal --}}
<div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Student Info</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="" id="delete-student-id">

        <h4>Are you sure? To delete this data?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger yes_delete_student" name="yes_delete_student" id="yes_delete_student">Delete</button>
      </div>
    </div>
  </div>
</div>
    {{-- End Delete Student Modal --}}


<div class="container py-5">
    <div class="row">
        <div class="col-md-12">

            {{-- success message --}}
            <div id="form-success"></div>

            <div class="card">
                <div class="card-header">
                    <h4>Student Data
                        <a href="" class="btn btn-primary float-end btn-sm" data-bs-toggle="modal" data-bs-target="#studentModal">Add Student</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Course</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- data will append from ajax --}}
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            // function to read/fetch students data from db
            fetchstudent();

            function fetchstudent(){
                $.ajax({
                    type: "GET",
                    url: "/fetch-student",
                    dataType: "json",
                    success: function(response) {
                        $('tbody').html("");
                        $.each(response.students, function (key, item) {
                            // append data to tbody of above table
                            $('tbody').append('<tr>\
                                    <td>'+item.id+'</td>\
                                    <td>'+item.name+'</td>\
                                    <td>'+item.email+'</td>\
                                    <td>'+item.phone+'</td>\
                                    <td>'+item.course+'</td>\
                                    <td>\
                                        <button type="button" value="'+item.id+'" class="edit_student btn btn-primary btn-sm">Edit</button>\
                                        <button type="button" value="'+item.id+'" class="delete_student btn btn-danger btn-sm">Delete</button>\
                                    </td>\
                                </tr>');
                        });
                    }

                });
            }
            // end data read/fetch function


            // modal for delete student info
            $(document).on('click', '.delete_student', function (e) {
                e.preventDefault();
                var student_id = $(this).val();
                $('#delete-student-id').val(student_id);
                $('#deleteStudentModal').modal('show');
            })

            // functionality of delete student info via ajax
            $(document).on('click', '.yes_delete_student', function (e) {
                e.preventDefault();
                var student_id = $('#delete-student-id').val();


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type:"DELETE",
                    url:"/delete-student/"+student_id,
                    success: function (response) {
                        if(response.status == 200){
                            $('#form-success').addClass('alert alert-success');
                            $('#form-success').text(response.message),
                            $('#deleteStudentModal').modal('hide');
                            fetchstudent();
                        }
                    }

                });
            })

            // edit student info modal
            $(document).on('click', '.edit_student', function(e) {
                e.preventDefault();
                var student_id = $(this).val();
                $('#editStudentModal').modal('show');

                $.ajax({
                    type: "GET",
                    url: "/edit-student/"+student_id,
                    success: function (response) {
                        if(response.status == 404){
                            $('#form-success').html("");
                            $('#form-success').addClass('alert alert-danger');
                            $('#form-success').text(response.message);
                        }
                        else{
                            $('#edit_name').val(response.student.name);
                            $('#edit_email').val(response.student.email);
                            $('#edit_phone').val(response.student.phone);
                            $('#edit_course').val(response.student.course);
                            $('#edit-student-id').val(response.student.id);
                        }
                    }

                });
            });

            // student info update functionality
            $(document).on('click', '#update_student', function (e) {
                e.preventDefault();
                var student_id = $('#edit-student-id').val();

                var student_data = {
                    'name':$('#edit_name').val(),
                    'email':$('#edit_email').val(),
                    'phone':$('#edit_phone').val(),
                    'course':$('#edit_course').val()
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "PUT",
                    url: "/update-student/"+student_id,
                    data: student_data,
                    dataType: "json",
                    success: function (response) {
                        if(response.status == 200){
                            $('#form-success').html("");
                            $('#form-success').addClass('alert alert-success');
                            $('#form-success').text(response.success),
                            $('#editStudentModal').modal('hide');
                            $('#editStudentModal').find('input').val("");
                            fetchstudent();
                        }
                        else if(response.status == 404){
                            $('#form-success').html("");
                            $('#form-success').addClass('alert alert-danger');
                            $('#form-success').text(response.message);
                        }
                        else if(response.status == 400){
                            $('#update_form_err').html("");
                            $('#update_form_err').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_list){
                                $('#update_form_err').append('<li>'+err_list+'</li>')
                            });
                        }
                    }
                });

            });


            // add new student data
            $(document).on('click', '.add_student', function(e){
                e.preventDefault();
                // take all input field in on variable
                var student_data = {
                    'name':$('#name').val(),
                    'email':$('#email').val(),
                    'phone':$('#phone').val(),
                    'course':$('#course').val()
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/student",
                    data: student_data,
                    dataType: "json",
                    success: function(response){
                        if(response.status == 400){
                            $('#form_err').html("");
                            $('#form_err').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_list){
                                $('#form_err').append('<li>'+err_list+'</li>')
                            });
                        }
                        else{
                            $('#form-success').html("");
                            $('#form-success').addClass('alert alert-success');
                            $('#form-success').text(response.success),
                            $('#studentModal').modal('hide');
                            $('#studentModal').find('input').val("");
                            fetchstudent();
                        }
                    }
                });
            });
        });
    </script>
@endsection
