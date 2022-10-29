<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $banks = [
            'ASOC. LA NACIONAL',
            'ASOC. POPULAR DE AHORROS Y PRESTAMOS',
            'ASOCIACION BONAO DE AHORROS Y PRESTAMOS',
            'ASOCIACION CIBAO DE A/P',
            'ASOCIACION DUARTE DE AHORROS Y PRESTAMOS',
            'ASOCIACION LA VEGA REAL DE AHORROS Y PRESTAMOS',
            'ASOCIACION MAGUANA DE AHORROS Y PRESTAMOS',
            'ASOCIACION MOCANA DE AHORROS Y PRESTAMOS',
            'ASOCIACION PERAVIA DE AHORROS Y PRESTAMOS',
            'ASOCIACION ROMANA DE AHORROS Y PRESTAMOS',
            'BANCAMERICA',
            'BANCO AHORRO Y CREDITO FEDERAL',
            'BANCO ADOPEM',
            'BANCO ATLANTICO',
            'BANCO ATLAS',
            'BANCO BACC DE AHORRO Y CREDITO DEL CARIBE, S. A.',
            'BANCO BANCOTUI',
            'BANCO BDI',
            'BANCO BELLBANK',
            'BANCO BHD LEON',
            'BANCO CARIBE',
            'BANCO CENTRAL DE LA REPUBLICA DOMINICANA',
            'BANCO COFACI',
            'BANCO CONFISA',
            'BANCO DE AHORRO Y CREDITO FONDESA, S.A. (BANFONDESA)',
            'BANCO DE AHORRO Y CRÉDITO JMMB BANK, S.A.',
            'BANCO DE DESARROLLO ADEMI',
            'BANCO EMPIRE',
            'BANCO FIHOGAR',
            'BANCO GRUFICORP',
            'BANCO LOPEZ DE HARO',
            'BANCO MULTIPLE ACTIVO DOMINICANA,S.A.',
            'BANCO MULTIPLE LAFISE',
            'BANCO NACIONAL DE LAS EXPORTACIONES (BANDEX)',
            'BANCO PROMERICA',
            'BANCO UNION',
            'BANCO VIMENCA',
            'BANESCO',
            'BONANZA BANCO DE AHORRO Y CREDITO',
            'CITIBANK',
            'CORPORACION DE CREDITO LEASING CONFISA,S.A.',
            'CORPORACION DE CREDITO NORDESTANA DE PRESTAMOS, S.A.',
            'MOTOR CREDITO, S. A., BANCO DE AHORRO Y CREDITO',
            'RESERVAS',
            'SANTA CRUZ',
            'SCOTIABANK',
            'Banco Popular',
        ];

        $data = array_map(function ($bank) {
            return ['name' => $bank];
        }, $banks);

        DB::table('banks')->insert($data);
    }
}
