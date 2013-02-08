<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

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
    $this->load->view('footer_admin');
  }

  public function process()
  {
    //var_dump($_REQUEST);

    $users = $this->loadPasswd();

    foreach ($users as $user)
    {

      if ( trim($user[1]) == trim($_POST["password"]) && trim($user[0]) == trim($_POST["username"]) )
      {

        redirect('admin/dashboard','refresh');
      }

    }

    //no recognized user
    redirect( base_url().'index.php','refresh');
  }

  public function logout()
  {
    $this->session->sess_destroy();
  }


  public function dashboard()
  {
    $params = $this->loadParam();
    
    $data['round'] = $params[0][1];
    $data['state'] = $params[1][1];
    $data['motion']= $params[2][1];
    $data['message'] =$params[3][1];

    $data['title'] = "Admin Page";
    $this->load->view('header', $data);
    $this->load->view('dashboard',$data);
    $this->load->view('footer_admin');
  }

  public function save()
  {

    $fh = fopen("application/param", 'w');
    $stringData = "round|".$_POST['round']."\nstate|".$_POST['state']."\nmotion|".$_POST["motion"]."\nmessage|".$_POST["message"];
    fwrite($fh, $stringData);
    fclose($fh);
    redirect(base_url()."index.php/admin/dashboard", "refresh");
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

  private function loadPasswd()
  {
    $users = array();
    $file_handle = fopen("application/passwd", "r");
    while (!feof($file_handle)) {
       $line = fgets($file_handle);
       $users[] = explode("|", $line);
    }
    fclose($file_handle);
    return $users;
  }


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */