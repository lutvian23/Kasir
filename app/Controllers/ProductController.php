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

    
    
    public function edit($id) {
        $data = $this->product->find($id);
        return response()->setJSON($data);
    }



    public function update($id) {
        
        $dataInput = $this->request->getRawInput();
        // return response()->setJSON(["success" => [$this->request->getPost("name_product_edit"),$this->request->getPost("category_product_edit"),$this->request->getPost("price_product_edit")]]);

        $validation = \config\Services::validation();
        try {

            $validate = $this->validate([
                "name_product_edit" => [
                    "rules" => 'required',
                    'errors' => [
                        "required" => "Nama tidak boleh kosong"
                    ]
                ],
                "category_product_edit" => [
                    "rules" => 'required',
                    'errors' => [
                        'required' => 'Kategori tidak boleh kosong'
                    ]
                ],
                "price_product_edit" => [
                    "rules" => 'required',
                    "errors" => [
                        'required' => 'Cantumkan Harga'
                    ]
                ]
            ]); 

            if(!$validate) {
                $errors = $validation->getErrors();
                return response()->setJSON(["error" => $errors],428);
            }else {
                $data = [
                    "name_product" => $dataInput["name_product_edit"],
                    "category_product" => $dataInput["category_product_edit"],
                    "price_product" => $dataInput["price_product_edit"]

                ];
    
                if($this->product->update($id,$data)) {
                    return response()->setJSON(["success" => "data berhasil di ubah","input" => $dataInput],200);
                }else {
                    return response()->setJSON(["error" => "terjadi kesalan"]);
                }
            }
            
        }catch(\Exception $e) {
            return response()->setJSON(["error" => $e->getMessage()],500);
        }
    }

    public function destroy($id) {
        $this->product->delete($id);
        return response()->setJSON(["Success" => "data Berhasil di hapus"],200);
    }
}