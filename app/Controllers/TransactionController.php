<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DetailTransactionModel;
use App\Models\ProductModel;
use App\Models\TransactionModel;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;

class TransactionController extends BaseController
{
    protected $product;
    protected $transaction;
    protected $detail_transaction;
    
    public function __construct()
    {
        $this->product = new ProductModel();
        $this->transaction = new TransactionModel();
        $this->detail_transaction = new DetailTransactionModel();
    }
    public function index()
    {
        date_default_timezone_set("Asia/Jakarta");
        $format = date("ydHism") + 0;

        return response()->setJSON(["success" => $format]);

    }


    public function store_transaction() {
        try{
            $this->transaction->save([
                "id_transaction" => $this->request->getPost("id_transaction"),
                "dates" => (new DateTime())->format('Y-m-d H:i:s'),
                "total" => $this->request->getPost("total"),
                "payment_type" => $this->request->getPost("payment_type")
            ]);
            return response()->setJSON(["success" => "data berhasil ditambahkan"],200);
        }catch(\Exception $e) {
            return response()->setJSON(["error" => "handling error:".$e->getMessage()]);
        }
    }

    public function store_detail_transaction() {
        try {
            $this->detail_transaction->save([
                "id_product" => $this->request->getPost("id_product"),
                "name_product" => $this->request->getPost("name_product"),
                "qty" => $this->request->getPost("qty"),
                "sub_total" => $this->request->getPost("sub_total"),
                "id_transaction" => $this->request->getPost("id_transaction")
            ]);
            return response()->setJSON(["success" => "data berhasil ditambahkan"],200);
        }catch(\Exception $e) {
            return response()->setJSON(["error" => "handling error:".$e->getMessage()]);
        }
    }
}