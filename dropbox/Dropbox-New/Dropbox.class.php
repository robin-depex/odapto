<?php
session_start();

/**
 * Dropbox API
 *
 * This is a simple PHP plaintext OAuth 1.0 API for Dropbox
 * 
 * @author Sean Thomas Burke <http://www.seantburke.com/>
 */

class Dropbox
{
	//app variables, be sure to set these to your app settings before continuing.
	//they can be found at https://www.dropbox.com/developers/apps
	private static $APP_KEY 		= 'pn89jgplnlxfqbh';
	private static $APP_SECRET		= '0stu1wmkb5nimer';
	private static $CALLBACK_URL 		= 'https://www.odapto.com/dropbox/Dropbox-New/example.php';
	
	//OAuth 1.0 variables
	private $request_token_url;		//url to dropbox.com to get authorization
	private $oauth_token_secret;		//reponse secret from initial request
	private $oauth_request_token;		//initial response token
	private $oauth_access_token;		//store this in your database
	private $oauth_signature;		//store this in your database, they need to be used in every API call
	private $uid;				//the uid returned as $_GET['uid']
	
	/**
	 * Dropbox() 
	 * creates the object and decides based on the $_SESSION whether to request() or processCallBack()
	 *
	 * @author 	Sean Thomas Burke <http://www.seantburke.com/>
	 */
	public function __construct()
	{	
		//store session variables from a request()
		//this won't do anything until the processCallBack() method is called after the request()
		$this->oauth_token_secret 	= $_SESSION['oauth_token_secret'];
		$this->oauth_request_token 	= $_SESSION['oauth_request_token'];
		$this->oauth_access_token 	= $_SESSION['oauth_access_token'];
		$this->oauth_signature 		= $_SESSION['oauth_signature'];
		$this->uid 			= $_SESSION['uid'];		
			 
		//if the required variables are not set, then decide whether to make a request or process the $_SESSION
		if(!$this->oauth_signature || !$this->oauth_access_token)
		{
			//if the following are not set, then a request needs to be made
			//the fallback decision should be to request for a new token, and not to process the callback method
			if($_GET['uid'] && $_GET['oauth_token'] && $this->oauth_token_secret && $this->oauth_request_token)
			{
				$this->processCallBack();
			}
			else
			{
				$this->request();
			}
		}
	}
	
	/**
	 * request() 
	 *
	 * sends a request to get OAuth request token and secret, builds the request_token_url
	 * Step 1: call for request
	 * @link https://www.dropbox.com/developers/reference/api#request-token
	 * @link https://www.dropbox.com/developers/reference/api#authorize
	 * @author 	Sean Thomas Burke <http://www.seantburke.com/>
	 */
	private function request()
	{
		// initiate a cURL; if you don't know what curl is, look it up at http://curl.haxx.se/
		$ch = curl_init(); 
		//Dropbox uses plaintext OAuth 1.0; make the header for this request
		$headers = array('Authorization: OAuth oauth_version="1.0", oauth_signature_method="PLAINTEXT", oauth_consumer_key="'.self::$APP_KEY.'", oauth_signature="'.self::$APP_SECRET.'&"');  
		// set cURL options and execute
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  
		curl_setopt($ch, CURLOPT_URL, "https://api.dropbox.com/1/oauth/request_token");  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
		$request_token_response = curl_exec($ch);
		
		//	parse the returned data which has the format:
		// "oauth_token=<access-token>&oauth_token_secret=<access-token-secret>"
		parse_str($request_token_response, $parsed_request_token);
		
		//check for any errors
		$json_access = json_decode($request_token_response);
		if($json_access->error)
		{
			echo '<br><br>FATAL ERROR: '.$json_access->error.'<br><br>';
		}
		
		//set these variables in a $_SESSION variable
		$_SESSION['oauth_token_secret'] 	= $parsed_request_token['oauth_token_secret'];
		$_SESSION['oauth_request_token'] 	= $parsed_request_token['oauth_token'];
		
		//also store them in the object (unnecessary, but helps understand concept)
		$this->oauth_token_secret 		= $parsed_request_token['oauth_token_secret'];
		$this->oauth_request_token 		= $parsed_request_token['oauth_token'];
		
		//get the request URL; this is where you send the user to authorize your request. Be sure to set the CALLBACK_URL before doing this.
		$this->request_token_url = 'https://www.dropbox.com/1/oauth/authorize?oauth_token='.$parsed_request_token['oauth_token'].'&oauth_callback='.self::$CALLBACK_URL;	
		
	}
	
