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
    <ul class="list-group">
      <?php foreach($TPLDATA["ActiveProject"] as $project) { ?>
        <li class="list-group-item"><span class="badge"><?php echo $project["Count"]; ?></span><?php echo $project["Title"]; ?></li>
      <? } ?>
<!--      <li class="list-group-item"><span class="badge">6</span>Vendor Portal</li>-->
<!--      <li class="list-group-item"><span class="badge">14</span>GRAR Website</li>-->
<!--      <li class="list-group-item"><span class="badge">9</span>Morbi leo risus</li>-->
<!--      <li class="list-group-item"><span class="badge">0</span>Porta ac consectetur ac</li>-->
<!--      <li class="list-group-item"><span class="badge">5</span>Vestibulum at eros</li>-->
    </ul>
  </div>
</div>