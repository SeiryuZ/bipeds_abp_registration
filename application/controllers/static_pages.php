<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Static_pages extends CI_Controller {

  /**
   * Index Page for this controller.
   *
   * Maps to the following URL
   *    http://example.com/index.php/welcome
   *  - or -  
   *    http://example.com/index.php/welcome/index
   *  - or -
   * Since this controller is set as the default controller in 
   * config/routes.php, it's displayed at http://example.com/
   *
   * So any other public methods not prefixed with an underscore will
   * map to /index.php/welcome/<method_name>
   * @see http://codeigniter.com/user_guide/general/urls.html
   */
  public function index()
  {
    $data['title'] = "BIPEDS ABP Registration System";

    

    $params = $this->loadParam();

    $data['round'] = $params[0][1];

    //var_dump($params);
    //die();

    $this->load->view('header', $data);
    $this->load->view('index_tournament');
    $this->load->view('footer');
  }


  public function process()
  {
    $code = $_POST["code"];
    $type = substr($code, 0, 1);
    $id = substr($code, 1);

    $result ="<p class='result'>";

    if ( $type == 'd' || $type == 'D'  )
    {
      $this->db->where('speaker_id', $id );
      $speaker = $this->db->get('speaker');

      if ( $speaker->num_rows() > 0 )
      {
        $speaker = $speaker->result();
        $result .= $speaker[0]->speaker_name;
      }
      else
        $result .= "INVALID";

      $data=array( "present" => true );
      $this->db->where('speaker_id',$id);
      $this->db->update("speaker",$data);
    }
    else

      if ( $type == 'a' ||  $type == 'A'  )
      {
        $this->db->where('adjud_id', $id );
        $speaker = $this->db->get('adjudicator');

         if ( $speaker->num_rows() > 0 )
        {
        $speaker = $speaker->result();
        $result .= $speaker[0]->adjud_name;
        }
        else
        $result .= "INVALID";

        $data=array( "present" => true );
        $this->db->where('adjud_id',$id);
        $this->db->update("adjudicator",$data);

      }
    else
      $result .= "INVALID";




    $result .= "</p>";
    echo $result;
    //echo "$type #### $id";

  }

  public function reset()
  {
    $data= array("present" => false);
    $this->db->update( "speaker"  ,  $data);
    $this->db->update( "adjudicator"  ,  $data);
    redirect(base_url(), "refresh");
  }


  public function list_()
  {
    $data['title'] = "BIPEDS ABP Registration System";
    $type =$_GET["p"];

    $message ="";

    if ( $type == 'd' || $type == 'D'  )
    { 
      $this->db->select('*');

      $this->db->from("speaker");
      $this->db->join("team", "speaker.team_id = team.team_id ");
      $this->db->join("university", "team.univ_id = university.univ_id");
      $this->db->order_by('speaker.speaker_id ASC');
      //$this->db->order_by('speaker.present ASC, team.univ_id ASC, team.team_code ASC'); 

      $speakers = $this->db->get();



    }

    if ( $type == 'a' || $type == 'A'  )
    {
      $this->db->select('*');

      $this->db->from("adjudicator");
      $this->db->join("university", "university.univ_id = adjudicator.univ_id");
      $this->db->order_by('adjudicator.adjud_id ASC');
      //$this->db->order_by('adjudicator.present ASC, university.univ_name ASC'); 

      $speakers = $this->db->get();


    }

    $data['speakers'] = $speakers;
    $this->load->view('header', $data);
    if ( $type == 'a' || $type == 'A'  )
    {
      $this->load->view('index_adjudicator', $data);
    }
    if ( $type == 'd' || $type == 'D'  )
    {
      $this->load->view('index_speaker', $data);
    }
    $this->load->view('footer');

  }



  public function load()
  {
    $data['title'] = "Login Page";
    $params = $this->loadParam();
    $round = trim($params[0][1]);
    $state = $params[1][1];
    $motion = $params[2][1];
    $msg = $params[3][1];

    $message ="";

    if ($state == 0 )
    {
      $message .= "<h1>$msg</h1>";
    } 

    if ($state == 2 )
    {
      $message .= "<h1>$motion</h1>";
    }

    if ($state == 3)
    {
        $this->db->select('*');
        $this->db->from("draw_round_$round");
        $this->db->join("venue", "venue.venue_id = draw_round_$round.venue_id");
        $this->db->join("temp_result_round_$round", "draw_round_$round.debate_id = temp_result_round_$round.debate_id");

        $rooms = $this->db->get();

        //var_dump($rooms->result());
        //die();


        $this->db->select('*');
        $this->db->from("team");
        $this->db->join("university", "team.univ_id = university.univ_id");
        $teams_temp = $this->db->get();

        $teams = array();

        foreach($teams_temp->result() as $team )
        {
          $teams[$team->team_id] = $team;
        }

        $message = "<table class='table table-striped table-condensed'>";

        $message .= "<tr>";
        $message .= "<th>Room</th>";
        $message .= "<th>OG</th>";
        $message .= "<th>OO</th>";
        $message .= "<th>CG</th>";
        $message .= "<th>CO</th>";
        $message .= "</tr>";

        foreach ($rooms->result() as $room)
        {
          $message.="<tr>";

          $message.="<td>$room->venue_name</td>";
          $message.="<td>".$teams[$room->og]->univ_code." ".$teams[$room->og]->team_code."<br/>";
          if ($room->og == $room->first) $message .= "1st"; 
          if ($room->og == $room->second) $message .= "2nd"; 
          if ($room->og == $room->third) $message .= "3rd"; 
          if ($room->og == $room->fourth) $message .= "4th";

          $message .= "</td>";

          $message.="<td>".$teams[$room->oo]->univ_code." ".$teams[$room->oo]->team_code."<br/>";

          if ($room->oo == $room->first) $message .= "1st"; 
          if ($room->oo == $room->second) $message .= "2nd"; 
          if ($room->oo == $room->third) $message .= "3rd"; 
          if ($room->oo == $room->fourth) $message .= "4th";


          $message.="</td>";
          $message.="<td>".$teams[$room->cg]->univ_code." ".$teams[$room->cg]->team_code."<br/>";

          if ($room->cg == $room->first) $message .= "1st"; 
          if ($room->cg == $room->second) $message .= "2nd"; 
          if ($room->cg == $room->third) $message .= "3rd"; 
          if ($room->cg == $room->fourth) $message .= "4th";

          $message .= "</td>";
          $message .="<td>".$teams[$room->oo]->univ_code." ".$teams[$room->oo]->team_code."<br/>";

          if ($room->co == $room->first) $message .= "1st"; 
          if ($room->co == $room->second) $message .= "2nd"; 
          if ($room->co == $room->third) $message .= "3rd"; 
          if ($room->co == $room->fourth) $message .= "4th";

          $message .= "</td>";


          $message.="</tr>";
        }

        $message .= "</table>";



    }

    if ($state == 1)
    {
        $this->db->select('*');
        $this->db->from("draw_round_$round");
        $this->db->join("venue", "draw_round_$round.venue_id = venue.venue_id ");


        $rooms = $this->db->get();

        //var_dump($rooms->result());
        //die();


        $this->db->select('*');
        $this->db->from("team");
        $this->db->join("university", "team.univ_id = university.univ_id");
        $teams_temp = $this->db->get();

        $teams = array();
        foreach($teams_temp->result() as $team )
        {
          $teams[$team->team_id] = $team;
        }

        $this->db->select('*');
        $this->db->from("adjudicator");
        $this->db->join("adjud_round_$round", "adjud_round_$round.adjud_id = adjudicator.adjud_id");

        $adju_temp = $this->db->get();
        $adjus = array();

        foreach ($adju_temp->result() as $adju)
        {
          $adjus[] = $adju;
        }

        


        $message = "<table class='table table-striped table-condensed'>";

        $message .= "<tr>";
        $message .= "<th>Room</th>";
        $message .= "<th>OG</th>";
        $message .= "<th>OO</th>";
        $message .= "<th>CG</th>";
        $message .= "<th>CO</th>";
        $message .= "<th>Chair</th>";
        $message .= "<th>Panel</th>";
        $message .= "<th>Trainee</th>";
        $message .= "</tr>";

        foreach ($rooms->result() as $room)
        {
          $message.="<tr>";

          $message.="<td>$room->venue_name</td>";
          $message.="<td>".$teams[$room->og]->univ_code." ".$teams[$room->og]->team_code."</td>";
          $message.="<td>".$teams[$room->oo]->univ_code." ".$teams[$room->oo]->team_code."</td>";
          $message.="<td>".$teams[$room->cg]->univ_code." ".$teams[$room->cg]->team_code."</td>";
          $message.="<td>".$teams[$room->oo]->univ_code." ".$teams[$room->oo]->team_code."</td>";


          //var_dump($adjus);
          //die();

          $message.= "<td>";
            foreach($adjus as $adju)
            {
              if ($adju->debate_id == $room->debate_id && $adju->status=="chair")
              {
                $message.="$adju->adjud_name <br/>";
              }
            }
  
          $message.= "</td>";

          $message.= "<td>";
            foreach($adjus as $adju)
            {
              if ($adju->debate_id == $room->debate_id && $adju->status=="panelist")
              {
                $message.="$adju->adjud_name <hr/>";
              }
            }
  
          $message.= "</td>";

          $message.= "<td>";
            foreach($adjus as $adju)
            {
              if ($adju->debate_id == $room->debate_id && $adju->status=="trainee")
              {
                $message.="$adju->adjud_name <hr/>";
              }
            }
  
          $message.= "</td>";

          $message.="</tr>";
        }

        $message .= "</table>";

        $message .= "<script type='text/javascript'>";

        $message .= "$('html, body').animate({ scrollTop: $(document).height()-500 }, 20000);";
        $message .= "$(window).scroll(function() {
                       if($(window).scrollTop() + $(window).height() == $(document).height()) {
                          $('html, body').animate({ scrollTop: 0 }, 20000);
                       }
                       if($(window).scrollTop()  == 0) {
                           $('html, body').animate({ scrollTop: $(document).height()-500}, 20000);
                       }
                    });";
        $message .= "</script>";


    }

    echo $message;
    //var_dump($params);
    //die();

    //echo "<script type='text/javascript'>alert ('hello');</script>";
  }

  
  private function loadParam()
  {
    $params = array();
    $file_handle = fopen("application/param", "r");
    while (!feof($file_handle)) {
       $line = fgets($file_handle);
       $params[] = explode("|", $line);
    }
    fclose($file_handle);
    return $params;
  } 

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */