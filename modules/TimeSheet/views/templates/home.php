<?php
$MyClients = ($TPLDATA["MyClients"] == false) ? array() : $TPLDATA["MyClients"];
$MyProjects = array();
?>
      <div class="col-md-9">
        <div class="row">
          <div class="col-xs-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Welcome to the TimeSheet module. Please begin by selecting your client and project below.</h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <form name="timesheet" action="" method="post" onsubmit="return ValidateTimeSheet();">
                    <div class="col-sm-6">
                      <select name="client" class="form-control">
                        <option value="-1">-- Select Client --</option>
                          <?php foreach($MyClients as $cid => $client) { ?>
                              <option value="<?php echo $cid ?>"<?php if($client["Default"] == true) { $MyProjects = $client["Projects"]; echo " selected"; }?>><?php echo $client["Name"]; ?></option>
                          <?php } ?>
                      </select>
                    </div>
                    <div class="col-sm-6">
                      <select name="project" class="form-control">
                        <option value="-1">-- Select Project --</option>
                          <?php foreach($MyProjects as $pid => $project) { ?>
                              <option value="<?php echo $pid ?>"<?php if($project["Default"] == true) echo " selected";?>><?php echo $project["Name"] ?></option>
                          <?php } ?>
                      </select>
                    </div>
                    <div class="clearfix"></div>
                    <div id="tbl-entries" class="col-md-12" style="display: block;">
                      <br>
                      <table class="table table-striped table-hover table-condensed">
                        <thead>
                          <tr>
                            <th width="15%">Date</th>
                            <th width="10%">Hours</th>
                            <th>Description</th>
                            <th width="1%">Bill</th>
                            <th width="1%">Remove</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><input class="form-control datepicker" name="date[]" placeholder="<?=date("m/d/Y", time())?>" /></td>
                            <td><input class="form-control" type="number" name="hours[]" placeholder="0.5" /></td>
                            <td><input class="form-control" type="text" name="description[]" placeholder="Created database" /></td>
                            <td class="text-center"><input type="checkbox" name="bill[]" checked /></td>
                            <td><button class="btn btn-danger pull-right" type="button" title="Remove">&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;</button></td>
<!--                            <td><button class="btn btn-warning" type="button" title="Save">&nbsp;<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;</button></td>-->
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="5">
                              <div class="row">
                                <div class="col-xs-4"><button class="btn btn-primary btn-block">New row</button></div>
                                <div class="col-xs-4 pull-right"><input type="submit" class="btn btn-secondary btn-block" value="Save" /></div>
                              </div>
                            </td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <?php sidebar("sidebar"); ?>
      </div>
    <script>
      $('#tbl-entries table tfoot button').on('click',function(event) {
        event.preventDefault();
        $('#tbl-entries table tbody').append('<tr>' + $('#tbl-entries table tbody tr:first-child').html() + '<tr>');
        $('.datepicker').off().datepicker();
      });
      $('.datepicker').datepicker();
    </script>