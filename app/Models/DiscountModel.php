<?php

namespace App\Models;

use CodeIgniter\Model;

class DiscountModel extends Model
{
    protected $table            = 'discount';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;

    protected $allowedFields = [
        'tanggal',
        'nominal',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'tanggal' => 'required|valid_date|is_unique[discount.tanggal,id,{id}]',
        'nominal' => 'required|numeric',
    ];

    protected $validationMessages = [
        'tanggal' => [
            'required'   => 'Tanggal diskon wajib diisi.',
            'valid_date' => 'Format tanggal tidak valid.',
            'is_unique'  => 'Tanggal diskon sudah tersedia.',
        ],
        'nominal' => [
            'required' => 'Nominal diskon wajib diisi.',
            'numeric'  => 'Nominal diskon harus berupa angka.',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;
}