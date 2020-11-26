<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Categorymodel;

class Category extends ResourceController
{

    protected $modelName = 'App\Models\Categorymodel';
    protected $format = 'json';

    public function __construct()
    {
        //load model
        $this->category = New Categorymodel();
        //load config validasi
        $this->validation = \Config\Services::validation();
    }

    //get semua
    public function index()
    {
        $get = $this->category->getUser();
        return $this->respond($get, 200);
    }

    // get dengan atribute
    public function show($name = NULL)
    {
        $name = $this->request->getGet('name');
        $shw = $this->category->getUser($name);

        if($shw)
        {
            return $this->respond($shw, 200);
        } else {
            $msg = [
                'status' => 400,
                'message'=> 'no data found',
                'data' => $name
            ];
            return $this->respond($msg, 400);
        }
        
    }

    // delete data
    public function delete($name = null)
    {
        if($name)
        {
            //check dulu ada ato ngga
            $check = $this->category->checkUser($name);

            // kalo di check lebih dari 0, (1 pastinya), lakukan
            if($check > 0)
            {
                $id = md5($name);
                $delete = $this->category->deleteUser($id);
                if($delete == true)
                {
                // kalo berhasil delete
                    $msg = [
                        'status' => 200,
                        'message'=> 'Delete '.$name.' success'
                    ];
                    return $this->respond( $msg , 200 );

                // kalo gagal delete
                } else {
                    $msg = [
                        'status' => 400,
                        'message'=> 'Delete '.$name.' failed',
                        'detail' => 'Please consult administrator'
                    ];
                    return $this->respond( $msg , 400 );
                }
            // kalo di check kurang dari 0 / tidak ada
            } else {
                $msg = [
                    'status' => 400,
                    'message'=> 'Delete '.$name.' failed',
                    'detail' => 'No User Named '.$name
                ];
                return $this->respond( $msg , 400 );
            }
        }
    }

    //edit data (ntah harus ada parameter nya di function nya, tapi ga pernah gw pake)
    public function update($name = null){
            // ambil data dari PUT untuk send nya pastiin formatnya db nya bener !!
            $data = $this->request->getRawInput();

            //load validasi di config/validation
            $val = $this->validation->run($data, 'update_user');
            
            //cek validasi
            $errors = $this->validation->getErrors();
            if($errors){
                return $this->fail($errors);
            }

            $id = md5($name);
            $upd8 = $this->category->editUser($data, $id);
                
                if(!empty($upd8))
                {
                    $message = [
                        'status' => 200,
                        'message'=> 'suksess update data',
                        'row update' => $upd8
                    ];
                    return $this->respond($message,200);
                } else {
                    $message = [
                        'status' => 400,
                        'message'=> 'gagal update data',
                        'row update' => $upd8,
                        'test' => $name1
                    ];
                    return $this->respond($message, 400);
                }

        // }
    }

    //tambah data
    public function create()
    {
        //tangkep data
        $usrid = md5($this->request->getPost('name'));
        $usrname = $this->request->getPost('name');
        $usrpass = password_hash($this->request->getPost('pass'), PASSWORD_BCRYPT);
        $usraddr = $this->request->getPost('addr');
        $usremail = $this->request->getPost('email');
        $usrstatus = 1;

        // $password_hash = password_hash($password, PASSWORD_BCRYPT);
        
        $data = [
            'usrid' => $usrid,
            'usrname' => $usrname,
            'usrpass' => $usrpass,
            'usraddr' => $usraddr,
            'usremail' => $usremail,
            'usrstatus' => $usrstatus,
        ];

        //load validasi di config/validation
        $val = $this->validation->run($data, 'register');
        
        //cek validasi
        if (!$val) {

            $message = [
                'status' => 400,
                'message' => $this->validation->getErrors()
            ];
            return $this->respond($message,400);

        } else {
        
            $check = $this->category->checkUser($usrname);
            
            //check username ga ada di database
            if($check < 1){
                $cr8 = $this->category->insertUser($data);
                
                if($cr8 == true)
                {
                    $message = [
                        'status' => 200,
                        'message'=> 'suksess input data',
                    ];
                    return $this->respond($message,200);
                } else {
                    $message = [
                        'status' => 400,
                        'message'=> 'gagal input data',
                    ];
                    return $this->respond($message, 400);
                }

            //check kalo username ada di database
            } else {
                $message = [
                    'status' => 400,
                    'message'=> "User ".$usrname." sudah ada",
                ];
                return $this->respond($message, 400);
            }
        }
    }

}