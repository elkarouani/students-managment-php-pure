$(document).ready(function () {
	$('#btnChangeImage').click(function () {
		$('#fileImage').click();
	});

	function confirmDeleteStudent(studentId) {
		swal({
		  title: 'Are you sure?',
		  text: "You won't be able to revert this!",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.value) {
		    swal(
		      'Deleted!',
		      'Your file has been deleted.',
		      'success'
		    );
		  }
		});
	}
});