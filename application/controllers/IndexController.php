<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IndexController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$twig = $this->twig->getTwig();
    echo $twig->render('index.twig');
	}

	public function aboutUS()
	{
		$twig = $this->twig->getTwig();
    echo $twig->render('aboutUs.twig');
	}

	public function Categories()
	{
		$twig = $this->twig->getTwig();
    echo $twig->render('categories.twig');
	}
}
