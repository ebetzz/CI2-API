<?php

namespace App\Controllers;

// Panggil JWT
use \Firebase\JWT\JWT;
// panggil class Auht
use App\Controllers\Auth;
// panggil restful api codeigniter 4
use CodeIgniter\RESTful\ResourceController;

//header
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-Width");
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-Width");

class Home extends ResourceController
{
	public function __constructor()
	{
		$this->protect = new Auth();
	}

	public function index()
	{
		
		$privateKey = "sampahbangetiniprivatek3yny4b4ng54t33333!!";

		$secret_key = $privateKey;
		// $secret_key = privateKey();

		$token = null;

		$authHeader = $this->request->getServer('HTTP_AUTHORIZATION');

		$arr = explode(" ", $authHeader);

		$token = $arr[1];

		if($token)
		{
			try{
				$decode = JWT::decode($token, $secret_key, array('HS256'));

				if($decode)
				{
					//return view('Welcome_message');
					//taro halaman akses jika benar
					//kelola something

					//ngasi tau akses grant
					$message = [
						'report' => 'masuk home loh',
						'status' => 200,
						'message' => 'access granted'
					];
					return $this->respond($message, 200);
				}
			 } catch(\Exception $err ) {
					$message = [
						'status' => 401,
						'message' => 'access denied',
						'error' => $err->getMessage()
					];
					return $this->respond($message, 401);
				}
		}
	}

}
