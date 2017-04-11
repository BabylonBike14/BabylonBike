<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller
{

	public function index()
	{
		$twig = $this->twig->getTwig();
		echo $twig->render('index.twig');

	}

	public function signIn()
	{
		if ($_POST)
		{
			$user = $this->UserModel->M_signIn();
			if ($this->input->post('pass') != $this->input->post('pass2'))
			{
				echo '<div class="alert alert-dismissible alert-warning">
				<p><strong>ERROR</strong> Diferentes!!!!...</p>
				</div>';
			}

			else
			{
				switch ($user['result'])
				{
					case 'did':

					echo '<div class="alert alert-dismissible alert-danger">
					<p><strong>ERROR</strong> Existe!!!!...</p>
					</div>';

						break;

						case 'didnt':

						// set the session of the user
						$this->session->id_user = $user['user']['id_user'];

						// info user
						$this->session->info_user = $user['user'];

						echo 1;
							break;

					default:

					echo '<div class="alert alert-dismissible alert-warning">
					<p><strong>ERROR</strong> Re-intentar!!!!...</p>
					</div>';

						break;
				}
			}
		}

		else
		{
			header('location:'. base_url());
		}
	}

	public function logIn()
	{
		if ($_POST)
		{
			$user = $this->UserModel->M_logIn();

			switch ($user['result'])
			{
				case 'did':

						// set the time of sesion
						ini_set('session.cookie_lifetime', time() + (60*60*24));

						// set the session of the user
						$this->session->id_user = $user['user']['id_user'];

						// info user
						$this->session->info_user = $user['user'];

						echo 1;

					break;

					case 'didnt':

								echo '<div class="alert alert-dismissible alert-danger">
								<p><strong>ERROR</strong> Incorrecto!!!!...</p>
								</div>';

						break;

				default:

							echo '<div class="alert alert-dismissible alert-warning">
							<p><strong>ERROR</strong> Re-intentar!!!!...</p>
							</div>';

					break;
			}
		}

		else
		{
			header('location:'. base_url());
		}
	}

	public function logOut()
	{
			//destroy session
			session_destroy();

			//unset the data
			$this->session->unset_userdata('id_user');
			$this->session->unset_userdata('info_user');

			//re-direct to index
			header('location:'. base_url());
	}

	public function profile()
	{
		if (isset($_SESSION['id_user']))
		{
			$twig = $this->twig->getTwig();
			echo $twig->render('User.twig');
		}

		else
		{
			header('location:'. base_url());
		}
	}

	public function search()
	{
		$search = $this->UserModel->searchThing();
		$twig = $this->twig->getTwig();
		echo $twig->render('search.twig', compact('search'));
	}
	public function adInfo()
	{
		$search = $this->UserModel->searchThing();
		$comments = $this->UserModel->getComments();
		$twig = $this->twig->getTwig();
		echo $twig->render('memeInfo.twig', compact('search', 'comments'));
	}

	public function comment()
	{
		if ($_POST)
		{
			$this->UserModel->comment();
			echo '<div class="alert alert-dismissible alert-success">
			<p><strong>ERROR</strong> Comentado!!!!...</p>
			</div>';
		}
	}
}
