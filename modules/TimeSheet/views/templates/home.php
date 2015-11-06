<?php
$MyClients = ($TPLDATA["MyClients"] == false) ? array() : $TPLDATA["MyClients"];
$MyProjects = array();
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
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
                      <?php
                      $start_date = $_SESSION["CurrentBillingPeriod"]["StartDate"];
                      $end_date = $_SESSION["CurrentBillingPeriod"]["EndDate"];
                      ?>
                      <option value="<?php echo strtotime($start_date) . "-" . strtotime($end_date);?>">Current Cycle</option>
                      <?php
                      $previousArr = array();
                      $new_start_date = date_sub(new DateTime($start_date),new DateInterval("P16W"))->format("Y-m-d");
                      $daterange = new DatePeriod(new DateTime($new_start_date), new DateInterval('P2W'), new DateTime($start_date));
                      foreach($daterange as $date) {
                        $end_date = clone($date);
                        $end_date = $end_date->modify("+13 days")->format("m/d/Y");
                        $date = $date->format("m/d/Y");
                        $previousArr[] = array("value"=>strtotime($date) . "-" . strtotime($end_date),"label"=>$date . " to " . $end_date);
                      }
                      $previousArr = array_reverse($previousArr);
                      foreach($previousArr as $option) { ?>
                        <option value="<?php echo $option["value"]; ?>"><?php echo $option["label"]; ?></option><?
                      } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="panel-body">
                <div class="row">
                  <form name="timesheet" action="" method="post">
                    <div id="existing-entries" class="col-md-12 table-responsive" style="display: block;">
                      <?php include_once "modules/TimeSheet/views/templates/home/existing-entries.php"; ?>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
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