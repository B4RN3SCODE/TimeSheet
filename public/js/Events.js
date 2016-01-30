$(document).ready(function() {
  $("[data-task='PWGen']").on("click", function(e) {
    e.preventDefault();
    var url = urlPrefix + root_dir + 'Ajax/Index/GeneratePassword';
    var target = $(this).data('target');
    console.log(target);
    $.ajax({
      url: url, dataType: "html",
      success: function(data) {
        $(target).val(data);
      },
      error: function( xhr, status, errorThrown ) {
        Error_Output(xhr, status, errorThrown);
      }
    });
  });
});