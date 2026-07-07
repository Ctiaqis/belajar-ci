<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DiscountSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $nominalList = [
            100000,
            100000,
            200000,
            150000,
            250000,
            300000,
            300000,
            300000,
            300000,
            300000,
        ];

        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'tanggal'    => date('Y-m-d', strtotime("+$i days")),
                'nominal'    => $nominalList[$i],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
                'deleted_at' => null,
            ];
        }

        $this->db->table('discount')->insertBatch($data);
    }
}