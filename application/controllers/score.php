<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Score extends CI_Controller {

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
  public function login()
  {
    $data['title'] = "Login Page";
    $this->load->view('header', $data);
    $this->load->view('login');
    $this->load->view('footer');
  }

  public function process()
  {
    //var_dump($_REQUEST);

    $users = $this->loadPasswd();

    foreach ($users as $user)
    {

      if ( trim($user[1]) == trim($_POST["password"]) && trim($user[0]) == trim($_POST["username"]) )
      {

        redirect('home','refresh');
      }

    }

    //no recognized user
    redirect('login','refresh');
  }

  public function logout()
  {
    $this->session->sess_destroy();
  }



  public function index()
  {
    for ($i = 1 ; $i <= 10 ; $i++ )
    {
      if ($this->db->table_exists("temp_speaker_round_$i"))
      {
         
        $this->db->select('*');
        $this->db->from("draw_round_$i");
        $this->db->join("venue", "venue.venue_id = draw_round_$i.venue_id");
        $this->db->join("temp_result_round_$i", "draw_round_$i.debate_id = temp_result_round_$i.debate_id");

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


        $data['title'] = "Round $i";
        $data['rooms'] = $rooms;
        $data['round'] = $i;
        $data['teams'] = $teams;


        //var_dump( $teams[22] );
        //var_dump($teams);
        //die();

        $this->load->view('header', $data);
        $this->load->view('index_room',$data);
        $this->load->view('footer');

        
        //exit the loop looking for active round
        break;
      }
    }
  }

  public function room_detail($debate_id, $round)
  {
    $this->db->select('*');
    $this->db->from("draw_round_$round");
    $this->db->where("debate_id",$debate_id);
    $this->db->join("venue", "venue.venue_id = draw_round_$round.venue_id");
    $match = $this->db->get();

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
    $this->db->from("speaker");
    $this->db->join("team", "team.team_id = speaker.team_id");

    $speakers_temp = $this->db->get();
    $speakers = array();
    foreach($speakers_temp->result() as $speaker )
    {
      $speakers[$speaker->speaker_id] = $speaker;
    }

    $this->db->select('*');
    $this->db->from("temp_speaker_round_$round");
    $this->db->where("debate_id",$debate_id);
    
    $temp_speakers_temp =  $this->db->get();

    $temp_speakers = array();
    foreach ($temp_speakers_temp->result() as $temp_speaker)
    {
      $temp_speakers[$temp_speaker->speaker_id] = $temp_speaker;
    }
    //var_dump($temp_speakers);
    //die();
    $data['title'] = "Round $round";
    $data['debate_id']=  $debate_id;
    $data['round'] = $round;
    $data['teams'] = $teams;
    $data['speakers'] = $speakers;
    $data['temp_speakers'] =  $temp_speakers;
    $data['match'] = $match->result();
    $data['match'] = $data['match'][0];

    $this->load->view('header', $data);
    $this->load->view('room_detail',$data);
    $this->load->view('footer');
    //var_dump($speakers);
    //die();
  }


  public function process_input($debate_id, $round)
  {
    $teams = array();

    foreach ($_POST as $key => $value) {
      
      $code= array();
      $code = explode("_", $key);
      if ($code[0]=="code")
      {
        $teams[$code[1]] = array(0, $value);
      }

      if ($code[0]=="og" ||$code[0]=="oo"||$code[0]=="cg"||$code[0]=="co" )
      {
        $data=array('points'=>$value);
        
        if ($code[0] == "og")
          $teams["og"][0] += $value;
        if ($code[0] == "oo")
          $teams["oo"][0] += $value;
        if ($code[0] == "cg")
          $teams["cg"][0] += $value;
        if ($code[0] == "co")
          $teams["co"][0] += $value;

        $this->db->where('speaker_id',$code[1]);
        $this->db->update("temp_speaker_round_$round",$data);
      }

    }

    //if ($teams["og"][0])

    $scores = array();
    $first = null;
    $second = null;
    $third = null;
    $fourth = null;

    foreach($teams as $team)
    {
      $scores[] = $team[0];
    }
    sort($scores);
    
    $rank = 4;
    foreach($scores as $score)
    {
      foreach($teams as $team)
      {
        if ($team[0] == $score )
        {
          if ( $rank == 4)
            $fourth = $team[1];
          if ( $rank == 3)
            $third = $team[1];
          if ( $rank == 2)
            $second = $team[1];
          if ( $rank == 1)
            $first = $team[1];

          $rank -= 1;
        }
      }
    }

    //echo $first." | ".$second." | ".$third." | ".$fourth;

    //var_dump($teams);
    //die();

    $data = array(
        'first' => $first,
        'second' => $second,
        'third' => $third,
        'fourth' => $fourth
      );

    $this->db->where('debate_id',$debate_id);
    $this->db->update("temp_result_round_$round",$data);

    redirect(base_url()."index.php/home", 'refresh');
  }




  private function loadPasswd()
  {
    $users = array();
    $file_handle = fopen("application/passwd", "r");
    while (!feof($file_handle)) {
       $line = fgets($file_handle);
       $users[] = explode(" ", $line);
    }
    fclose($file_handle);
    return $users;
  }


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */