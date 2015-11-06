<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Current Billing Cycle</h3>
  </div>
  <?php
  ?>
  <div class="panel-body">
    <span class="btn-block text-center">
      <label><?php echo date("l",strtotime($_SESSION["CurrentBillingPeriod"]["StartDate"])); ?> [<?php echo date("m/d/Y",strtotime($_SESSION["CurrentBillingPeriod"]["StartDate"])); ?>]</label><br />to<br />
      <label><?php echo date("l",strtotime($_SESSION["CurrentBillingPeriod"]["EndDate"])); ?> [<?php echo date("m/d/Y",strtotime($_SESSION["CurrentBillingPeriod"]["EndDate"])); ?>]</label><br />
      <label><?php echo $_SESSION["CurrentBillingPeriod"]["DaysLeft"]; ?> days left</label>
    </span>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Active Projects</h3>
  </div>
  <div class="panel-body">
    <form name="ActiveProjects" action="/TimeSheet/Home" method="post">
      <input type="hidden" name="project" />
    </form>
    <ul class="list-group">
      <?php foreach($TPLDATA["ActiveProject"] as $id => $row) { ?>
        <li class="list-group-item" data-pid="<?php echo $id; ?>"><span class="badge"><?php echo $row["Count"]; ?></span><?php echo $row["Title"]; ?></li>
      <? } ?>
    </ul>
  </div>
</div>