<?php

namespace App\Models;

use CodeIgniter\Model;

class Categorymodel extends Model
{
    //hardcode $table itu untuk penggunaan fungsi yang ada di model ini
    protected $table = "userdb";

    //ambil semua data
    public function getUser($name = null)
    {
        if($name){
            $query = $this->table($this->table)
            ->where('usrname', $name)
            ->get()
            ->getRowArray();
            return $query;
        } else {
            return $this->findAll();
        
        }

    }

    //check username ada atau tidak di db
    public function checkUser($name = null){
        
        if($name){
            $query = $this->table($this->table)->where('usrname', $name)->countAllResults();
            if($query > 0){
                return $query;
            }
        } else {
            return 0;
        }
    }

    //fungsi masukin ke db
    public function insertUser($data)
    {
        $query = $this->db->table($this->table)
        ->insert($data);

        if($query)
        {
            return true;
        } else {
            return false;
        }
    }

    //fungsi edit db
    public function editUser($data, $id = null){

        $query = $this->db->table($this->table)
        ->update($data, ['usrid' => $id]);
        
        // return rows yang di affect di db ada brapa banyak
        return $this->db->affectedRows();


    }

    //fungsi delete
    public function deleteUser( $id = null )
    {
        $query = $this->db->table($this->table)
        ->delete(['usrid' => $id]);
        if($query)
        {
            return true;
        } else {
            return false;
        }
    }

}