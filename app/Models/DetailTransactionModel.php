<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailTransactionModel extends Model
{
    protected $table            = 'detail_transaction';
    protected $primaryKey       = 'id_detail_transaction';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_product','name_product','qty','sub_total','id_transaction'];

}