	/**
	 * processCallBack() 
	 * 
	 * call this function when the user returns from the request_token_url at dropbox.com 
	 * Step 2: Process Request and get Signature and Access Token
	 * @link	https://www.dropbox.com/developers/reference/api#request-token
	 * @author 	Sean Thomas Burke <http://www.seantburke.com>
	 */
	private function processCallBack()
	{
		//Now we must process the request 
		//same steps as before, but now the header is modified to include the response variables that were stored in the session
		//notice the signature is a concatenation of the app_secret and the token_secret
		$ch = curl_init();  
		$headers = array('Authorization: OAuth oauth_version="1.0", oauth_signature_method="PLAINTEXT", oauth_consumer_key="'.self::$APP_KEY.'", oauth_token="'.$this->oauth_request_token.'", oauth_signature="'.self::$APP_SECRET.'&'.$this->oauth_token_secret.'"');  
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  
		curl_setopt($ch, CURLOPT_URL, "https://api.dropbox.com/1/oauth/access_token");  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
		
		//execute and parse
		$access_token_response = curl_exec($ch);  
		parse_str($access_token_response, $parsed_access_token);
		
		//check for errors
		$json_access = json_decode($access_token_response);
		if($json_access->error)
		{
			echo '<br><br>FATAL ERROR: '.$json_access->error.'<br><br>';
		}
		
		//it is unnecessary to keep the oauth_token_secret and oauth_request_token at this point
		//clear the $_SESSION
		session_unset();
		
		//store oauth_access_token and oauth_signature responses in $_SESSION
		//again, oauth_signature is a concatenation of the APP_SECRET and the oauth_token_secret response
		//these 2 variables are what you need to make API requests
		$_SESSION['oauth_access_token'] 	= $parsed_access_token['oauth_token'];
		$_SESSION['oauth_signature'] 		= self::$APP_SECRET.'&'.$parsed_access_token['oauth_token_secret'];	
		
		//dropbox also gives you uid, store it
		$_SESSION['uid'] 			= $_GET['uid'];
		
		//also store variables in the object for future reference
		$this->oauth_access_token 		= $parsed_access_token['oauth_token'];
		$this->oauth_signature 			= self::$APP_SECRET.'&'.$parsed_access_token['oauth_token_secret'];	
		$this->uid		 		= $_GET['uid'];
	}
	
	/**
	 * get($url)
	 *
	 * Using the REST api, make a call to a REST URL, and it will return the array
	 * Step 3: Make an API call
	 *
	 * @link 	https://www.dropbox.com/developers/reference/api	
	 * @author 	Sean Thomas Burke <http://www.seantburke.com>
	 *
	 * @param 	$url	REST URL		
	 * @return 	array	decoded from JSON response
	 */
	function get($url)
	{
		$ch = curl_init(); 
		$headers = array('Authorization: OAuth oauth_version="1.0", oauth_signature_method="PLAINTEXT", oauth_consumer_key="'.self::$APP_KEY.'", oauth_token="'.$this->oauth_access_token.'", oauth_signature="'.$this->oauth_signature.'"');  
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  
		curl_setopt($ch, CURLOPT_URL, $url);  
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$api_response = curl_exec($ch);
		return $api_response;
	}
	
