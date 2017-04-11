<?php

/**
 *
 */
class UserModel extends CI_Model
{

  function __construct()
  {
    $this->load->database();
  }

  public function M_signIn()
  {
    $sql = "SELECT * FROM users WHERE (user = ? OR email = ?)";
    $query = $this->db->query($sql, array
    (
      $this->input->post('UserName'), $this->input->post('email') )
    );

    $row = $query->row_array(1);

      if (isset($row))
        {
          return array('result' => 'did' );
        }

      else
        {
          $data = array
          (
            'email' => $this->input->post('email'), 'user' => $this->input->post('UserName'),
            'pass' => $this->ownencrypt->Encrypt($this->input->post('pass'))
          );

          $this->db->insert('users', $data);
          $data['id_user'] = $this->db->insert_id();
          return array('result' => 'didnt', 'user' => $data );
        }
  }

  public function M_logIn()
  {
    $sql = "SELECT * FROM users WHERE (user = ? OR email = ?) AND pass = ?";
    $query = $this->db->query
    (
      $sql, array($this->input->post('UserName'), $this->input->post('UserName'),
      $this->ownencrypt->Encrypt($this->input->post('pass')) )
  );

    $row = $query->row_array(1);

      if (isset($row))
        {
          return array('result' => 'did', 'user' => $row );
        }

      else
        {
          return array('result' => 'didnt' );
        }
    }

  public function deleteUser()
  {
    # code...
  }

  public function updateUser()
  {
    # code...
  }

  public function getLastId()
  {
    $query = $this->db->query("SELECT MAX(id_meme) + 1 FROM memes AS lastId;");
    return $query->row_array();
  }

  public function searchThing()
  {

    $this->db->select('memes.id_meme, memes.title, memes.category, memes.likeMeme, memes.dislikeMeme, memes.create_At, images.img_id, images.url');
    $this->db->from('memes');
    $this->db->join('images', 'memes.id_meme = images.id_meme');
    $this->db->like('title', $this->input->post('data'));
    $this->db->order_by('memes.create_At', 'DESC');
    $query = $this->db->get();
    return $query->result();

  }

  public function getComments()
  {
    $this->db->select('comments.comment,  comments.create_At, comments.id_user,comments.id_comment AS comment_id, memes.id_meme, users.user');
    $this->db->from('comments');
    $this->db->join('memes', 'comments.id_meme = '.$this->input->post('id_meme'));
    $this->db->join('users', 'comments.id_user = users.id_user');
    $this->db->order_by('comments.create_At', 'DESC');
    $query = $this->db->get();
    return $query->result();


  }

  public function comment()
  {
    $data = array
    (
      'id_user' => $this->session->id_user,
      'id_meme' => $this->input->post('id_meme'),
      'comment' => $this->input->post('comment')
     );
    $this->db->insert('comments', $data);
  }

  public function getUsers()
  {
    return $this->db->select('*')->from('users')->get()->result();
  }
}
?>
