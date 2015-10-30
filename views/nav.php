  <nav class="navbar navbar-default">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Arbor Solutions</a>

      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <?php module_menu(array("Select Module"=>array_keys(array_flip($GLOBALS["APP"]["MODULE_MAP"])))); ?>
        </ul>
        <ul class="nav navbar-nav">
          <?php nav_menu($GLOBALS["APP"]["NAVIGATION"][strtolower($GLOBALS["APP"]["INSTANCE"]->_controller->GetModule())]); ?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <?php user_options_menu(); ?>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <div class="container">
    <div class="row">
<!--      <div class="col-md-10">-->
<!--        --><?php //if(TSApp::StringHasValue($GLOBALS["APP"]["ERROR"])) echo "<h4 style=\"color:red;\">{$GLOBALS["APP"]["ERROR"]}</h4>"; ?>
<!--      </div>-->