<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('index');
    }

    public function product(): string
    {
        return view('/page/product');
    }

    public function transaction(): string
    {
        return view('/page/transaction');
    }
}