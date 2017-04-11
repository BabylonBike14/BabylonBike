<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MemeModel extends CI_Model
{

  function __construct()
  {
    $this->load->database();
  }

  public function newMeme($data)
  {
    $this->db->insert('memes', $data);

  }
  public function imgsMeme($data)
  {
    $this->db->insert('images', $data);

  }

  public function deleteMeme()
  {
    # code...
  }

  public function getAllMemes()
  {
    $this->db->select('memes.id_meme, memes.title, memes.category, memes.comment, memes.price, memes.model, memes.likeMeme, memes.dislikeMeme, memes.create_At, images.url');
    $this->db->from('memes');
    $this->db->join('images', 'memes.id_meme = images.id_meme');
    $this->db->order_by('memes.create_At', 'DESC');
    $query = $this->db->get();
    return $query->result();
  }
}


?>
