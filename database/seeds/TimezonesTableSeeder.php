<?php

use Illuminate\Database\Seeder;

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
        		'timezone'	=>	'(GMT-11:00) Midway Island, Samoa'
        	],
        	[
        		'region'	=>	'America/Adak',
        		'timezone'	=>	'(GMT-10:00) Hawaii-Aleutian'
        	],
        	[
        		'region'	=>	'Etc/GMT+10',
        		'timezone'	=>	'(GMT-10:00) Hawaii'
        	],
        	[
        		'region'	=>	'Pacific/Marquesas',
        		'timezone'	=>	'(GMT-09:30) Marquesas Islands'
        	],
        	[
        		'region'	=>	'Pacific/Gambier',
        		'timezone'	=>	'(GMT-09:00) Gambier Islands'
        	],
        	[
        		'region'	=>	'America/Anchorage',
        		'timezone'	=>	'(GMT-09:00) Alaska'
        	],
        	[
        		'region'	=>	'America/Ensenada',
        		'timezone'	=>	'(GMT-08:00) Tijuana, Baja California'
        	],
        	[
        		'region'	=>	'Etc/GMT+8',
        		'timezone'	=>	'(GMT-08:00) Pitcairn Islands'
        	],
        	[
        		'region'	=>	'America/Los_Angeles',
        		'timezone'	=>	'(GMT-08:00) Pacific Time (US & Canada)'
        	],
        	[
        		'region'	=>	'America/Denver',
        		'timezone'	=>	'(GMT-07:00) Mountain Time (US & Canada)'
        	],
        	[
        		'region'	=>	'America/Chihuahua',
        		'timezone'	=>	'(GMT-07:00) Chihuahua, La Paz, Mazatlan'
        	],
        	[
        		'region'	=>	'America/Dawson_Creek',
        		'timezone'	=>	'(GMT-07:00) Arizona'
        	],
        	[
        		'region'	=>	'America/Belize',
        		'timezone'	=>	'(GMT-06:00) Saskatchewan, Central America'
        	],
        	[
        		'region'	=>	'America/Cancun',
        		'timezone'	=>	'(GMT-06:00) Guadalajara, Mexico City, Monterrey'
        	],
        	[
        		'region'	=>	'Chile/EasterIsland',
        		'timezone'	=>	'(GMT-06:00) Easter Island'
        	],
        	[
        		'region'	=>	'America/Chicago',
        		'timezone'	=>	'(GMT-06:00) Central Time (US & Canada)'
        	],
        	[
        		'region'	=>	'America/New_York',
        		'timezone'	=>	'(GMT-05:00) Eastern Time (US & Canada)'
        	],
        	[
        		'region'	=>	'America/Havana',
        		'timezone'	=>	'(GMT-05:00) Cuba'
        	],
        	[
        		'region'	=>	'America/Bogota',
        		'timezone'	=>	'(GMT-05:00) Bogota, Lima, Quito, Rio Branco'
        	],
        	[
        		'region'	=>	'America/Caracas',
        		'timezone'	=>	'(GMT-04:30) Caracas'
        	],
        	[
        		'region'	=>	'America/Santiago',
        		'timezone'	=>	'(GMT-04:00) Santiago'
        	],
        	[
        		'region'	=>	'America/La_Paz',
        		'timezone'	=>	'(GMT-04:00) La Paz'
        	],
        	[
        		'region'	=>	'Atlantic/Stanley',
        		'timezone'	=>	'(GMT-04:00) Faukland Islands'
        	],
        	[
        		'region'	=>	'America/Campo_Grande',
        		'timezone'	=>	'(GMT-04:00) Brazil'
        	],
        	[
        		'region'	=>	'America/Goose_Bay',
        		'timezone'	=>	'(GMT-04:00) Atlantic Time (Goose Bay)'
        	],
        	[
        		'region'	=>	'America/Glace_Bay',
        		'timezone'	=>	'(GMT-04:00) Atlantic Time (Canada)'
        	],
        	[
        		'region'	=>	'America/St_Johns',
        		'timezone'	=>	'(GMT-03:30) Newfoundland'
        	],
        	[
        		'region'	=>	'America/Araguaina',
        		'timezone'	=>	'(GMT-03:00) UTC-3'
        	],
        	[
        		'region'	=>	'America/Montevideo',
        		'timezone'	=>	'(GMT-03:00) Montevideo'
        	],
        	[
        		'region'	=>	'America/Miquelon',
        		'timezone'	=>	'(GMT-03:00) Miquelon, St. Pierre'
        	],
        	[
        		'region'	=>	'America/Godthab',
        		'timezone'	=>	'(GMT-03:00) Greenland'
        	],
        	[
        		'region'	=>	'America/Argentina/Buenos_Aires',
        		'timezone'	=>	'(GMT-03:00) Buenos Aires'
        	],
        	[
        		'region'	=>	'America/Sao_Paulo',
        		'timezone'	=>	'(GMT-03:00) Brasilia'
        	],
        	[
        		'region'	=>	'America/Noronha',
        		'timezone'	=>	'(GMT-02:00) Mid-Atlantic'
        	],
        	[
        		'region'	=>	'Atlantic/Cape_Verde',
        		'timezone'	=>	'(GMT-01:00) Cape Verde Is.'
        	],
        	[
        		'region'	=>	'Atlantic/Azores',
        		'timezone'	=>	'(GMT-01:00) Azores'
        	],
        	[
        		'region'	=>	'Europe/Belfast',
        		'timezone'	=>	'(GMT) Greenwich Mean Time : Belfast'
        	],
        	[
        		'region'	=>	'Europe/Dublin',
        		'timezone'	=>	'(GMT) Greenwich Mean Time : Dublin'
        	],
        	[
        		'region'	=>	'Europe/Lisbon',
        		'timezone'	=>	'(GMT) Greenwich Mean Time : Lisbon'
        	],
        	[
        		'region'	=>	'Europe/London',
        		'timezone'	=>	'(GMT) Greenwich Mean Time : London'
        	],
        	[
        		'region'	=>	'Africa/Abidjan',
        		'timezone'	=>	'(GMT) Monrovia, Reykjavik'
        	],
        	[
        		'region'	=>	'Europe/Amsterdam',
        		'timezone'	=>	'(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna'
        	],
        	[
        		'region'	=>	'Europe/Belgrade',
        		'timezone'	=>	'(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague'
        	],
        	[
        		'region'	=>	'Europe/Brussels',
        		'timezone'	=>	'(GMT+01:00) Brussels, Copenhagen, Madrid, Paris'
        	],
        	[
        		'region'	=>	'Africa/Algiers',
        		'timezone'	=>	'(GMT+01:00) West Central Africa'
        	],
        	[
        		'region'	=>	'Africa/Windhoek',
        		'timezone'	=>	'(GMT+01:00) Windhoek'
        	],
        	[
        		'region'	=>	'Asia/Beirut',
        		'timezone'	=>	'(GMT+02:00) Beirut'
        	],
        	[
        		'region'	=>	'Africa/Cairo',
        		'timezone'	=>	'(GMT+02:00) Cairo'
        	],
        	[
        		'region'	=>	'Asia/Gaza',
        		'timezone'	=>	'(GMT+02:00) Gaza'
        	],
        	[
        		'region'	=>	'Africa/Blantyre',
        		'timezone'	=>	'(GMT+02:00) Harare, Pretoria'
        	],
        	[
        		'region'	=>	'Asia/Jerusalem',
        		'timezone'	=>	'(GMT+02:00) Jerusalem'
        	],
        	[
        		'region'	=>	'Europe/Minsk',
        		'timezone'	=>	'(GMT+02:00) Minsk'
        	],
        	[
        		'region'	=>	'Asia/Damascus',
        		'timezone'	=>	'(GMT+02:00) Syria'
        	],
        	[
        		'region'	=>	'Europe/Moscow',
        		'timezone'	=>	'(GMT+03:00) Moscow, St. Petersburg, Volgograd'
        	],
        	[
        		'region'	=>	'Africa/Addis_Ababa',
        		'timezone'	=>	'(GMT+03:00) Nairobi'
        	],
        	[
        		'region'	=>	'Asia/Tehran',
        		'timezone'	=>	'(GMT+03:30) Tehran'
        	],
        	[
        		'region'	=>	'Asia/Dubai',
        		'timezone'	=>	'(GMT+04:00) Abu Dhabi, Muscat'
        	],
        	[
        		'region'	=>	'Asia/Yerevan',
        		'timezone'	=>	'(GMT+04:00) Yerevan'
        	],
        	[
        		'region'	=>	'Asia/Kabul',
        		'timezone'	=>	'(GMT+04:30) Kabul'
        	],
        	[
        		'region'	=>	'Asia/Yekaterinburg',
        		'timezone'	=>	'(GMT+05:00) Ekaterinburg'
        	],
        	[
        		'region'	=>	'Asia/Tashkent',
        		'timezone'	=>	'(GMT+05:00) Tashkent'
        	],
        	[
        		'region'	=>	'Asia/Kolkata',
        		'timezone'	=>	'(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi'
        	],
        	[
        		'region'	=>	'Asia/Katmandu',
        		'timezone'	=>	'(GMT+05:45) Kathmandu'
        	],
        	[
        		'region'	=>	'Asia/Dhaka',
        		'timezone'	=>	'(GMT+06:00) Astana, Dhaka'
        	],
        	[
        		'region'	=>	'Asia/Novosibirsk',
        		'timezone'	=>	'(GMT+06:00) Novosibirsk'
        	],
        	[
        		'region'	=>	'Asia/Rangoon',
        		'timezone'	=>	'(GMT+06:30) Yangon (Rangoon)'
        	],
        	[
        		'region'	=>	'Asia/Bangkok',
        		'timezone'	=>	'(GMT+07:00) Bangkok, Hanoi, Jakarta'
        	],
        	[
        		'region'	=>	'Asia/Krasnoyarsk',
        		'timezone'	=>	'(GMT+07:00) Krasnoyarsk'
        	],
        	[
        		'region'	=>	'Asia/Hong_Kong',
        		'timezone'	=>	'(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi'
        	],
        	[
        		'region'	=>	'Asia/Irkutsk',
        		'timezone'	=>	'(GMT+08:00) Irkutsk, Ulaan Bataar'
        	],
        	[
        		'region'	=>	'Australia/Perth',
        		'timezone'	=>	'(GMT+08:00) Perth'
        	],
        	[
        		'region'	=>	'Australia/Eucla',
        		'timezone'	=>	'(GMT+08:45) Eucla'
        	],
        	[
        		'region'	=>	'Asia/Tokyo',
        		'timezone'	=>	'(GMT+09:00) Osaka, Sapporo, Tokyo'
        	],
        	[
        		'region'	=>	'Asia/Seoul',
        		'timezone'	=>	'(GMT+09:00) Seoul'
        	],
        	[
        		'region'	=>	'Asia/Yakutsk',
        		'timezone'	=>	'(GMT+09:00) Yakutsk'
        	],
        	[
        		'region'	=>	'Australia/Adelaide',
        		'timezone'	=>	'(GMT+09:30) Adelaide'
        	],
        	[
        		'region'	=>	'Australia/Darwin',
        		'timezone'	=>	'(GMT+09:30) Darwin'
        	],
        	[
        		'region'	=>	'Australia/Brisbane',
        		'timezone'	=>	'(GMT+10:00) Brisbane'
        	],
        	[
        		'region'	=>	'Australia/Hobart',
        		'timezone'	=>	'(GMT+10:00) Hobart'
        	],
        	[
        		'region'	=>	'Asia/Vladivostok',
        		'timezone'	=>	'(GMT+10:00) Vladivostok'
        	],
        	[
        		'region'	=>	'Australia/Lord_Howe',
        		'timezone'	=>	'(GMT+10:30) Lord Howe Island'
        	],
        	[
        		'region'	=>	'Etc/GMT-11',
        		'timezone'	=>	'(GMT+11:00) Solomon Is., New Caledonia'
        	],
        	[
        		'region'	=>	'Asia/Magadan',
        		'timezone'	=>	'(GMT+11:00) Magadan'
        	],
        	[
        		'region'	=>	'Pacific/Norfolk',
        		'timezone'	=>	'(GMT+11:30) Norfolk Island'
        	],
        	[
        		'region'	=>	'Asia/Anadyr',
        		'timezone'	=>	'(GMT+12:00) Anadyr, Kamchatka'
        	],
        	[
        		'region'	=>	'Pacific/Auckland',
        		'timezone'	=>	'(GMT+12:00) Auckland, Wellington'
        	],
        	[
        		'region'	=>	'Etc/GMT-12',
        		'timezone'	=>	'(GMT+12:00) Fiji, Kamchatka, Marshall Is.'
        	],
        	[
        		'region'	=>	'Pacific/Chatham',
        		'timezone'	=>	'(GMT+12:45) Chatham Islands'
        	],
        	[
        		'region'	=>	'Pacific/Tongatapu',
        		'timezone'	=>	'(GMT+13:00) Nuku\'alofa'
        	],
        	[
        		'region'	=>	'Pacific/Kiritimati',
        		'timezone'	=>	'(GMT+14:00) Kiritimati'
        	]
        ]);
    }
}