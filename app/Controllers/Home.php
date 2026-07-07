<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Home extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        helper(['number', 'form']);
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $products = $this->productModel->findAll();

        $discount = session()->get('discount');
        $nominalDiscount = 0;

        if (!empty($discount)) {
            $nominalDiscount = (int) $discount['nominal'];
        }

        foreach ($products as $key => $product) {
            $hargaAsli = (int) $product['harga'];
            $hargaDiskon = $hargaAsli - $nominalDiscount;

            if ($hargaDiskon < 0) {
                $hargaDiskon = 0;
            }

            $products[$key]['harga_asli'] = $hargaAsli;
            $products[$key]['harga_diskon'] = $hargaDiskon;
        }

        $data = [
            'products' => $products,
            'discount' => $discount,
            'nominalDiscount' => $nominalDiscount,
        ];

        return view('v_home', $data);
    }

    public function faq(): string
    {
        return view('v_faq');
    }
}