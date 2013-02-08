<div class="row">
  <div class="span4 offset4 logo">
    <img src="<?php echo asset_url()."images/logoabp.png";?>">
  </div>
</div>

<div class="row add-bottom">
  <div class="span6 offset3">
    <h1>BIPEDS ABP Registration System</h1>
  </div>
</div>
<div class="row add-bottom">
  <div class="span2 offset3 center">
    <a href="<?php echo base_url();?>">Registration</a>
  </div>
  <div class="span2 center">
   <a href="<?php echo base_url()."index.php/list?p=d";?>"> Debaters</a>
  </div>
  <div class="span2 center">
   <a href="<?php echo base_url()."index.php/list?p=a";?>"> Adjudicators</a>
  </div>
</div>



<div class="main-content">

  <?php
  $total = 0; 
  $present =0;
  $none = 0;
  foreach ($speakers->result() as $speaker ) { 
    $total += 1;
    if( $speaker->present == true) $present +=  1; else $none += 1;
  }

  echo "<h2>TOTAL: $total READY: $present NOT READY: $none </h2>";

   ?>

  <table class="table table-condensed ">
    <tr>
        <th>Code</th>
        <th>Name</th>
        <th>University</th>
        <th>Ready</th>
    </tr>
    <?php foreach ($speakers->result() as $speaker ) { ?>
      <tr class="<?php if( $speaker->present == true) echo "present"; else echo "none
      "; ?>">
        <td>A<?php echo $speaker->adjud_id?></td>
        <td><?php echo $speaker->adjud_name;?></td>
        <td><?php echo $speaker->univ_name;?></td>
        <td><?php if( $speaker->present == true) echo "PRESENT"; else echo "X";?></td>
      </tr>

    <?php } ?>
  </table>

</div>