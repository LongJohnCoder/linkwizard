<?php

use Illuminate\Database\Seeder;
use \Carbon\Carbon;

class TimezonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timezones')->insert([
        	[
        		'region'	=>	'Pacific/Midway',
        		'timezone'	=>	'(GMT-11:00) Midway Island, Samoa',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Adak',
        		'timezone'	=>	'(GMT-10:00) Hawaii-Aleutian',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Etc/GMT+10',
        		'timezone'	=>	'(GMT-10:00) Hawaii',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Pacific/Marquesas',
        		'timezone'	=>	'(GMT-09:30) Marquesas Islands',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Pacific/Gambier',
        		'timezone'	=>	'(GMT-09:00) Gambier Islands',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Anchorage',
        		'timezone'	=>	'(GMT-09:00) Alaska',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Ensenada',
        		'timezone'	=>	'(GMT-08:00) Tijuana, Baja California',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Etc/GMT+8',
        		'timezone'	=>	'(GMT-08:00) Pitcairn Islands',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Los_Angeles',
        		'timezone'	=>	'(GMT-08:00) Pacific Time (US & Canada)',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Denver',
        		'timezone'	=>	'(GMT-07:00) Mountain Time (US & Canada)',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Chihuahua',
        		'timezone'	=>	'(GMT-07:00) Chihuahua, La Paz, Mazatlan',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Dawson_Creek',
        		'timezone'	=>	'(GMT-07:00) Arizona',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Belize',
        		'timezone'	=>	'(GMT-06:00) Saskatchewan, Central America',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Cancun',
        		'timezone'	=>	'(GMT-06:00) Guadalajara, Mexico City, Monterrey',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Chile/EasterIsland',
        		'timezone'	=>	'(GMT-06:00) Easter Island',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Chicago',
        		'timezone'	=>	'(GMT-06:00) Central Time (US & Canada)',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/New_York',
        		'timezone'	=>	'(GMT-05:00) Eastern Time (US & Canada)',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Havana',
        		'timezone'	=>	'(GMT-05:00) Cuba',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Bogota',
        		'timezone'	=>	'(GMT-05:00) Bogota, Lima, Quito, Rio Branco',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Caracas',
        		'timezone'	=>	'(GMT-04:30) Caracas',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Santiago',
        		'timezone'	=>	'(GMT-04:00) Santiago',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/La_Paz',
        		'timezone'	=>	'(GMT-04:00) La Paz',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Atlantic/Stanley',
        		'timezone'	=>	'(GMT-04:00) Faukland Islands',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Campo_Grande',
        		'timezone'	=>	'(GMT-04:00) Brazil',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Goose_Bay',
        		'timezone'	=>	'(GMT-04:00) Atlantic Time (Goose Bay)',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Glace_Bay',
        		'timezone'	=>	'(GMT-04:00) Atlantic Time (Canada)',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/St_Johns',
        		'timezone'	=>	'(GMT-03:30) Newfoundland',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Araguaina',
        		'timezone'	=>	'(GMT-03:00) UTC-3',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Montevideo',
        		'timezone'	=>	'(GMT-03:00) Montevideo',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Miquelon',
        		'timezone'	=>	'(GMT-03:00) Miquelon, St. Pierre',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Godthab',
        		'timezone'	=>	'(GMT-03:00) Greenland',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Argentina/Buenos_Aires',
        		'timezone'	=>	'(GMT-03:00) Buenos Aires',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Sao_Paulo',
        		'timezone'	=>	'(GMT-03:00) Brasilia',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'America/Noronha',
        		'timezone'	=>	'(GMT-02:00) Mid-Atlantic',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Atlantic/Cape_Verde',
        		'timezone'	=>	'(GMT-01:00) Cape Verde Is.',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Atlantic/Azores',
        		'timezone'	=>	'(GMT-01:00) Azores',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Europe/Belfast',
        		'timezone'	=>	'(GMT) Greenwich Mean Time : Belfast',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Europe/Dublin',
        		'timezone'	=>	'(GMT) Greenwich Mean Time : Dublin',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Europe/Lisbon',
        		'timezone'	=>	'(GMT) Greenwich Mean Time : Lisbon',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Europe/London',
        		'timezone'	=>	'(GMT) Greenwich Mean Time : London',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Africa/Abidjan',
        		'timezone'	=>	'(GMT) Monrovia, Reykjavik',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Europe/Amsterdam',
        		'timezone'	=>	'(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Europe/Belgrade',
        		'timezone'	=>	'(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Europe/Brussels',
        		'timezone'	=>	'(GMT+01:00) Brussels, Copenhagen, Madrid, Paris',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Africa/Algiers',
        		'timezone'	=>	'(GMT+01:00) West Central Africa',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Africa/Windhoek',
        		'timezone'	=>	'(GMT+01:00) Windhoek',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Beirut',
        		'timezone'	=>	'(GMT+02:00) Beirut',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Africa/Cairo',
        		'timezone'	=>	'(GMT+02:00) Cairo',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Gaza',
        		'timezone'	=>	'(GMT+02:00) Gaza',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Africa/Blantyre',
        		'timezone'	=>	'(GMT+02:00) Harare, Pretoria',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Jerusalem',
        		'timezone'	=>	'(GMT+02:00) Jerusalem',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Europe/Minsk',
        		'timezone'	=>	'(GMT+02:00) Minsk',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Damascus',
        		'timezone'	=>	'(GMT+02:00) Syria',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Europe/Moscow',
        		'timezone'	=>	'(GMT+03:00) Moscow, St. Petersburg, Volgograd',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Africa/Addis_Ababa',
        		'timezone'	=>	'(GMT+03:00) Nairobi',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Tehran',
        		'timezone'	=>	'(GMT+03:30) Tehran',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Dubai',
        		'timezone'	=>	'(GMT+04:00) Abu Dhabi, Muscat',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Yerevan',
        		'timezone'	=>	'(GMT+04:00) Yerevan',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Kabul',
        		'timezone'	=>	'(GMT+04:30) Kabul',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Yekaterinburg',
        		'timezone'	=>	'(GMT+05:00) Ekaterinburg',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Tashkent',
        		'timezone'	=>	'(GMT+05:00) Tashkent',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Kolkata',
        		'timezone'	=>	'(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Katmandu',
        		'timezone'	=>	'(GMT+05:45) Kathmandu',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Dhaka',
        		'timezone'	=>	'(GMT+06:00) Astana, Dhaka',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Novosibirsk',
        		'timezone'	=>	'(GMT+06:00) Novosibirsk',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Rangoon',
        		'timezone'	=>	'(GMT+06:30) Yangon (Rangoon)',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Bangkok',
        		'timezone'	=>	'(GMT+07:00) Bangkok, Hanoi, Jakarta',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Krasnoyarsk',
        		'timezone'	=>	'(GMT+07:00) Krasnoyarsk',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Hong_Kong',
        		'timezone'	=>	'(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Irkutsk',
        		'timezone'	=>	'(GMT+08:00) Irkutsk, Ulaan Bataar',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Australia/Perth',
        		'timezone'	=>	'(GMT+08:00) Perth',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Australia/Eucla',
        		'timezone'	=>	'(GMT+08:45) Eucla',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Tokyo',
        		'timezone'	=>	'(GMT+09:00) Osaka, Sapporo, Tokyo',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Seoul',
        		'timezone'	=>	'(GMT+09:00) Seoul',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Yakutsk',
        		'timezone'	=>	'(GMT+09:00) Yakutsk',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Australia/Adelaide',
        		'timezone'	=>	'(GMT+09:30) Adelaide',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Australia/Darwin',
        		'timezone'	=>	'(GMT+09:30) Darwin',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Australia/Brisbane',
        		'timezone'	=>	'(GMT+10:00) Brisbane',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Australia/Hobart',
        		'timezone'	=>	'(GMT+10:00) Hobart',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Vladivostok',
        		'timezone'	=>	'(GMT+10:00) Vladivostok',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Australia/Lord_Howe',
        		'timezone'	=>	'(GMT+10:30) Lord Howe Island',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Etc/GMT-11',
        		'timezone'	=>	'(GMT+11:00) Solomon Is., New Caledonia',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Magadan',
        		'timezone'	=>	'(GMT+11:00) Magadan',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Pacific/Norfolk',
        		'timezone'	=>	'(GMT+11:30) Norfolk Island',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Asia/Anadyr',
        		'timezone'	=>	'(GMT+12:00) Anadyr, Kamchatka',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Pacific/Auckland',
        		'timezone'	=>	'(GMT+12:00) Auckland, Wellington',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Etc/GMT-12',
        		'timezone'	=>	'(GMT+12:00) Fiji, Kamchatka, Marshall Is.',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Pacific/Chatham',
        		'timezone'	=>	'(GMT+12:45) Chatham Islands',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Pacific/Tongatapu',
        		'timezone'	=>	'(GMT+13:00) Nuku\'alofa',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	],
        	[
        		'region'	=>	'Pacific/Kiritimati',
        		'timezone'	=>	'(GMT+14:00) Kiritimati',
				'created_at'=> Carbon::now(),
				'updated_at'=> Carbon::now()
        	]
        ]);
    }
}