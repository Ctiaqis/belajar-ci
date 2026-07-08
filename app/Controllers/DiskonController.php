<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DiscountModel;

class DiskonController extends BaseController
{
    protected $discountModel;

    public function __construct()
    {
        helper(['form', 'number']);
        $this->discountModel = new DiscountModel();
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

        $discounts = $this->discountModel
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        return view('diskon/index', [
            'discounts' => $discounts
        ]);
    }

    public function create()
    {
        $adminCheck = $this->checkAdmin();

        if ($adminCheck !== null) {
            return $adminCheck;
        }

        $rules = [
            'tanggal' => 'required|valid_date|is_unique[discount.tanggal]',
            'nominal' => 'required|numeric'
        ];

        $messages = [
            'tanggal' => [
                'required' => 'Tanggal diskon wajib diisi.',
                'valid_date' => 'Format tanggal tidak valid.',
                'is_unique' => 'Tanggal diskon sudah tersedia.'
            ],
            'nominal' => [
                'required' => 'Nominal diskon wajib diisi.',
                'numeric' => 'Nominal diskon harus berupa angka.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()
                ->to(base_url('diskon'))
                ->withInput()
                ->with('failed', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'nominal' => $this->request->getPost('nominal')
        ];

        $this->discountModel->insert($data);

        return redirect()->to(base_url('diskon'))->with('success', 'Data diskon berhasil ditambahkan');
    }

    public function edit($id)
    {
        $adminCheck = $this->checkAdmin();

        if ($adminCheck !== null) {
            return $adminCheck;
        }

        $discount = $this->discountModel->find($id);

        if (!$discount) {
            return redirect()->to(base_url('diskon'))->with('failed', 'Data diskon tidak ditemukan');
        }

        $rules = [
            'nominal' => 'required|numeric'
        ];

        $messages = [
            'nominal' => [
                'required' => 'Nominal diskon wajib diisi.',
                'numeric' => 'Nominal diskon harus berupa angka.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()
                ->to(base_url('diskon'))
                ->withInput()
                ->with('failed', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'nominal' => $this->request->getPost('nominal')
        ];

        $this->discountModel->update($id, $data);

        return redirect()->to(base_url('diskon'))->with('success', 'Data diskon berhasil diubah');
    }

    public function delete($id)
    {
        $adminCheck = $this->checkAdmin();

        if ($adminCheck !== null) {
            return $adminCheck;
        }

        $discount = $this->discountModel->find($id);

        if (!$discount) {
            return redirect()->to(base_url('diskon'))->with('failed', 'Data diskon tidak ditemukan');
        }

        $this->discountModel->delete($id);

        return redirect()->to(base_url('diskon'))->with('success', 'Data diskon berhasil dihapus');
    }
}