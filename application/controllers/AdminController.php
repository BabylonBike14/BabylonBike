<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		 $twig = $this->twig->getTwig();
    echo $twig->render('adminPanel.twig');
	}

	public function deleteUser()
	{
		if ($_POST)
		{
			$this->AdminModel->deleteUser();
		}
	}

	public function deleteAd()
	{
		if ($_POST)
		{
			$this->AdminModel->deleteAd();
		}

	}

	public function Categories()
	{
		 $twig = $this->twig->getTwig();
    echo $twig->render('categories.twig');
	}

  public function getTotalUsers()
  {

  }
}
