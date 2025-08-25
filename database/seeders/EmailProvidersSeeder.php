<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\EmailProviders;
class EmailProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = array(
            array('name' => 'Active Campaign','slug' => 'active_campaign'),
            array('name' => 'Sendiio','slug' => 'sendiio'),
        );

        foreach($array as $key => $val){
            $obj = EmailProviders::firstOrNew(['slug'=>$val['slug']]);
            $obj->fill($val);
            $obj->save();
        }
    }
}