	/**
	 * call($url)
	 *
	 * Using the REST api, make a call to a REST URL, and it will return the array
	 * Step 3: Make an API call
	 *
	 * @link 	https://www.dropbox.com/developers/reference/api	
	 * @author 	Sean Thomas Burke <http://www.seantburke.com>
	 *
	 * @param 	$url	REST URL		
	 * @return 	array	decoded from JSON response
	 */
	function put($url)
	{
		$ch = curl_init(); 
		$headers = array('Authorization: OAuth oauth_version="1.0", oauth_signature_method="PLAINTEXT", oauth_consumer_key="'.self::$APP_KEY.'", oauth_token="'.$this->oauth_access_token.'", oauth_signature="'.$this->oauth_signature.'"');  
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  
		curl_setopt($ch, CURLOPT_URL, $url);  
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$api_response = curl_exec($ch);
		return json_decode($api_response);
	}
	
	
	/**
	 * getAccessURL() 
	 * returns the URL used for requests
	 * @link	https://www.dropbox.com/developers/reference/api#authorize
	 * @author 	Sean Thomas Burke <http://www.seantburke.com>
	 *
	 * @return 	string of URL for requesting OAuth Token
	 */
	function getAccessURL()
	{
		//get the Request URL
		return $this->request_token_url;
	}
	
	/**
	 * hasAccess() 
	 * check to see if the user has access already
	 *
	 * @author 	Sean Thomas Burke <http://www.seantburke.com>
	 * @return 	boolean of 3 required variables (uid is not required, but it helps)
	 */
	function hasAccess()
	{
		return ($this->oauth_access_token && $this->oauth_signature && $this->uid);
	}
	
	
	/**
	 * getFile()
	 * get a file from the dropbox
	 * @link 	https://www.dropbox.com/developers/reference/api#files-GET
	 * @author 	Sean Thomas Burke <http://www.seantburke.com>
	 *
	 * @param	$root {sandbox, dropbox} $path {url path to document}
	 * @return 	files contents
	 */
	function getFile($root, $path)
	{
		return $this->get('https://api-content.dropbox.com/1/files/'.$root.'/'.$path);
	}
	
	/**
	 * putFile 
	 * get a file from the dropbox
	 * @link 	https://www.dropbox.com/developers/reference/api#files-GET
	 * @author 	Sean Thomas Burke <http://www.seantburke.com>
	 *
	 * @param	$root {sandbox, dropbox} $path {url path to document}
	 * @return 	boolean of 3 required variables (uid is not required, but it helps)
	 */
	function putFile($root,$path)
	{
		//TODO still needs implementation
		return $this->put('https://api-content.dropbox.com/1/files_put/'.$root.'/'.$path.'?param=val');
	}


	/**
	 * test() 
	 * test the dropbox upload function
	 * @link 	https://www.dropbox.com/developers/reference/api#files-GET
	 * @author 	Sean Thomas Burke <http://www.seantburke.com>
	 *
	 * @param	$root either "sandbox" or "dropbox" $path {url path to document}
	 * @return 	boolean of 3 required variables (uid is not required, but it helps)
	 */
	function test($root)
	{
		$url = 'https://api-content.dropbox.com/1/files_put/'.$root.'/test2.txt?overwrite=true&locale=en';
		$body = file_get_contents('test.txt');
		//echo "file_contents: ".$body;
		$fp = fopen('php://temp/maxmemory:256000', 'w');
		if (!$fp) {
		    die('could not open temp memory data');
		}
		fwrite($fp, $body);
		fseek($fp, 0); 
		
		$ch = curl_init(); 
		$headers = array('Authorization: OAuth oauth_version="1.0", oauth_signature_method="PLAINTEXT", oauth_consumer_key="'.self::$APP_KEY.'", oauth_token="'.$this->oauth_access_token.'", oauth_signature="'.$this->oauth_signature.'"');  
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
		//echo '<a href="'.$url.'">'.$url.'</a>';
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_INFILE, $fp); // file pointer
		curl_setopt($ch, CURLOPT_INFILESIZE, strlen($body));  
		
		return $api_response = curl_exec($ch);
	}

}
