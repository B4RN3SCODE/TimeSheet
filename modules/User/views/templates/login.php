<?php if($FORCELOGIN) echo "<h4 class=\"text-center\">You must log in to continue...</h4>"; ?>
<div class="col-md-offset-4 col-md-4">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Please sign in</h3>
    </div>
    <div class="panel-body">
      <form action="/User/Index/Login/" method="POST">
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email" id="inputEmail" class="form-control input-lg" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control input-lg" placeholder="Password" required>
        <div class="checkbox">
          <label><input type="checkbox" value="remember-me">Remember me</label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
    </div>
  </div>
</div>