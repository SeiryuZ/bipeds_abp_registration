<div class="row">
  <div class="span4 offset4">
    <h1>Round <?php echo $round;?></h1>
  </div>
</div>
<div class="row">

  <table class="table table-striped">
    <tr>
      <th>Room No.</th>
      <th>OG</th>
      <th>OO</th>
      <th>CG</th>
      <th>CO</th>
      <th>Action</th>
    </tr>
    <tbody>
      <?php foreach($rooms->result() as $room) {?>
      <tr>
        <td><?php echo $room->venue_name;?></td>
        
        <td>
          <?php echo $teams[$room->og]->univ_code." ".$teams[$room->og]->team_code;?>
          <br/>
          <?php 
            if ($room->og == $room->first) echo "1st"; 
            if ($room->og == $room->second) echo "2nd"; 
            if ($room->og == $room->third) echo "3rd"; 
            if ($room->og == $room->fourth) echo "4th"; 
          ?>
        </td>
        <td>
          <?php echo $teams[$room->oo]->univ_code." ".$teams[$room->oo]->team_code;?>
          <br/>
          <?php 
            if ($room->oo == $room->first) echo "1st"; 
            if ($room->oo == $room->second) echo "2nd"; 
            if ($room->oo == $room->third) echo "3rd"; 
            if ($room->oo == $room->fourth) echo "4th"; 
          ?>
        </td>
        <td>
          <?php echo $teams[$room->cg]->univ_code." ".$teams[$room->cg]->team_code;?>
          <br/>
          <?php 
            if ($room->cg == $room->first) echo "1st"; 
            if ($room->cg == $room->second) echo "2nd"; 
            if ($room->cg == $room->third) echo "3rd"; 
            if ($room->cg == $room->fourth) echo "4th"; 
          ?>
        </td>
        <td>
          <?php echo $teams[$room->co]->univ_code." ".$teams[$room->co]->team_code;?>
          <br/>
          <?php 
            if ($room->co == $room->first) echo "1st"; 
            if ($room->co == $room->second) echo "2nd"; 
            if ($room->co == $room->third) echo "3rd"; 
            if ($room->co == $room->fourth) echo "4th"; 
          ?>
        </td>

        <td><a href="room/<?php echo $room->debate_id;?>/<?php echo $round;?>" class="btn btn-primary">Input</a></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

</div>