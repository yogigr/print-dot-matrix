<?php

namespace Modules\PrintDotMatrix\Database\Seeds;

use App\Abstracts\Model;
use Illuminate\Database\Seeder;

class PrintDotMatrixDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->create();

        Model::reguard();
    }

    private function create()
    {
        setting()->set([
            'print-dot-matrix.host' => 'localhost',
            'print-dot-matrix.port' => '3000',
            'print-dot-matrix.token' => '12345'
        ]);
        
        setting()->save();
    }
}
