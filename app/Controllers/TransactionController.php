<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;

class TransactionController extends BaseController
{
    protected $product;
    public function __construct()
    {
        $this->product = new ProductModel();
    }
    public function index()
    {
        
    }
}