<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class PembelianController extends BaseController
{
    protected $transactionModel;
    protected $transactionDetailModel;

    public function __construct()
    {
        helper(['number', 'form']);
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
    }

    private function checkAdmin()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to(base_url('/'));
        }

        return null;
    }

    public function index()
    {
        $adminCheck = $this->checkAdmin();

        if ($adminCheck !== null) {
            return $adminCheck;
        }

        $transactions = $this->transactionModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $transactionIds = array_column($transactions, 'id');

        $products = $this->transactionDetailModel
            ->getProductsByTransactionIds($transactionIds);

        $data = [
            'transactions' => $transactions,
            'products'     => $products
        ];

        return view('pembelian/index', $data);
    }

    public function updateStatus($id)
    {
        $adminCheck = $this->checkAdmin();

        if ($adminCheck !== null) {
            return $adminCheck;
        }

        $transaction = $this->transactionModel->find($id);

        if (!$transaction) {
            return redirect()
                ->to(base_url('pembelian'))
                ->with('failed', 'Data pembelian tidak ditemukan');
        }

        $newStatus = ($transaction['status'] == 0) ? 1 : 0;

        $this->transactionModel->update($id, [
            'status' => $newStatus
        ]);

        return redirect()
            ->to(base_url('pembelian'))
            ->with('success', 'Status pembelian berhasil diubah');
    }
}