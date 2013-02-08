
<form method="POST" action="<?php echo base_url()."index.php/admin/save";?>">
  <div class="row"><div class="span4 offset4"><h1>TV SYSTEM ADMIN PAGE</h1></div></div>
<div class="row">
  <div class="span4">
    <legend>Round</legend>
    <input type="text" name="round" value="<?php echo $round;?>">
  </div>
</div>
<div class="row">
  <div class="span4">
    <legend>State</legend>
    <input type="text" name="state" value="<?php echo $state;?>">
  </div>
</div>

<div class="row">
  <div class="span4">
    <legend>Motion</legend>
    <input type="text" name="motion" value="<?php echo $motion;?>" class="span6" >
  </div>
</div>

<div class="row">
  <div class="span6">
    <legend>Message</legend>
    <input type="text" name="message" value="<?php echo $message;?>" class="span6">
  </div>
</div>

<hr/>
<div class="row">
  <div class="span4 offset5">
    <button class="btn btn-large btn-primary">Update</button>
  </div>
</div>
</form>