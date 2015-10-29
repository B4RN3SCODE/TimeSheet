<div class="col-md-4 signin">
  <form class="form-signin">
    <h2 class="form-signin-heading">Please sign in</h2><br /><?php if($FORCELOGIN) echo "><h4>You must log in to continue...</h4>"; ?>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <div class="checkbox">
      <label>
        <input type="checkbox" value="remember-me">Remember me
      </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
  </form>
</div>
