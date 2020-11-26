<?php

namespace App\Controllers;

//panggil modelnya
use App\Models\Product_model;

class Product extends baseController
{
    public function __construct()
    {
        $this->product = new Product_model();
    }

    public function index()
    {
        $data['products'] = $this->product->get_product();
        return view('product/index', $data);
    }

    public function show($id = NULL)
    {
        if($id){
            $data['product'] = $this->product->get_product($id);
            return view('product/show', $data);
        } else {
            return redirect()->to('/product');
        }
    }

    public function update()
    {
        $name = $this->request->getPost('product_name');
        $desc = $this->request->getPost('product_description');
        $id = $this->request->getPost('product_id');
        
        $data = [
            'product_name' => $name,
            'product_description' => $desc
        ];

        $update = $this->product->put_product($data, $id);

        if($update)
        {
            session()->setFlashdata('success', 'update data sukses');
            return redirect()->to('/product');
        } else {
            session()->setFlashdata('error', 'update data failed');
            return redirect()->to('/product');
        }

    }

    public function delete($id = NULL)
    {
        // $id = $this->request->getpost('id');
        if($id){
            $hapus = $this->product->delete_product($id);
            if($hapus)
            {
                session()->setFlashdata('success', 'delete product success');
                return redirect()->to('/product');
            } else {
                session()->setFlashdata('error', 'delete product failed');
                return redirect()->to('/product');
            }
            return redirect()->to('/product');
        } else {
            return redirect()->to('/product');
        }
    }
    
    public function create()
    {
        return view('product/create');
    }

    public function store()
    {
        $name = $this->request->getPost('product_name');
        $desc = $this->request->getPost('product_description');

        $data = [
            'product_name' => $name,
            'product_description' => $desc,
        ];

        $simpan = $this->product->insert_product($data);

        if($simpan)
        {
            session()->setFlashdata('success', 'created product success');
            return redirect()->to('/product');
        } else {
            session()->setFlashdata('error', 'Created product failed');
            return redirect()->to('/product');
        }
    }
}