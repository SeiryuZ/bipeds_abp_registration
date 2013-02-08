
<div class="row">

  <div class="span6 offset3 login-form">
    <form action="<?php echo base_url()."index.php/login/process";?>" method="POST" >
      <div class="row">
        <div class="span2">Username:</div>
        <div class="span4"><input class"span4" type="text" name="username" placeholder="Username"></div>
      </div>
      <div class="row">
        <div class="span2">Password:</div>
        <div class="span4"><input class"span4" type="text" name="password" placeholder="Password"></div>
      </div>
      <div class="row">
        <div class="span2 offset4"><button class="btn btn-large btn-primary">Login</button></div>
        
      </div>
    </form>
  </div>

</div>