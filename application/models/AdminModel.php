<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminModel extends CI_Model
{

  function __construct()
  {
    $this->load->database();
  }

  public function CountUsers()
  {
    return $this->db->count_all('users');
  }

  public function CountAds()
  {
    return $this->db->count_all('memes');
  }

  public function deleteUser()
  {
    $this->db->delete('users', array('id_user' => $this->input->post('id_user') ));
  }
  public function deleteAd()
  {
    $this->db->delete('memes', array('id_meme' => $this->input->post('id_meme') ));
  }
}


?>
