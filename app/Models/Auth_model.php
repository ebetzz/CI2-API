<?php

namespace App\Models;

use CodeIgniter\Model;

class Auth_model extends Model
{
    protected $table = "userdb";

    public function cek_login($name)
    {
        $query = $this->table($this->table)
                    ->where(['usrname' , $name])
                    ->countAll();
        if($query > 0)
        {
            $qry = $this->table($this->table)
            ->where('usrname', $name)
            ->limit(1)
            ->get()
            ->getRowArray();
            return $qry;
        } else {
            return false;
        }
    }
}