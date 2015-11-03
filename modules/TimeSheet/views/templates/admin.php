<?php
$clients = $TPLDATA["Clients"];
?>
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Maintain Database</h3>
          </div>
          <div class="panel-body">
            <ul class="nav nav-tabs nav-justified" role="tablist">
              <li role="presentation" class="active"><a href="#allclients" aria-controls="allclients" role="tab" data-toggle="tab">All Clients</a></li>
              <li role="presentation"><a href="#myclients" aria-controls="myclients" role="tab" data-toggle="tab">My Clients</a></li>
              <li role="presentation"><a href="#users" aria-controls="users" role="tab" data-toggle="tab">Users</a></li>
            </ul>
            <div id="inner-panel">
              <div class="row">
                <div class="col-xs-12">
                  <div class="col-xs-12">
                    <br />
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane fade in active" id="allclients">
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
                                <a class="list-group-item list-group-item-info" data-toggle="collapse" data-parent="#accordion" href="#client<?php echo $cid; ?>"><?php echo trim($client["Name"]); ?><span class="pull-right glyphicon glyphicon-pencil" data-edit-client="<?php echo $cid; ?>"></span><span class="badge"><? echo count($client["Projects"]); ?></span></a>
                              </h4>
                              <!--    </div>-->
                              <div id="client<?php echo $cid; ?>" class="panel-collapse collapse">
                                <?php if(count($client["Projects"]) > 0) {
                                  foreach($client["Projects"] as $pid => $project) { ?>
                                    <div class="list-group">
                                      <a class="list-group-item">
                                        <span class="pull-right glyphicon glyphicon-pencil" data-edit-id="<?php echo $pid; ?>"></span>
                                        <span class="pull-right glyphicon glyphicon-plus" data-addtomylist="<?php echo $pid; ?>"></span>
                                        <span class="pull-right glyphicon glyphicon-remove" data-del-id="<?php echo $pid; ?>"></span>
                                        <span class="rate">$<?php echo $project["Rate"]; ?></span>
                                        <h4 class="list-group-item-heading"><?php echo $project["Name"]; ?></h4>
                                      </a>
                                    </div><?
                                  }}?>
                                <form name="add-project" action="/TimeSheet/Admin/AddProject" method="post" onsubmit="return AddProject(this);">
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
                      <div role="tabpanel" class="tab-pane" id="myclients">
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
                                <a class="list-group-item list-group-item-info" data-toggle="collapse" data-parent="#accordion" href="#client<?php echo $cid; ?>"><?php echo trim($client["Name"]); ?><span class="pull-right glyphicon glyphicon-pencil" data-edit-client="<?php echo $cid; ?>"></span><span class="badge"><? echo count($client["Projects"]); ?></span></a>
                              </h4>
                              <!--    </div>-->
                              <div id="client<?php echo $cid; ?>" class="panel-collapse collapse">
                                <?php if(count($client["Projects"]) > 0) {
                                  foreach($client["Projects"] as $pid => $project) { ?>
                                    <div class="list-group">
                                    <a class="list-group-item">
                                      <span class="pull-right glyphicon glyphicon-pencil" data-edit-id="<?php echo $pid; ?>"></span>
                                      <span class="pull-right glyphicon glyphicon-remove" data-del-id="<?php echo $pid; ?>"></span>
                                      <span class="rate">$<?php echo $project["Rate"]; ?></span>
                                      <h4 class="list-group-item-heading"><?php echo $project["Name"]; ?></h4>
                                    </a>
                                    </div><?
                                  }}?>
                                <form name="add-project" action="/TimeSheet/Admin/AddProject" method="post" onsubmit="return AddProject(this);">
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