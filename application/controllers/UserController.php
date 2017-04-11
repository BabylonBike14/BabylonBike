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
			$this->session->unset_userdata('facebook_access_token');
			$this->session->unset_userdata('facebookUser');

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
			$r = $this->UserModel->comment();
			if ($r === 1)
			{
				echo '<div class="alert alert-dismissible alert-success">
				<p><strong>ERROR</strong> Comentado!!!!...</p>
				</div>';
			}
		}
	}

	public function searchProduct()
	{
		if ($_POST)
		{
			$results = $this->MemeModel->searchProduct();
			$this->session->results = $results;
		}

		else
		{
			header('location:'.base_url());
		}
	}

	public function searchBike()
	{
		if ($_POST)
		{
			$results = $this->MemeModel->searchBike();
			$this->session->results = $results;
		}

		else
		{
			header('location:'.base_url());
		}
	}

	public function loginfb()
	{
		 $fb = new Facebook\Facebook([
      		  'app_id' => '622649851272893',
      		  'app_secret' => '39921e09545e150008560a7e87ca078a',
      		  'default_graph_version' => 'v2.4',
      		  ]);
      		$helper = $fb->getRedirectLoginHelper();
      		$permissions = ['email']; // optional

      		try {
      			if (isset($_SESSION['facebook_access_token'])) {
      				$accessToken = $_SESSION['facebook_access_token'];
      			} else {
      		  		$accessToken = $helper->getAccessToken();
      			}
      		} catch(Facebook\Exceptions\FacebookResponseException $e) {
      		 	// When Graph returns an error
      		 	echo 'Graph returned an error: ' . $e->getMessage();
      		  	exit;
      		} catch(Facebook\Exceptions\FacebookSDKException $e) {
      		 	// When validation fails or other local issues
      			echo 'Facebook SDK returned an error: ' . $e->getMessage();
      		  	exit;
      		 }
      		if (isset($accessToken)) {
      			if (isset($_SESSION['facebook_access_token'])) {
      				$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
      			} else {
      				// getting short-lived access token
      				$_SESSION['facebook_access_token'] = (string) $accessToken;
      			  	// OAuth 2.0 client handler
      				$oAuth2Client = $fb->getOAuth2Client();
      				// Exchanges a short-lived access token for a long-lived one
      				$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
      				$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
      				// setting default access token to be used in script
      				$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
      			}
      			// redirect the user back to the same page if it has "code" GET variable
      			if (isset($_GET['code'])) {
      				header('Location: ./');
      			}
      			// getting basic info about user
      			try {
      				$profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
      				$profile = $profile_request->getGraphNode()->asArray();
      			} catch(Facebook\Exceptions\FacebookResponseException $e) {
      				// When Graph returns an error
      				echo 'Graph returned an error: ' . $e->getMessage();
      				session_destroy();
      				// redirecting user back to app login page
      				header("Location: ./");
      				exit;
      			} catch(Facebook\Exceptions\FacebookSDKException $e) {
      				// When validation fails or other local issues
      				echo 'Facebook SDK returned an error: ' . $e->getMessage();
      				exit;
      			}

      			// printing $profile array on the screen which holds the basic info about user
      				$_SESSION['facebookUser'] = $profile;
      		  	// Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']

header('location:'. base_url());
      		}



      		else

      		{
      			// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
      			$loginUrl = $helper->getLoginUrl('http://babylonbike.rf.gd/fb/', $permissions);


      		  echo '
                  <a id ="fb" href="' . $loginUrl . '">Login with Facebook</a>

            ';

						?>
						<script type="text/javascript">
							document.getElementById('fb').click();
							console.log(4);
								</script>
						<?php
      		}

	}
}
