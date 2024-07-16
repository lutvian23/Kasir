<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends BaseController
{
    protected $product;
    public function __construct()
    {
        $this->product = new ProductModel();
        
    }
    public function index()
    {
        $data = $this->product->findAll();
        return response()->setJSON($data);
    }

    public function store() {
        $validation = \config\Services::validation();
        try {

            $validate = $this->validate([
                "name_product" => [
                    "rules" => 'required',
                    'errors' => [
                        "required" => "Nama tidak boleh kosong"
                    ]
                ],
                "category_product" => [
                    "rules" => 'required',
                    'errors' => [
                        'required' => 'Kategori tidak boleh kosong'
                    ]
                ],
                "price_product" => [
                    "rules" => 'required',
                    "errors" => [
                        'required' => 'Cantumkan Harga'
                    ]
                ]
            ]); 
            if(!$validate) {
                $errors = $validation->getErrors();
                return response()->setJSON(["error" => $errors]);
            }
            $data = $this->request->getRawInput();
            $this->product->save($data);
            return response()->setJSON(["success" => "data berhasil di tambahkan"],200);
        }catch(\Exception $e) {
            return response()->setJSON(["error" => "handling error:".$e->getMessage()],500);
        }    
    }
}