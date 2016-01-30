$(document).ready(function() {
  $("#GeneratePassword").on("click", function(e) {
    var url = urlPrefix + root_dir + 'Ajax/Index/GeneratePassword';
    $.ajax({
      url: url, dataType: "html",
      success: function(data) {
        $('input[name="password"]').val(data);
      },
      error: function( xhr, status, errorThrown ) {
        Error_Output(xhr, status, errorThrown);
      }
    });
  });
});