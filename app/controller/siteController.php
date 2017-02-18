<?php

require '../../vendor/autoload.php';

include_once '../global.php';

// get the identifier for the page we want to load
$action = $_GET['action'];

// instantiate a SiteController and route it
$pc = new SiteController();
$pc->route($action);

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

			// redirect to home page if all else fails
      default:
        header('Location: '.BASE_URL);
        exit();

		}

	}

  public function home() {
		session_start();
		/*if (isset($_SESSION['user'])){
			$pageName = 'Home';
			//include_once SYSTEM_PATH.'/view/header.tpl';
			include_once SYSTEM_PATH.'/view/user_page.tpl';
			//include_once SYSTEM_PATH.'/view/footer.tpl';
		} else {
			header("LOCATION: ".BASE_URL."/login/");
			exit();
		}*/
		$pageName = 'Home';
		//include_once SYSTEM_PATH.'/view/header.tpl';
		include_once SYSTEM_PATH.'/view/user_page.tpl';
		//include_once SYSTEM_PATH.'/view/footer.tpl';
  }

  /*public function items() {
    $pageName = 'Items Listing';

    $conn = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Error: Could not connect to database");
    mysql_select_db(DB_DATABASE);
    $q = 'SELECT * FROM parts';
    $result = mysql_query($q);
    include_once SYSTEM_PATH.'/view/header.tpl';
    include_once SYSTEM_PATH.'/view/itemlisting.tpl';
    include_once SYSTEM_PATH.'/view/footer.tpl';
  }

  public function sell() {
		session_start();
		if (isset($_SESSION['user'])){
			$pageName = 'Sell Item';

			include_once SYSTEM_PATH.'/view/header.tpl';
			include_once SYSTEM_PATH.'/view/sellitem.tpl';
			include_once SYSTEM_PATH.'/view/footer.tpl';
		} else {
			$this->login(); //since the user isn't logged in, we want to pull up the login page
			header("LOCATION: ".BASE_URL."/login//"); //sets appropriate url so .htaccess rules don't break
			exit();
		}

  }

  public function submission() {
      $pageName = 'Submitted Item';
			session_start();
			$username = $_SESSION['user']; //gets user name so it can be stored in DB
      $conn = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Error: Could not connect to database");
      mysql_select_db(DB_DATABASE);

      $product = new Product;
      $product->set('item_name', $_POST['item_name']);
      $product->set('current_price', $_POST['current_price']);
      $product->set('description', $_POST['description']);
			$product->set('seller_name', $username);

			//placeholder data
			$product->set('seller_rep', 155);
			$product->set('img_url', 'asusmobojpg.jpg');

      $product->save();
			$prod_name = $product->get('item_name');
      include_once SYSTEM_PATH.'/view/header.tpl';
      // include_once SYSTEM_PATH.'/view/successfulsub.tpl';
			echo "<br></br><br></br>";
		  echo "<h3 text-align=center>Successfully listed $prod_name for sale</h3>";
      include_once SYSTEM_PATH.'/view/footer.tpl';
  }

	public function processLogin($u, $p) {
		$username = "User1";
		$password = "pass";
		if (($u == $username) && ($p == $password)){
			session_start();
			$_SESSION['user'] = $u;
			header('Location: '.BASE_URL);
			exit();
		}
		else{
			header('Location: '.BASE_URL);
		}
	}*/

	public function login(){
		$pageName = "Login";
		// include_once SYSTEM_PATH.'/view/header.tpl';
		include_once SYSTEM_PATH.'/view/login.tpl';
		$session = new SpotifyWebAPI\Session('440c0bbf7ed7432ba9dad860846feabd', 'b903d161500c40fca04251d615f04c03', BASE_URL."/home/");
		
		$scopes = array(
			'playlist-read-private',
			'user-read-private'
		);
		$authorizeUrl = $session->getAuthorizeUrl(array(
			'scope' => $scopes
		));
		
		$_SESSION['user'] = "user";		
		
		header('Location: ' . $authorizeUrl);
		
		$api = new SpotifyWebAPI\SpotifyWebAPI();

		// Request a access token using the code from Spotify
		$session->requestAccessToken($_GET['code']);
		$accessToken = $session->getAccessToken();

		// Set the access token on the API wrapper
		$api->setAccessToken($accessToken);
		
		print_r($_SESSION['user']);
		die();
		// include_once SYSTEM_PATH.'/view/footer.tpl';
	}

	/*public function mysales(){
		session_start();
		if (isset($_SESSION['user'])){
			$pageName = "Current Sales";

			$conn = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Error: Could not connect to database");
	    mysql_select_db(DB_DATABASE);
			$user_id = $_SESSION['user']; //we are using username as a 'foreign key'
																		//since they should all be unique
			$q = "SELECT * FROM parts WHERE seller_name= '" . mysql_real_escape_string($user_id). "'";
	    $result = mysql_query($q);

			include_once SYSTEM_PATH.'/view/header.tpl';
			include_once SYSTEM_PATH.'/view/mysales.tpl';
			include_once SYSTEM_PATH.'/view/footer.tpl';
		}
		else {
			$this->login(); //since the user isn't logged in, we want to pull up the login page
			header("LOCATION: ".BASE_URL."/login//"); //sets appropriate url so .htaccess rules don't break
			exit();
		}
	}

	public function listitem($id){
		$pageName = 'Product';

		$conn = mysql_connect(DB_HOST, DB_USER, DB_PASS)
			or die ('Error: Could not connect to MySql database');
		mysql_select_db(DB_DATABASE);
		//only want to grab the item that matches the selcted ID
		$q = "SELECT * FROM parts WHERE ProductID= '" . mysql_real_escape_string($id). "'";
		$result = mysql_query($q);
		$product = new Product;
		session_start();
		$_SESSION['current_prod'] = $product;
		while($row = mysql_fetch_assoc($result)){
			$product->set('ProductID', $row['ProductID']);
			$product->set('item_name', $row['item_name']);
			$product->set('seller_name', $row['seller_name']);
			$product->set('seller_rep', $row['seller_rep']);
			$product->set('end_date', $row['end_date']);
			$product->set('current_price', $row['current_price']);
			$product->set('description', $row['description']);
			$product->set('img_url', $row['img_url']);
		}

		include_once SYSTEM_PATH.'/view/header.tpl';
		include_once SYSTEM_PATH.'/view/itemview.tpl';
		include_once SYSTEM_PATH.'/view/footer.tpl';
	}

	public function edititem() {
		$pageName = 'Edit Item';
		session_start();
		// Product that we want to edit was stored in $_SESSION from the itemview page
		$product = $_SESSION['current_prod'];

		include_once SYSTEM_PATH.'/view/header.tpl';
		include_once SYSTEM_PATH.'/view/itemedit.tpl';
		include_once SYSTEM_PATH.'/view/footer.tpl';
	}

	public function processEdit($item_name, $current_price, $end_date, $description){
		$pageName = 'Edit Complete';

		$conn = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Error: Could not connect to database");
		mysql_select_db(DB_DATABASE);

		session_start();
		$product = $_SESSION['current_prod']; //gets the product we are currently editting

		$product->set('item_name', $item_name);
		$product->set('current_price', $current_price);
		$product->set('end_date', $end_date);
		$product->set('description', $description);

		$product->save();

		include_once SYSTEM_PATH.'/view/header.tpl';
		echo "<br></br><br></br>";
		echo "<h3 text-align=center>Successfully edited $item_name</h3>";
		include_once SYSTEM_PATH.'/view/footer.tpl';
	}

	public function deleteitem() {
		$pageName = "Delete Item";

		session_start();
		// Product that we want to edit was stored in $_SESSION from the itemview page
		$product = $_SESSION['current_prod'];

		include_once SYSTEM_PATH.'/view/header.tpl';
		include_once SYSTEM_PATH.'/view/itemdelete.tpl';
		include_once SYSTEM_PATH.'/view/footer.tpl';
	}

	public function processDelete() {
		$pageName = 'Delete Complete';

		$conn = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Error: Could not connect to database");
		mysql_select_db(DB_DATABASE);

		session_start();
		$product = $_SESSION['current_prod'];
		$_SESSION['current_prod'] = null; //sets this to null since we won't need it anymore
		$query = sprintf(" DELETE FROM parts WHERE ProductID = %s", $product->get('ProductID'));
		$result = mysql_query($query);

		include_once SYSTEM_PATH.'/view/header.tpl';
		echo "<br></br><br></br>";
		echo "<h3 text-align=center>Successfully deleted item</h3>";
		include_once SYSTEM_PATH.'/view/footer.tpl';
	}*/
}
