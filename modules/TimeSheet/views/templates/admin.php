<?php
$clients = array(
  "American Home Fitness"=>array("Desktop","NetServ","NetServ_50"),
  "American Seating"=>array("Appdev","Appdev38","RPGDev"),
  "Arbor"=>array("Adrt","Appdev","Cognos","Holiday","OverQuote","Vacation"),
  "Corvac"=>array("Appdev","RPGDev","SMDB_V2"),
  "Design One"=>array("NetServ")
)
?>
      <div class="col-md-push-1 col-md-10">
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
                            <input id="search-box" type="text" class="form-control" placeholder="Search for a client..." aria-describedby="sizing-addon2">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <button class="btn btn-block btn-default btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Add a new client</button>
                        </div>
                      </div>
                      <br />
                      <!-- input list here -->
                      <div class="panel-group" id="client-list">
                        <?php $count = 0; foreach ($clients as $client => $projects) { $count++; ?>
                          <div class="panel panel-default">
                            <!--    <div class="panel-heading">-->
                            <h4 class="panel-title">
                              <a class="list-group-item list-group-item-info" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$count?>"><?=$client?><span class="badge"><?=count($projects)?></span></a>
                            </h4>
                            <!--    </div>-->
                            <div id="collapse<?=$count?>" class="panel-collapse collapse">
                              <?php if(count($projects) == 0) { ?>
                                <div class="list-group">
                                  <a class="list-group-item">
                                    <input type="text" class="form-control">
                                  </a>
                                </div>
      <!--                          echo '<div class="list-group">nothing</div>';-->
                              <? } else {
                                foreach($projects as $project) { ?>
                                  <div class="list-group">
                                  <a class="list-group-item">
                                    <span class="rate">$<?=rand(10,150)?></span><h4 class="list-group-item-heading"><?=$project?></h4>
                                  </a>
                                  </div><?
                                } ?>
                                <div class="list-group">
                                  <a class="list-group-item">
                                    <div class="input-group">
                                      <input type="text" class="form-control" placeholder="Add a new project to <?=$client?>">
                                      <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" disabled>&nbsp;<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;</button>
                                      </span>
                                    </div>
                                  </a>
                                </div>
                              <? } ?>

                            </div>
                          </div>
                        <? } ?>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="users">
                      <table class="table table-striped table-hover table-condensed">
                        <thead>
                        <tr>
                          <th width="1%">User ID</th>
                          <th width="15%">User Name</th>
                          <th width="10%" class="text-center">Enabled</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        for($i = 0; $i <= 10; $i++) { ?>
                          <tr>
                            <td class="text-center"><?=$i?></td>
                            <td><?="User$i"?></td>
                            <td class="text-center"><input type="checkbox" type="active[]" name="timesheet-hours[]" /></td>
                          </tr>
                        <? } ?>
                        </tbody>
                        <tfoot>
                        <tr>
                          <td colspan="3"><button class="btn btn-primary btn-block">Save</button></td>
                        </tr>
                        </tfoot>
                      </table>
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

    $(".list-group-item .input-group input.form-control").on("keyup",function() {
      var button = $($(this).siblings()[0]).children('button.btn')[0];
      if($(this).val().trim().length == 0) {
        $(button).attr('disabled', 'disabled');
      } else {
        $(button).removeAttr('disabled')
      }
    });

    $(".glyphicon-floppy-disk").click(function() {
      var value = $(this).closest(".list-group-item").children('.input-group').children('input.form-control').val();
      var oldclass = $(this).attr("class");
      $(this).attr("class","fa fa-refresh fa-spin");
      var html = '<div class="list-group"><a class="list-group-item"><h4 class="list-group-item-heading">' + value + '</h4></a></div>';
      $(this).closest(".list-group").before(html);
      $(this).attr("class", oldclass);
    });
  });
</script>