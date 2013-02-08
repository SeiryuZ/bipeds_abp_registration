<form method="POST" action="<?php echo base_url()."index.php/input/process/".$debate_id."/".$round ?>">
  <div class="row">
    <div class="span4 offset4">
      <h1>Round <?php echo $round;?></h1>
      <input type="hidden" name="code_og" value="<?php echo $match->og;?>">
      <input type="hidden" name="code_oo" value="<?php echo $match->oo;?>">
      <input type="hidden" name="code_cg" value="<?php echo $match->cg;?>">
      <input type="hidden" name="code_co" value="<?php echo $match->co;?>">
    </div>
  </div>
  <div class="row">
    <div class="span5 ">
      <table cellpadding="2">
        <tr>
          <td><strong>OG</strong></td>
          <td><?php echo $teams[$match->og]->univ_code." ".$teams[$match->og]->team_code;?></td>
        </tr>
        <?php 
        $count = 0;
        foreach($temp_speakers as $temp_speaker)
        { 
          if ($speakers[$temp_speaker->speaker_id]->team_id == $teams[$match->og]->team_id )
          {
          ?>
        <tr>
          <td><?php echo $speakers[$temp_speaker->speaker_id]->speaker_name;?></td>
          <td><input type="text"  name="<?php echo "og_$temp_speaker->speaker_id" ?>" value="<?php echo $temp_speaker->points;?>"></td>
        </tr>
        <?php 
          } 
        $count += 1;
        }
          ?>
      </table>
    </div>
    <div class="span5 ">
      <table cellpadding="2">
        <tr>
          <td><strong>OO</strong></td>
          <td><?php echo $teams[$match->oo]->univ_code." ".$teams[$match->oo]->team_code;?></td>
        </tr>
        <?php 
        $count = 0;
        foreach($temp_speakers as $temp_speaker)
        { 
          if ($speakers[$temp_speaker->speaker_id]->team_id == $teams[$match->oo]->team_id )
          {
          ?>
        <tr>
          <td><?php echo $speakers[$temp_speaker->speaker_id]->speaker_name;?></td>
          <td><input type="text"  name="<?php echo "oo_$temp_speaker->speaker_id" ?>" value="<?php echo $temp_speaker->points;?>"></td>
        </tr>
        <?php 
          } 
        $count += 1;
        }
          ?>
      </table>
    </div>
    

  </div>


  <div class="row">
    <div class="span5 ">
      <table cellpadding="2">
        <tr>
          <td><strong>CG</strong></td>
          <td><?php echo $teams[$match->cg]->univ_code." ".$teams[$match->cg]->team_code;?></td>
        </tr>
        <?php 
        $count = 0;
        foreach($temp_speakers as $temp_speaker)
        { 
          if ($speakers[$temp_speaker->speaker_id]->team_id == $teams[$match->cg]->team_id )
          {
          ?>
        <tr>
          <td><?php echo $speakers[$temp_speaker->speaker_id]->speaker_name;?></td>
          <td><input type="text"  name="<?php echo "cg_$temp_speaker->speaker_id" ?>" value="<?php echo $temp_speaker->points;?>"></td>
        </tr>
        <?php 
          } 
        $count += 1;
        }
          ?>
      </table>
    </div>
    <div class="span5 ">
      <table cellpadding="2">
        <tr>
          <td><strong>CO</strong></td>
          <td><?php echo $teams[$match->co]->univ_code." ".$teams[$match->co]->team_code;?></td>
        </tr>
        <?php 
        $count = 0;
        foreach($temp_speakers as $temp_speaker)
        { 
          if ($speakers[$temp_speaker->speaker_id]->team_id == $teams[$match->co]->team_id )
          {
          ?>
        <tr>
          <td><?php echo $speakers[$temp_speaker->speaker_id]->speaker_name;?></td>
          <td><input type="text"  name="<?php echo "co_$temp_speaker->speaker_id" ?>" value="<?php echo $temp_speaker->points;?>"></td>
        </tr>
        <?php 
          } 
        $count += 1;
        }
          ?>
      </table>
    </div>
    

  </div>

  <div class="row" ><div class="span4 offset8"><a href="<?php echo base_url()."index.php/home";?>" class="btn btn-large btn-danger">Back</a><button class="btn btn-large btn-primary">Submit</button></div></div>



</form>