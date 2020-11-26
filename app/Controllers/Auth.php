<?php

namespace App\Controllers;

use \Firebase\JWT\JWT;
use App\Models\Auth_model;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
	public function __construct()
	{
		$this->auth = new Auth_model();
		// $this->load->helper('file');
	}

	public function login()
	{
		$privateKey = "sampahbangetiniprivatek3yny4b4ng54t33333!!";

		$publicKey = "iniadalah4askldmlkqwmelksmadlkmsalkdmalaksmd";
		

		$name = $this->request->getPost('name');
		$pass = $this->request->getPost('pass');

		$cek = $this->auth->cek_login($name);

		if(password_verify($pass, $cek['usrpass']))
		{
			// $secret_key = $this->privateKey();
			$secret_key = $privateKey;
			$issuer_claim = "THE_CLAIM";
			$audience_claim = "THE_AUDIENCE";
			$issuedat_claim = time();
			$notbefore_claim = $issuedat_claim + 10;
			$expire_claim = $issuedat_claim + 3600; //in second

			$token = [
				'iss' => $issuer_claim,
				'aud' => $audience_claim,
				'iat' => $issuedat_claim,
				'nbf' => $notbefore_claim,
				'exp' => $expire_claim,
				'data' => [
					'id' => $cek['usrid'],
					'name' => $cek['usrname'],
					'addr' => $cek['usraddr'],
					'pass' => $cek['usrpass'],
					'email' => $cek['usremail'],
				],
			];

			$token = JWT::encode($token, $secret_key);

			$output = [
				'status' => 200,
				'message' => 'Login successful',
				'token' => $token,
				'expireAt' => $expire_claim
			];
			return $this->respond($output, 200);

		} else {
			$output = [
				'status' => 401,
				'message' => 'Login Failed'
			];
			return $this->respond($output, 200);
		}
	}

	public function cek_login($email = null)
	{
		return view('welcome_message');
	}

}
