<?php

use Illuminate\Database\Seeder;

class UtilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = array(
		    array("day"=>"SUNDAY","is_active"=>1),
		    array("day"=>"MONDAY","is_active"=>1),
		    array("day"=>"TUESDAY","is_active"=>1),
		    array("day"=>"WEDNESDAY","is_active"=>1),
		    array("day"=>"THURSDAY","is_active"=>1),
		    array("day"=>"FRIDAY","is_active"=>1),
		    array("day"=>"SATURDAY","is_active"=>1),
		);
		DB::table('class_days')->insert($days);
		
		//Default Mark Distribution
		DB::table('mark_distributions')->insert([
            'mark_distribution_type' => 'Exam',
            'mark_percentage' => 100,
            'is_exam' => 'yes',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
        ]);
		
		//Default Academic year
		DB::table('academic_years')->insert([
			'session' => date('Y'),
			'year' => date('Y').'-'.date('Y', strtotime('+1 year')),
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),	
		]);
		
		//Default Settings
		DB::table('settings')->insert([
			[
			  'name' => 'academic_year',
			  'value' => '1'
			],
			[
			  'name' => 'timezone',
			  'value' => 'Africa/Nairobi'
			],
			[
			  'name' => 'currency_symbol',
			  'value' => 'KES'
			],
			[
			  'name' => 'mail_type',
			  'value' => 'mail'
			],
			[
			  'name' => 'logo',
			  'value' => 'logo2.jpeg'
			],
			[
			  'name' => 'paypal_currency',
			  'value' => 'KES'
			],
			[
			  'name' => 'stripe_currency',
			  'value' => 'KES'
			],
			[
			  'name' => 'backend_direction',
			  'value' => 'ltr'
			],
			[
			  'name' => 'active_theme',
			  'value' => 'default'
			],
			[
			  'name' => 'disabled_website',
			  'value' => 'no'
			],
			
			[
			  'name' => 'copyright_text',
			  'value' => '&copy; Copyright 2021. All Rights Reserved. | Openpath Solutions'
			],
			  		  
		]);
		
    }
}
