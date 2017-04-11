<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MemeController extends CI_Controller
{

  public function newMeme()
  {
    if ($_POST)
    {
      //meme id
      $r = $this->UserModel->getLastId();

      //images
      $files = $_FILES['files'];
      $fileCount = count($files['name']);

      for ($i = 0; $i < $fileCount; $i++)
      {
        //get the ext
        $ext = explode( 'image/',$files['type'][$i] );

        // Storing source path of the file in a variable
        $sourcePath = $files['tmp_name'];

        //target the path where the file is be stored
        $targetPath = './application/public/images/'.$r["MAX(id_meme) + 1"]."n".$i.".".$ext[1];

        //array info bd
        $dataIMG = array('url' => $targetPath, 'id_meme' => $r["MAX(id_meme) + 1"] );

        //inserting info bd
        $this->MemeModel->imgsMeme($dataIMG);

        //Moving Uploaded file
        move_uploaded_file($sourcePath[$i], $targetPath);

      }

      //array info bd
      $data = array('title' => $_POST['title'], 'category' => $_POST['category'], 'model' => $_POST['model'], 'price' => $_POST['price'], 'comment' => $_POST['comment']);

      //inserting info bd
      $this->MemeModel->newMeme($data);

      echo '<div class="alert alert-dismissible alert-success">
      <p><strong>ERROR</strong> publicado!!!!...</p>
      </div>';
    }
  }


}

?>
