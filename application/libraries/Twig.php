<?php

/**
 *
 */

defined('BASEPATH') OR exit('No direct script access allowed');
require realpath('vendor/autoload.php');

class Twig
{
  function __construct()
  {
  }

  private function Twig()
  {
    //load the path views
    $loader = new Twig_Loader_Filesystem(realpath('application/views/'));

    //settings
    $twig = new Twig_Environment($loader, array('debug' => true ));
    //add cache
    // , array(
    //   'cache' => realpath('application/cache/Twig'),
    // )

    //debug
    $twig->addExtension(new Twig_Extension_Debug());

    //CI instance
    $CI =& get_instance();

    //getMemes
    $memes = $CI->MemeModel->getAllMemes();
    //get number of users
    $numberUsers = $CI->AdminModel->CountUsers();
    //get number of ads posteds
    $numberAds = $CI->AdminModel->CountAds();
    //get users info_user
    $users = $CI->UserModel->getUsers();

    //global vars
    $twig->addGlobal('session', $_SESSION);
    $twig->addGlobal('url', 'http://localhost/Final/' );

    //info models
    $twig->addGlobal('memes', $memes);
    $twig->addGlobal('numberUsers', $numberUsers);
    $twig->addGlobal('numberAds', $numberAds);
    $twig->addGlobal('users', $users);

    return $twig;
  }

  public function getTwig()
  {

    return $this->Twig();

  }


}
