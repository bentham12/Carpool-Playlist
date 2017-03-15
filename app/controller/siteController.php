<?php
// Start the session
session_start();
?>

<?php

require '../vendor/autoload.php';

include_once '../global.php';
require 'vendor/autoload.php';

// get the identifier for the page we want to load
$action = $_GET['action'];

// instantiate a SiteController and route it
$pc = new SiteController();
$pc->route($action);
$session;


class SiteController {
	// route us to the appropriate class method for this action
	public function route($action) {
		switch($action) {
			case 'home':
				$this->home();
				break;

			case 'login':
				$this->login();
				break;

			case 'loginProcess':
				$this->loginProcess();
				break;

			case 'search':
				$this->search($_GET['term']);
				break;

			case 'selectlist':
				$this->selectlist($_GET['list']);
				break;

			// redirect to home page if all else fails
      default:
		header('Location: '.BASE_URL);
        exit();

		}

	}

  public function home() {
		$pageName = 'Home';

		$session = new SpotifyWebAPI\Session('440c0bbf7ed7432ba9dad860846feabd', 'b903d161500c40fca04251d615f04c03', BASE_URL."/home/");

		$api = new SpotifyWebAPI\SpotifyWebAPI();

		/*
		// Request a access token using the code from Spotify
		$session->requestAccessToken($_GET['code']);
		$accessToken = $session->getAccessToken();

		// Set the access token on the API wrapper
		$api->setAccessToken($accessToken);*/

		if (isset($_GET['code'])) {
			$session->requestAccessToken($_GET['code']);
			$api->setAccessToken($session->getAccessToken());
		} else {
			header('Location: ' . $session->getAuthorizeUrl(array(
				'scope' => array(
					'playlist-modify-private',
					'playlist-modify-public',
					'playlist-read-private',
				)
			)));
			die();
		}

		$playlists = $api->getMyPlaylists(array());
		foreach ($playlists->items as $playlist) {
			if ($playlist->collaborative) {
				$collabPlay[] = $playlist;
				if (!isset($_SESSION['plID']))
				{
					$_SESSION['plNAME'] = $playlist->name;
					$_SESSION['plID'] = $playlist->id;
					$_SESSION['plURL'] = $playlist->images[0]->url;
				}
			}
		}


		include_once SYSTEM_PATH.'/view/header.tpl';
		include_once SYSTEM_PATH.'/view/user_page.tpl';
  }

  public function selectlist($list) {
	  $_SESSION['plID'] = $list;
	  $session = new SpotifyWebAPI\Session('440c0bbf7ed7432ba9dad860846feabd', 'b903d161500c40fca04251d615f04c03', BASE_URL."/home/");

		$api = new SpotifyWebAPI\SpotifyWebAPI();

		/*
		// Request a access token using the code from Spotify
		$session->requestAccessToken($_GET['code']);
		$accessToken = $session->getAccessToken();

		// Set the access token on the API wrapper
		$api->setAccessToken($accessToken);*/

		if (isset($_GET['code'])) {
			$session->requestAccessToken($_GET['code']);
			$api->setAccessToken($session->getAccessToken());
		} else {
			header('Location: ' . $session->getAuthorizeUrl(array(
				'scope' => array(
					'playlist-modify-private',
					'playlist-modify-public',
					'playlist-read-private',
				)
			)));
			die();
		}

		$playlists = $api->getMyPlaylists(array());

		foreach ($playlists->items as $playlist) {
			if ($playlist->id == $list) {
				$current_pl = $playlist;
				break;
			}
		}

		$_SESSION['plNAME'] = $current_pl->name;
		$_SESSION['plURL'] = $current_pl->images[0]->url;

	  header('Location: '.BASE_URL.'/home/');
  }

  public function search($search_term)
  {
		$api = new SpotifyWebAPI\SpotifyWebAPI();
		$results = $api->search($search_term, 'track');

		foreach ($results->tracks->items as $track) {
			$track_listing[] = $track;
		}

		include_once SYSTEM_PATH.'/view/header.tpl';
		include_once SYSTEM_PATH.'/view/search_results.tpl';
  }

	public function login() {
		global $session;

		$pageName = "Login";
		// include_once SYSTEM_PATH.'/view/header.tpl';
		include_once SYSTEM_PATH.'/view/login.tpl';
		$session = new SpotifyWebAPI\Session('440c0bbf7ed7432ba9dad860846feabd', 'b903d161500c40fca04251d615f04c03', BASE_URL."/home/");

		$scopes = array(
			'playlist-read-private',
			'user-read-private',
			'playlist-read-collaborative'
		);
		$authorizeUrl = $session->getAuthorizeUrl(array(
			'scope' => $scopes
		));

		$_SESSION['user'] = "user";

		header('Location: ' . $authorizeUrl);

		die();
		// include_once SYSTEM_PATH.'/view/footer.tpl';
	}

	public function loginProcess() {
		global $session;
		global $accessToken;

		print_r($session);



		//header('Location: ' .BASE_URL."/home/");
	}
}
?>
