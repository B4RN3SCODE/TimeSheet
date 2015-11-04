<?php $clients = $TPLDATA["Clients"];
$MyClients = $TPLDATA["MyClients"]; ?>
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Maintain Database</h3>
          </div>
          <div class="panel-body">
            <ul class="nav nav-tabs nav-justified" role="tablist">
              <li role="presentation" class="active"><a href="#allclients" aria-controls="allclients" role="tab" data-toggle="tab">All Projects</a></li>
              <li role="presentation"><a href="#myclients" aria-controls="myclients" role="tab" data-toggle="tab">My Projects</a></li>
              <li role="presentation"><a href="#users" aria-controls="users" role="tab" data-toggle="tab">Users</a></li>
            </ul>
            <div id="inner-panel">
              <div class="row">
                <div class="col-xs-12">
                  <div class="col-xs-12">
                    <br />
                    <div class="tab-content">
                      <?php include_once "modules/TimeSheet/views/templates/admin_tabs/AllProjects.php"; ?>
                      <?php include_once "modules/TimeSheet/views/templates/admin_tabs/MyProjects.php"; ?>
                      <?php include_once "modules/TimeSheet/views/templates/admin_tabs/Users.php"; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<script type="text/javascript">
//    $(".glyphicon-floppy-disk").click(function() {
//      var value = $(this).closest(".list-group-item").children('.input-group').children('input.form-control').val();
//      var oldclass = $(this).attr("class");
//      $(this).attr("class","fa fa-refresh fa-spin");
//      var html = '<div class="list-group"><a class="list-group-item"><h4 class="list-group-item-heading">' + value + '</h4></a></div>';
//      $(this).closest(".list-group").before(html);
//      $(this).attr("class", oldclass);
//    });
  $(document).ready(function () {
    <?php if($TPLDATA["SearchText"] != "") { ?>
    ShowSelectedClientsProjectList("<?php echo $TPLDATA["SearchText"]; ?>");
    <?php } ?>
  });
</script>
<?php include_once "views/modals/AddClient.php";
include_once "views/modals/EditProject.php";
include_once "views/modals/DeleteProject.php";
include_once "views/modals/EditClient.php"; ?>