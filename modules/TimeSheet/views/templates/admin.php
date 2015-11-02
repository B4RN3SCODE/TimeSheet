<?php
$clients = $TPLDATA["Clients"]; //array(
//  "American Home Fitness"=>array("Desktop","NetServ","NetServ_50"),
//  "American Seating"=>array("Appdev","Appdev38","RPGDev"),
//  "Arbor"=>array("Adrt","Appdev","Cognos","Holiday","OverQuote","Vacation"),
//  "Corvac"=>array("Appdev","RPGDev","SMDB_V2"),
//  "Design One"=>array("NetServ")
//)
?>
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Maintain Database</h3>
          </div>
          <div class="panel-body">
            <ul class="nav nav-tabs nav-justified" role="tablist">
              <li role="presentation" class="active"><a href="#clients" aria-controls="clients" role="tab" data-toggle="tab">Clients</a></li>
              <li role="presentation"><a href="#users" aria-controls="users" role="tab" data-toggle="tab">Users</a></li>
            </ul>
            <div id="inner-panel">
              <div class="row">
                <div class="col-xs-push-1 col-xs-10">
                  <br />
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="clients">
                      <div class="row">
                        <div class="col-sm-8">
                          <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2">
                              <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            </span>
                            <input id="search-box" type="text" value="<?php echo $TPLDATA["SearchText"]; ?>" class="form-control" placeholder="Search for a client..." aria-describedby="sizing-addon2">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <button class="btn btn-block btn-default btn-primary" data-toggle="modal" data-target="#modal-newclient"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Add a new client</button>
                        </div>
                      </div>
                      <br />
                      <!-- input list here -->
                      <div class="panel-group" id="client-list">
                        <?php foreach ($clients as $cid => $client) { ?>
                          <div class="panel panel-default">
                            <!--    <div class="panel-heading">-->
                            <h4 class="panel-title">
                              <a class="list-group-item list-group-item-info" data-toggle="collapse" data-parent="#accordion" href="#client<?php echo $cid; ?>"><?php echo $client["Name"]; ?><span class="badge"><? echo count($client["Projects"]); ?></span></a>
                            </h4>
                            <!--    </div>-->
                            <div id="client<?php echo $cid; ?>" class="panel-collapse collapse">
                              <?php if(count($client["Projects"]) > 0) {
                                foreach($client["Projects"] as $pid => $project) { ?>
                                  <div class="list-group">
                                    <a class="list-group-item">
                                      <span class="rate">$<?php echo $project["Rate"]; ?></span><h4 class="list-group-item-heading"><?php echo $project["Name"]; ?></h4>
                                    </a>
                                  </div><?
                                }}?>
                              <form name="add-project" action="/TimeSheet/Admin/AddProject" method="post" onsubmit="return validate_add_client(this);">
                                <input type="hidden" name="clientId" value="<?php echo $cid; ?>" />
                                <div class="list-group">
                                  <a class="list-group-item">
                                    <div class="row">
                                      <div class="col-sm-7">
                                        <input name="name" type="text" class="form-control" placeholder="Add a new project to <?php echo $client["Name"]; ?>">
                                      </div>
                                      <div class="col-sm-3">
                                        <div class="input-group">
                                          <span class="input-group-addon">$</span>
                                          <input name="rate" type="number" class="form-control" placeholder="50" aria-label="Amount (to the nearest dollar)">
                                        </div>
                                      </div>
                                      <div class="col-sm-2">
                                        <button class="btn btn-block btn-default" type="button" onclick="this.form.submit()" disabled>&nbsp;<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;</button>
                                      </div>
                                    </div>
                                  </a>
                                </div>
                              </form>
                            </div>
                          </div>
                        <? } ?>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="users">
                      <form name="timesheet-active-users" action="" method="post">
                      <table class="table table-striped table-hover table-condensed">
                        <thead>
                        <tr>
                          <th width="1%">User ID</th>
                          <th width="15%">User Name</th>
                          <th width="10%" class="text-center">Enabled</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($TPLDATA["Users"] as $User) { ?>
                          <tr>
                            <td class="text-center"><? echo $User->getId(); ?><input type="hidden" name="userid[]" value="<? echo $User->getId(); ?>" /></td>
                            <td><? echo $User->getFirstName() . ' ' . $User->getLastName(); ?></td>
                            <td class="text-center"><input type="checkbox" name="active[]"<?php if($User->getActive()) echo " checked"; ?> /></td>
                          </tr>
                        <? } ?>
                        </tbody>
                        <tfoot>
                        <tr>
                          <td colspan="3"><button class="btn btn-primary btn-block">Save</button></td>
                        </tr>
                        </tfoot>
                      </table>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<script type="text/javascript">
  $(function() {
    var availableTags = [];
    $("#client-list .panel .panel-title a.list-group-item").each(function () {
      var label = $(this).text().substr(0,$(this).text().length - $(this).children("span").text().length);
      availableTags.push({'label': label}); //, 'value' : $(this).parent().attr('id') });
    });
    $("#search-box").autocomplete({
      source: availableTags,
      select: function (event, ui) {
        $("#client-list .panel-collapse").removeClass("in");
        $("#client-list .panel .panel-title a.list-group-item").each(function () {
          var label = $(this).text().substr(0,$(this).text().length - $(this).children("span").text().length);
          if (label != ui.item.label) {
            $(this).hide();
          } else {
            $(this).show();
          }
        });
        $('#client-list .panel-title a.list-group-item:visible').click();
      }
    });
    $("#search-box").keyup(function () {
      if ($(this).val().length < 1) {
        $("#client-list .panel .panel-title a.list-group-item").each(function () {
          $(this).show();
        });
        $("#client-list .panel-collapse").removeClass("in");
      }
    });

    $(".list-group-item input[name='name'],.list-group-item input[name='rate']").on("keyup",function() {
      var button = $(this.form).find('button')[0];
      if(this.form.name.value.trim().length > 0 && this.form.rate.value.trim().length > 0) {
        $(button).removeAttr('disabled');
      } else {
        $(button).attr('disabled','disabled');
      }
    });

//    $(".glyphicon-floppy-disk").click(function() {
//      var value = $(this).closest(".list-group-item").children('.input-group').children('input.form-control').val();
//      var oldclass = $(this).attr("class");
//      $(this).attr("class","fa fa-refresh fa-spin");
//      var html = '<div class="list-group"><a class="list-group-item"><h4 class="list-group-item-heading">' + value + '</h4></a></div>';
//      $(this).closest(".list-group").before(html);
//      $(this).attr("class", oldclass);
//    });

    <?php if($TPLDATA["SearchText"] != "") { ?>
    ShowSelectedClientsProjectList("<?php echo $TPLDATA["SearchText"]; ?>");
    <?php } ?>
  });
</script>
<?php include_once "views/modals/AddClient.php"; ?>