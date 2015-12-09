<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>

		<title>Snake Charmer Testing Page</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href="//www.barnescode.com/sc/css/bootstrap.min.css" rel="stylesheet">
		<link href="//www.barnescode.com/public/style/style.css" rel="stylesheet">
		<link href="//www.barnescode.com/public/style/main.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="//www.barnescode.com/sc/js/bootstrap.min.js"></script>

		<!--		SNAKE CHARMER JS		-->
		<script type="text/javascript" id="SCJS" src="//www.barnescode.com/sc/js/sc.js?license=xkH4edko9Kl3&themeId=1"></script>
		<!--		END SNAKE CHARMER JS		-->


		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="//www.barnescode.com/public/js/ts.js"></script>
		<![endif]-->
	</head>
	<body>
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
					<a class="navbar-brand" href="#">Snake Charmer Test</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#">Login</a></li>
					</ul>
				</div>
			</div><!-- /.container-fluid -->
		</nav>
		<div class="container">
			<div class="row">
				<h4 class="text-center sc-hover-event-trigger">Test Login Form</h4>
				<div class="col-md-offset-4 col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title sc-hover-event-trigger">Add events to the following</h3>
						</div>
						<div class="panel-body">
							<form action="#" method="POST">
								<label for="inputEmail" class="sr-only">Email address</label>
								<input type="email" name="email" id="txtEmail" class="form-control input-lg" placeholder="Email address" required>
								<label for="inputPassword" class="sr-only">Password</label>
								<input type="password" name="password" id="txtPassword" class="form-control input-lg" placeholder="Password" required>
								<div class="checkbox">
									<label><input name="rememberme" id="chkRememberMe" type="checkbox" value="1">Remember me</label>
								</div>
								<button id="btnSubmit" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>


<div class="sc_main">
  <div class="bigchat">
  	<div class="header">
    	<div class="name">Elias</div>
        <div class="time">Last seen at 9:47am</div>
        <div class="close"><i class="fa fa-close"></i></div>
    </div>
    <div class="primarychat">
    	<div class="message left">
        	<div class="icon"></div>
            <div class="chatbubble">
            	<p>asdfas dfsadf asdf asdf asdf asdf asdfasd fasdfasdf asdfas dfasd fasdf asdfasd fsadf sad fsdfsdf</p>
            </div>
        </div>
        <div class="timestamp">
        	12:03pm
        </div>
        <div class="message left">
        	<div class="icon"></div>
            <div class="chatbubble">
            	<iframe width="100%" height="200px" src="https://www.youtube.com/embed/pY-q7Bed6DU?list=RDpY-q7Bed6DU" frameborder="0"></iframe>
            </div>
        </div>
        <div class="timestamp">
        	12:04pm
        </div>
        <div class="message right">
        	<div class="icon"></div>
            <div class="chatbubble">
            	<p>asdfas dfsadf asdf asdf asdf as sad f</p>
            </div>
        </div>
    </div>
    <div class="chatfield">
    	<textarea rows="1" placeholder="Write a reply..."></textarea>
        <button class="chatbutton attachment" type="submit"><i class="fa fa-paperclip"></i></button>
        <button class="chatbutton emoji" type="submit"><i class="fa fa-smile-o"></i></button>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="js/autosize.min.js"></script>
<script>
	autosize(document.querySelectorAll('textarea'));
</script>


	</body>
</html>
