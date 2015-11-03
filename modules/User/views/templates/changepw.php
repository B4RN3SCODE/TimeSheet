<div class="col-md-offset-4 col-md-4">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Change Password</h3>
    </div>
    <div class="panel-body">
      <form name="change-password" action="/User/Edit/ChangePassword" method="post">
        <input type="hidden" name="form" value="change-password" autofocus>
        <div class="form-group">
          <label for="old-pw">Old Password</label>
          <input type="password" class="form-control" name="old-pw">
        </div>
        <div class="form-group">
          <label for="new-pw">New Password</label>
          <input type="password" class="form-control" name="new-pw">
        </div>
        <div class="form-group">
          <label for="cfm-pw">Confirm Password</label>
          <input type="password" class="form-control" name="cfm-pw">
        </div>
        <input type="submit" class="btn btn-secondary btn-block" value="Change Password" />
      </form>
    </div>
  </div>
</div>