<?php
$MyClients = ($TPLDATA["MyClients"] == false) ? array() : $TPLDATA["MyClients"];
$MyProjects = array();
?>
      <div class="col-md-9">
        <div class="row">
          <div class="col-xs-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Line Entry</h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <form name="timesheet" action="/TimeSheet/Home/AddEntry" method="post" onsubmit="return ValidateTimeSheet();">
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
                    <br />
                    <div id="line-entries" class="col-md-12">
                      <br />
                      <?php include_once "modules/TimeSheet/views/templates/home/line-entry.php"; ?>
                    </div>
                    <div class="col-xs-4"><button id="newrow" class="btn btn-primary btn-block">New row</button></div>
                    <div class="col-xs-4 pull-right"><input type="submit" class="btn btn-secondary btn-block" value="Save" /></div>
                  </form>
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-sm-6"><h3 class="panel-title">Existing Line Items</h3></div>
                  <div class="col-sm-6">
                    <select name="BillingPeriod" class="form-control">
                      <?php foreach($TPLDATA["BillingPeriod"] as $BillingPeriod) { ?>
                      <option value="<?php echo $BillingPeriod["value"]; ?>"<?php echo ($BillingPeriod["label"] == "Current Cycle") ? " selected" : ""; ?>><?php echo $BillingPeriod["label"]; ?></option>
                      <? } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div id="existing-entries" class="col-md-12 table-responsive" style="display: block;">
                    <?php include_once "modules/TimeSheet/views/templates/home/existing-entries.php"; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="ActiveProjects" class="col-md-3">
        <?php include_once "modules/TimeSheet/views/sidebar/sidebar.php"; ?>
      </div>
    <script>
      $('#newrow').on('click',function(event) {
        event.preventDefault();
        $('#line-entries').append('<div class="panel panel-default">' + $('#line-entries div.panel:first').html() + '</div>');
        var last = $('#line-entries div.panel:last');
        $(last).find('input[type="text"]:not(:last-child)').val('0');
        $('.datepicker').off().datepicker();
      });
      $('.datepicker').datepicker();
    </script>
<?php include_once "views/modals/EditLineItem.php"; ?>
<table class="table">
  <thead>
  <tr><th>Start</th><th>End</th></tr>
  </thead>
  <tbody>
  <tr>
    <td>Monday</td><td>[11/16/2015]</td>
  </tr>
  <tr>
    <td>Sunday</td><td>[11/29/2015]</td>
  </tr>
  </tbody>
</table>
<label>Monday [11/16/2015]</label><br>to<br>
<label>Sunday [11/29/2015]</label><br>
<label>9 days left</label>
