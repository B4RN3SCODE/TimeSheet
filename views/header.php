<html>
<head>
  <meta charset="UTF-8">
<!--  <meta name="viewport" content="width=device-width, initial-scale=1.0" />-->

  <title><?=ucfirst($module)?> | Arbor Solutions</title>
  <link href='http://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <link href="public/style/bootstrap.css" rel="stylesheet">
  <link href="public/style/datepicker.css" rel="stylesheet">
  <link href="public/style/style.css" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="public/js/jquery-ui.min.js"></script>
<!--  <script src="public/js/app.js"></script>-->
  <script src="public/datepicker/js/bootstrap-datepicker.js"></script>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <script src="public/js/ts.js"></script>
  <![endif]-->
</head>
<body>
<form name="navForm" id="navForm" method="POST">
  <input type="hidden" name="module" />
  <input type="hidden" name="view" />
</form>
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
          <?php module_menu(array("Select Module"=>$modules)); ?>
        </ul>
        <ul class="nav navbar-nav">
          <?php nav_menu(array("Home"=>"home","Admin"=>"admin")); ?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <?php user_options_menu(); ?>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <div class="container">
