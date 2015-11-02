      <div class="col-md-9">
        <div class="row">
          <div class="col-xs-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Welcome to the TimeSheet module. Please begin by selecting your client and project below.</h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <form name="timesheet" action="" method="post">
                    <div class="col-sm-6">
                      <div class="input-group">
                        <select name="client" class="form-control">
                          <option value="-1" selected>-- Select Client --</option>
                          <option value="0">Flex-N-Gate</option>
                          <option value="1">GRAR</option>
                        </select>
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="button">&nbsp;<span class="glyphicon glyphicon-plus"></span>&nbsp;</button>
                        </span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="input-group">
                        <select name="project" class="form-control">
                          <option value="-1" selected>-- Select Project --</option>
                          <option value="0">Vendor Portal</option>
                        </select>
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="button">&nbsp;<span class="glyphicon glyphicon-plus"></span>&nbsp;</button>
                        </span>
                      </div>
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
                            <th colspan="2" width="1%">Remove</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><input class="form-control datepicker" name="timesheet-date[]" placeholder="<?=date("m/d/Y", time())?>" /></td>
                            <td><input class="form-control" type="number" name="timesheet-hours[]" placeholder="0.5" /></td>
                            <td><input class="form-control" type="text" name="timesheet-description[]" placeholder="Created database" /></td>
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
        $('.datepicker').datepicker();
      });
      $('.datepicker').datepicker();
    </script>