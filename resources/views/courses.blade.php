@include('layout.header')

<div class="alert alert-danger d-none mt-2" id="errorMsg" role="alert">
  Something went wrong!
</div>

<div class="mt-5">
  <button id="addCourseBtn" type="button" class="btn btn-success" data-toggle="modal" data-target="#courseModal">Add Course</button>
</div>

<!-- Add/Update Modal -->
<div class="modal fade" id="courseModal" tabindex="-1" role="dialog" aria-labelledby="courseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="courseModalLabel">Manage Course</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
          <div class="form-group">
            <label for="course">Course</label>
            <input type="text" class="form-control" id="course" placeholder="Enter Course Name">
          </div>
          <div class="form-group">
            <label for="years">Years</label>
            <input type="number" class="form-control" id="years" placeholder="Enter Course Years">
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" placeholder="Enter Course Description"></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="closeCourseModal" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveCourse">Save</button>
      </div>
    </div>
  </div>
</div>


<table class="table">
  <thead>
    <tr>
      <th scope="col">Course</th>
      <th scope="col">Years</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody id="courseList"></tbody>
</table>

<script>
  $(function() {
    loadCourses();

    function loadCourses() {
      $('#courseList').html("");
      var request = $.ajax({
        url: "/api/courses",
        type: "GET",
      });

      request.done(function (response, textStatus, jqXHR) {
        var data = response.data;
        data.map(course => {
          $('#courseList').append(`
            <tr>
              <th scope="row">${course.course}</th>
              <td>${course.years}</td>
              <td>
                <button 
                  class="btn btn-sm btn-warning mr-2 edit" 
                  data-id="${course.id}"
                  data-course="${course.course}"
                  data-years="${course.years}"
                  data-description="${course.description}">
                  <i class="fa-solid fa-pencil"></i>
                </button>
                <button class="btn btn-sm btn-danger delete" data-id="${course.id}">
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </td>
            </tr>
          `);
        });

        initializeButtonEvents();
      });

      request.fail(function (jqXHR, textStatus, errorThrown){
        var errorMsg = jqXHR.responseJSON
        $('#errorMsg').html(errorMsg.error).removeClass('d-none');
      });
    }

    $('#addCourseBtn').on('click', function() {
      $('#saveCourse').removeAttr('data-id');
      cleanModal();
    });

    $('#saveCourse').on('click', function() {
      var course = $('#course').val();
      var years = $('#years').val();
      var description = $('#description').val();
      var id = $('#saveCourse').data('id');

      var request = $.ajax({
        url: id ? `/api/course/${id}` : "/api/course",
        type: id ? "PUT" : "POST",
        data: {
          course, years, description
        }
      });

      request.done(function (response, textStatus, jqXHR){
        var data = response.data;
        loadCourses();
        $('#closeCourseModal').click();
        cleanModal();
      });

      request.fail(function (jqXHR, textStatus, errorThrown){
        var errorMsg = jqXHR.responseJSON
        $('#errorMsg').html(errorMsg.error).removeClass('d-none');
        $('#closeCourseModal').click();
        cleanModal();
      });
    });

    function cleanModal() {
      $('#course').val("");
      $('#years').val("");
      $('#description').val("");
    }

    function initializeButtonEvents() {
      $('.edit').on('click', function() {
        var id = $(this).data('id');
        var course = $(this).data('course');
        var years = $(this).data('years');
        var description = $(this).data('description');

        $('#course').val(course);
        $('#years').val(years);
        $('#description').val(description);
        $('#saveCourse').attr('data-id', id);

        $('#courseModal').modal('show');
      });

      $('.delete').on('click', function() {
        var id = $(this).data('id');
        if (confirm("Are you sure you want to delete this course?") == true) {
          var request = $.ajax({
            url: `/api/course/${id}`,
            type: "DELETE",
          });

          request.done(function (response, textStatus, jqXHR){
            var data = response.data;
            loadCourses();
          });

          request.fail(function (jqXHR, textStatus, errorThrown){
            var errorMsg = jqXHR.responseJSON
            $('#errorMsg').html(errorMsg.error).removeClass('d-none');
          });
        }
      });
    }
  });
</script>

@include('layout.footer')