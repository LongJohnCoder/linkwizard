<?php

use Illuminate\Database\Seeder;
use App\Country;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-s H:i:s');

        Country::unguard();
        /*
         * Seeding multiple rows at once
         */
        Country::insert([
            [
                'name' => "Afghanistan",
                'code' => "AF",
                'isd_prefix' => 93,
                'tld_suffix' => "af",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Albania",
                'code' => "AL",
                'isd_prefix' => 355,
                'tld_suffix' => "al",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Algeria",
                'code' => "DZ",
                'isd_prefix' => 213,
                'tld_suffix' => "dz",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "American Samoa",
                'code' => "AS",
                'isd_prefix' => 1684,
                'tld_suffix' => "as",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Andorra",
                'code' => "AD",
                'isd_prefix' => 376,
                'tld_suffix' => "ad",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Angola",
                'code' => "AO",
                'isd_prefix' => 244,
                'tld_suffix' => "ao",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Anguilla",
                'code' => "AI",
                'isd_prefix' => 1264,
                'tld_suffix' => "ai",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Antarctica",
                'code' => "AQ",
                'isd_prefix' => 672,
                'tld_suffix' => "aq",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Antigua and Barbuda",
                'code' => "AG",
                'isd_prefix' => 1268,
                'tld_suffix' => "ag",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Argentina",
                'code' => "AR",
                'isd_prefix' => 54,
                'tld_suffix' => "ar",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Armenia",
                'code' => "AM",
                'isd_prefix' => 374,
                'tld_suffix' => "am",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Aruba",
                'code' => "AW",
                'isd_prefix' => 297,
                'tld_suffix' => "aw",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Australia",
                'code' => "AU",
                'isd_prefix' => 61,
                'tld_suffix' => "au",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Austria",
                'code' => "AT",
                'isd_prefix' => 43,
                'tld_suffix' => "at",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Azerbaijan",
                'code' => "AZ",
                'isd_prefix' => 994,
                'tld_suffix' => "az",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Bahamas",
                'code' => "BS",
                'isd_prefix' => 1242,
                'tld_suffix' => "bs",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Bahrain",
                'code' => "BH",
                'isd_prefix' => 973,
                'tld_suffix' => "bh",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Bangladesh",
                'code' => "BD",
                'isd_prefix' => 880,
                'tld_suffix' => "bd",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Barbados",
                'code' => "BB",
                'isd_prefix' => 1246,
                'tld_suffix' => "bb",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Belarus",
                'code' => "BY",
                'isd_prefix' => 375,
                'tld_suffix' => "by",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Belgium",
                'code' => "BE",
                'isd_prefix' => 32,
                'tld_suffix' => "be",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Belize",
                'code' => "BZ",
                'isd_prefix' => 501,
                'tld_suffix' => "bz",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Benin",
                'code' => "BJ",
                'isd_prefix' => 229,
                'tld_suffix' => "bj",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Bermuda",
                'code' => "BM",
                'isd_prefix' => 1441,
                'tld_suffix' => "bm",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Bhutan",
                'code' => "BT",
                'isd_prefix' => 975,
                'tld_suffix' => "bt",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Bolivia",
                'code' => "BO",
                'isd_prefix' => 591,
                'tld_suffix' => "bo",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Bosnia and Herzegovina",
                'code' => "BA",
                'isd_prefix' => 387,
                'tld_suffix' => "ba",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Botswana",
                'code' => "BW",
                'isd_prefix' => 267,
                'tld_suffix' => "bw",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Brazil",
                'code' => "BR",
                'isd_prefix' => 55,
                'tld_suffix' => "br",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "British Indian Ocean Territory",
                'code' => "IO",
                'isd_prefix' => 246,
                'tld_suffix' => "io",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "British Virgin Islands",
                'code' => "VG",
                'isd_prefix' => 1284,
                'tld_suffix' => "vg",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Brunei",
                'code' => "BN",
                'isd_prefix' => 673,
                'tld_suffix' => "bn",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Bulgaria",
                'code' => "BG",
                'isd_prefix' => 359,
                'tld_suffix' => "bg",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Burkina Faso",
                'code' => "BF",
                'isd_prefix' => 226,
                'tld_suffix' => "bf",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Burundi",
                'code' => "BI",
                'isd_prefix' => 257,
                'tld_suffix' => "bi",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Cambodia",
                'code' => "KH",
                'isd_prefix' => 855,
                'tld_suffix' => "kh",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Cameroon",
                'code' => "CM",
                'isd_prefix' => 237,
                'tld_suffix' => "cm",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Canada",
                'code' => "CA",
                'isd_prefix' => 1,
                'tld_suffix' => "ca",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Cape Verde",
                'code' => "CV",
                'isd_prefix' => 238,
                'tld_suffix' => "cv",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Cayman Islands",
                'code' => "KY",
                'isd_prefix' => 1345,
                'tld_suffix' => "ky",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Central African Republic",
                'code' => "CF",
                'isd_prefix' => 236,
                'tld_suffix' => "cf",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Chad",
                'code' => "TD",
                'isd_prefix' => 235,
                'tld_suffix' => "td",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Chile",
                'code' => "CL",
                'isd_prefix' => 56,
                'tld_suffix' => "cl",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "China",
                'code' => "CN",
                'isd_prefix' => 86,
                'tld_suffix' => "cn",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Christmas Island",
                'code' => "CX",
                'isd_prefix' => 61,
                'tld_suffix' => "cx",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Cocos Islands",
                'code' => "CC",
                'isd_prefix' => 61,
                'tld_suffix' => "cc",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Colombia",
                'code' => "CO",
                'isd_prefix' => 57,
                'tld_suffix' => "co",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Comoros",
                'code' => "KM",
                'isd_prefix' => 269,
                'tld_suffix' => "km",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Cook Islands",
                'code' => "CK",
                'isd_prefix' => 682,
                'tld_suffix' => "ck",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Costa Rica",
                'code' => "CR",
                'isd_prefix' => 506,
                'tld_suffix' => "cr",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Croatia",
                'code' => "HR",
                'isd_prefix' => 385,
                'tld_suffix' => "hr",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Cuba",
                'code' => "CU",
                'isd_prefix' => 53,
                'tld_suffix' => "cu",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Curacao",
                'code' => "CW",
                'isd_prefix' => 599,
                'tld_suffix' => "cw",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Cyprus",
                'code' => "CY",
                'isd_prefix' => 357,
                'tld_suffix' => "cy",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Czech Republic",
                'code' => "CZ",
                'isd_prefix' => 420,
                'tld_suffix' => "cz",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Democratic Republic of the Congo",
                'code' => "CD",
                'isd_prefix' => 243,
                'tld_suffix' => "cd",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Denmark",
                'code' => "DK",
                'isd_prefix' => 45,
                'tld_suffix' => "dk",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Djibouti",
                'code' => "DJ",
                'isd_prefix' => 253,
                'tld_suffix' => "dj",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Dominica",
                'code' => "DM",
                'isd_prefix' => 1767,
                'tld_suffix' => "dm",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Dominican Republic",
                'code' => "DO",
                'isd_prefix' => 1809,
                'tld_suffix' => "do",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "East Timor",
                'code' => "TL",
                'isd_prefix' => 670,
                'tld_suffix' => "tl",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Ecuador",
                'code' => "EC",
                'isd_prefix' => 593,
                'tld_suffix' => "ec",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Egypt",
                'code' => "EG",
                'isd_prefix' => 20,
                'tld_suffix' => "eg",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "El Salvador",
                'code' => "SV",
                'isd_prefix' => 503,
                'tld_suffix' => "sv",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Equatorial Guinea",
                'code' => "GQ",
                'isd_prefix' => 240,
                'tld_suffix' => "gq",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Eritrea",
                'code' => "ER",
                'isd_prefix' => 291,
                'tld_suffix' => "er",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Estonia",
                'code' => "EE",
                'isd_prefix' => 372,
                'tld_suffix' => "ee",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Ethiopia",
                'code' => "ET",
                'isd_prefix' => 251,
                'tld_suffix' => "et",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Falkland Islands",
                'code' => "FK",
                'isd_prefix' => 500,
                'tld_suffix' => "fk",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Faroe Islands",
                'code' => "FO",
                'isd_prefix' => 298,
                'tld_suffix' => "fo",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Fiji",
                'code' => "FJ",
                'isd_prefix' => 679,
                'tld_suffix' => "fj",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Finland",
                'code' => "FI",
                'isd_prefix' => 358,
                'tld_suffix' => "fi",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "France",
                'code' => "FR",
                'isd_prefix' => 33,
                'tld_suffix' => "fr",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "French Polynesia",
                'code' => "PF",
                'isd_prefix' => 689,
                'tld_suffix' => "pf",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Gabon",
                'code' => "GA",
                'isd_prefix' => 241,
                'tld_suffix' => "ga",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Gambia",
                'code' => "GM",
                'isd_prefix' => 220,
                'tld_suffix' => "gm",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Georgia",
                'code' => "GE",
                'isd_prefix' => 995,
                'tld_suffix' => "ge",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Germany",
                'code' => "DE",
                'isd_prefix' => 49,
                'tld_suffix' => "de",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Ghana",
                'code' => "GH",
                'isd_prefix' => 233,
                'tld_suffix' => "gh",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Gibraltar",
                'code' => "GI",
                'isd_prefix' => 350,
                'tld_suffix' => "gi",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Greece",
                'code' => "GR",
                'isd_prefix' => 30,
                'tld_suffix' => "gr",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Greenland",
                'code' => "GL",
                'isd_prefix' => 299,
                'tld_suffix' => "gl",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Grenada",
                'code' => "GD",
                'isd_prefix' => 1473,
                'tld_suffix' => "gd",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Guam",
                'code' => "GU",
                'isd_prefix' => 1671,
                'tld_suffix' => "gu",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Guatemala",
                'code' => "GT",
                'isd_prefix' => 502,
                'tld_suffix' => "gt",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Guernsey",
                'code' => "GG",
                'isd_prefix' => 441481,
                'tld_suffix' => "gg",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Guinea",
                'code' => "GN",
                'isd_prefix' => 224,
                'tld_suffix' => "gn",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Guinea-Bissau",
                'code' => "GW",
                'isd_prefix' => 245,
                'tld_suffix' => "gw",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Guyana",
                'code' => "GY",
                'isd_prefix' => 592,
                'tld_suffix' => "gy",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Haiti",
                'code' => "HT",
                'isd_prefix' => 509,
                'tld_suffix' => "ht",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Honduras",
                'code' => "HN",
                'isd_prefix' => 504,
                'tld_suffix' => "hn",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Hong Kong",
                'code' => "HK",
                'isd_prefix' => 852,
                'tld_suffix' => "hk",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Hungary",
                'code' => "HU",
                'isd_prefix' => 36,
                'tld_suffix' => "hu",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Iceland",
                'code' => "IS",
                'isd_prefix' => 354,
                'tld_suffix' => "is",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "India",
                'code' => "IN",
                'isd_prefix' => 91,
                'tld_suffix' => "in",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Indonesia",
                'code' => "ID",
                'isd_prefix' => 62,
                'tld_suffix' => "id",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Iran",
                'code' => "IR",
                'isd_prefix' => 98,
                'tld_suffix' => "ir",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Iraq",
                'code' => "IQ",
                'isd_prefix' => 964,
                'tld_suffix' => "iq",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Ireland",
                'code' => "IE",
                'isd_prefix' => 353,
                'tld_suffix' => "ie",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Isle of Man",
                'code' => "IM",
                'isd_prefix' => 441624,
                'tld_suffix' => "im",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Israel",
                'code' => "IL",
                'isd_prefix' => 972,
                'tld_suffix' => "il",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Italy",
                'code' => "IT",
                'isd_prefix' => 39,
                'tld_suffix' => "it",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Ivory Coast",
                'code' => "CI",
                'isd_prefix' => 225,
                'tld_suffix' => "ci",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Jamaica",
                'code' => "JM",
                'isd_prefix' => 1876,
                'tld_suffix' => "jm",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Japan",
                'code' => "JP",
                'isd_prefix' => 81,
                'tld_suffix' => "jp",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Jersey",
                'code' => "JE",
                'isd_prefix' => 441534,
                'tld_suffix' => "je",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Jordan",
                'code' => "JO",
                'isd_prefix' => 962,
                'tld_suffix' => "jo",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Kazakhstan",
                'code' => "KZ",
                'isd_prefix' => 7,
                'tld_suffix' => "kz",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Kenya",
                'code' => "KE",
                'isd_prefix' => 254,
                'tld_suffix' => "ke",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Kiribati",
                'code' => "KI",
                'isd_prefix' => 686,
                'tld_suffix' => "ki",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Kosovo",
                'code' => "XK",
                'isd_prefix' => 383,
                'tld_suffix' => "",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Kuwait",
                'code' => "KW",
                'isd_prefix' => 965,
                'tld_suffix' => "kw",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Kyrgyzstan",
                'code' => "KG",
                'isd_prefix' => 996,
                'tld_suffix' => "kg",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Laos",
                'code' => "LA",
                'isd_prefix' => 856,
                'tld_suffix' => "la",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Latvia",
                'code' => "LV",
                'isd_prefix' => 371,
                'tld_suffix' => "lv",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Lebanon",
                'code' => "LB",
                'isd_prefix' => 961,
                'tld_suffix' => "lb",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Lesotho",
                'code' => "LS",
                'isd_prefix' => 266,
                'tld_suffix' => "ls",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Liberia",
                'code' => "LR",
                'isd_prefix' => 231,
                'tld_suffix' => "lr",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Libya",
                'code' => "LY",
                'isd_prefix' => 218,
                'tld_suffix' => "ly",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Liechtenstein",
                'code' => "LI",
                'isd_prefix' => 423,
                'tld_suffix' => "li",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Lithuania",
                'code' => "LT",
                'isd_prefix' => 370,
                'tld_suffix' => "lt",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Luxembourg",
                'code' => "LU",
                'isd_prefix' => 352,
                'tld_suffix' => "lu",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Macao",
                'code' => "MO",
                'isd_prefix' => 853,
                'tld_suffix' => "mo",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Macedonia",
                'code' => "MK",
                'isd_prefix' => 389,
                'tld_suffix' => "mk",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Madagascar",
                'code' => "MG",
                'isd_prefix' => 261,
                'tld_suffix' => "mg",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Malawi",
                'code' => "MW",
                'isd_prefix' => 265,
                'tld_suffix' => "mw",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Malaysia",
                'code' => "MY",
                'isd_prefix' => 60,
                'tld_suffix' => "my",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Maldives",
                'code' => "MV",
                'isd_prefix' => 960,
                'tld_suffix' => "mv",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Mali",
                'code' => "ML",
                'isd_prefix' => 223,
                'tld_suffix' => "ml",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Malta",
                'code' => "MT",
                'isd_prefix' => 356,
                'tld_suffix' => "mt",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Marshall Islands",
                'code' => "MH",
                'isd_prefix' => 692,
                'tld_suffix' => "mh",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Mauritania",
                'code' => "MR",
                'isd_prefix' => 222,
                'tld_suffix' => "mr",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Mauritius",
                'code' => "MU",
                'isd_prefix' => 230,
                'tld_suffix' => "mu",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Mayotte",
                'code' => "YT",
                'isd_prefix' => 262,
                'tld_suffix' => "yt",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Mexico",
                'code' => "MX",
                'isd_prefix' => 52,
                'tld_suffix' => "mx",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Micronesia",
                'code' => "FM",
                'isd_prefix' => 691,
                'tld_suffix' => "fm",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Moldova",
                'code' => "MD",
                'isd_prefix' => 373,
                'tld_suffix' => "md",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Monaco",
                'code' => "MC",
                'isd_prefix' => 377,
                'tld_suffix' => "mc",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Mongolia",
                'code' => "MN",
                'isd_prefix' => 976,
                'tld_suffix' => "mn",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Montenegro",
                'code' => "ME",
                'isd_prefix' => 382,
                'tld_suffix' => "me",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Montserrat",
                'code' => "MS",
                'isd_prefix' => 1664,
                'tld_suffix' => "ms",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Morocco",
                'code' => "MA",
                'isd_prefix' => 212,
                'tld_suffix' => "ma",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Mozambique",
                'code' => "MZ",
                'isd_prefix' => 258,
                'tld_suffix' => "mz",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Myanmar",
                'code' => "MM",
                'isd_prefix' => 95,
                'tld_suffix' => "mm",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Namibia",
                'code' => "NA",
                'isd_prefix' => 264,
                'tld_suffix' => "na",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Nauru",
                'code' => "NR",
                'isd_prefix' => 674,
                'tld_suffix' => "nr",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Nepal",
                'code' => "NP",
                'isd_prefix' => 977,
                'tld_suffix' => "np",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Netherlands",
                'code' => "NL",
                'isd_prefix' => 31,
                'tld_suffix' => "nl",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Netherlands Antilles",
                'code' => "AN",
                'isd_prefix' => 599,
                'tld_suffix' => "an",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "New Caledonia",
                'code' => "NC",
                'isd_prefix' => 687,
                'tld_suffix' => "nc",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "New Zealand",
                'code' => "NZ",
                'isd_prefix' => 64,
                'tld_suffix' => "nz",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Nicaragua",
                'code' => "NI",
                'isd_prefix' => 505,
                'tld_suffix' => "ni",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Niger",
                'code' => "NE",
                'isd_prefix' => 227,
                'tld_suffix' => "ne",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Nigeria",
                'code' => "NG",
                'isd_prefix' => 234,
                'tld_suffix' => "ng",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Niue",
                'code' => "NU",
                'isd_prefix' => 683,
                'tld_suffix' => "nu",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "North Korea",
                'code' => "KP",
                'isd_prefix' => 850,
                'tld_suffix' => "kp",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Northern Mariana Islands",
                'code' => "MP",
                'isd_prefix' => 1670,
                'tld_suffix' => "mp",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Norway",
                'code' => "NO",
                'isd_prefix' => 47,
                'tld_suffix' => "no",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Oman",
                'code' => "OM",
                'isd_prefix' => 968,
                'tld_suffix' => "om",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Pakistan",
                'code' => "PK",
                'isd_prefix' => 92,
                'tld_suffix' => "pk",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Palau",
                'code' => "PW",
                'isd_prefix' => 680,
                'tld_suffix' => "pw",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Palestine",
                'code' => "PS",
                'isd_prefix' => 970,
                'tld_suffix' => "ps",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Panama",
                'code' => "PA",
                'isd_prefix' => 507,
                'tld_suffix' => "pa",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Papua New Guinea",
                'code' => "PG",
                'isd_prefix' => 675,
                'tld_suffix' => "pg",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Paraguay",
                'code' => "PY",
                'isd_prefix' => 595,
                'tld_suffix' => "py",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Peru",
                'code' => "PE",
                'isd_prefix' => 51,
                'tld_suffix' => "pe",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Philippines",
                'code' => "PH",
                'isd_prefix' => 63,
                'tld_suffix' => "ph",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Pitcairn",
                'code' => "PN",
                'isd_prefix' => 64,
                'tld_suffix' => "pn",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Poland",
                'code' => "PL",
                'isd_prefix' => 48,
                'tld_suffix' => "pl",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Portugal",
                'code' => "PT",
                'isd_prefix' => 351,
                'tld_suffix' => "pt",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Puerto Rico",
                'code' => "PR",
                'isd_prefix' => 1787,
                'tld_suffix' => "pr",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Qatar",
                'code' => "QA",
                'isd_prefix' => 974,
                'tld_suffix' => "qa",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Republic of the Congo",
                'code' => "CG",
                'isd_prefix' => 242,
                'tld_suffix' => "cg",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Reunion",
                'code' => "RE",
                'isd_prefix' => 262,
                'tld_suffix' => "re",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Romania",
                'code' => "RO",
                'isd_prefix' => 40,
                'tld_suffix' => "ro",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Russia",
                'code' => "RU",
                'isd_prefix' => 7,
                'tld_suffix' => "ru",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Rwanda",
                'code' => "RW",
                'isd_prefix' => 250,
                'tld_suffix' => "rw",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Saint Barthelemy",
                'code' => "BL",
                'isd_prefix' => 590,
                'tld_suffix' => "gp",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Saint Helena",
                'code' => "SH",
                'isd_prefix' => 290,
                'tld_suffix' => "sh",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Saint Kitts and Nevis",
                'code' => "KN",
                'isd_prefix' => 1869,
                'tld_suffix' => "kn",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Saint Lucia",
                'code' => "LC",
                'isd_prefix' => 1758,
                'tld_suffix' => "lc",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Saint Martin",
                'code' => "MF",
                'isd_prefix' => 590,
                'tld_suffix' => "gp",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Saint Pierre and Miquelon",
                'code' => "PM",
                'isd_prefix' => 508,
                'tld_suffix' => "pm",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Saint Vincent and the Grenadines",
                'code' => "VC",
                'isd_prefix' => 1784,
                'tld_suffix' => "vc",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Samoa",
                'code' => "WS",
                'isd_prefix' => 685,
                'tld_suffix' => "ws",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "San Marino",
                'code' => "SM",
                'isd_prefix' => 378,
                'tld_suffix' => "sm",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Sao Tome and Principe",
                'code' => "ST",
                'isd_prefix' => 239,
                'tld_suffix' => "st",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Saudi Arabia",
                'code' => "SA",
                'isd_prefix' => 966,
                'tld_suffix' => "sa",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Senegal",
                'code' => "SN",
                'isd_prefix' => 221,
                'tld_suffix' => "sn",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Serbia",
                'code' => "RS",
                'isd_prefix' => 381,
                'tld_suffix' => "rs",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Seychelles",
                'code' => "SC",
                'isd_prefix' => 248,
                'tld_suffix' => "sc",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Sierra Leone",
                'code' => "SL",
                'isd_prefix' => 232,
                'tld_suffix' => "sl",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Singapore",
                'code' => "SG",
                'isd_prefix' => 65,
                'tld_suffix' => "sg",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Sint Maarten",
                'code' => "SX",
                'isd_prefix' => 1721,
                'tld_suffix' => "sx",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Slovakia",
                'code' => "SK",
                'isd_prefix' => 421,
                'tld_suffix' => "sk",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Slovenia",
                'code' => "SI",
                'isd_prefix' => 386,
                'tld_suffix' => "si",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Solomon Islands",
                'code' => "SB",
                'isd_prefix' => 677,
                'tld_suffix' => "sb",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Somalia",
                'code' => "SO",
                'isd_prefix' => 252,
                'tld_suffix' => "so",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "South Africa",
                'code' => "ZA",
                'isd_prefix' => 27,
                'tld_suffix' => "za",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "South Korea",
                'code' => "KR",
                'isd_prefix' => 82,
                'tld_suffix' => "kr",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "South Sudan",
                'code' => "SS",
                'isd_prefix' => 211,
                'tld_suffix' => "ss",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Spain",
                'code' => "ES",
                'isd_prefix' => 34,
                'tld_suffix' => "es",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Sri Lanka",
                'code' => "LK",
                'isd_prefix' => 94,
                'tld_suffix' => "lk",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Sudan",
                'code' => "SD",
                'isd_prefix' => 249,
                'tld_suffix' => "sd",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Suriname",
                'code' => "SR",
                'isd_prefix' => 597,
                'tld_suffix' => "sr",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Svalbard and Jan Mayen",
                'code' => "SJ",
                'isd_prefix' => 47,
                'tld_suffix' => "sj",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Swaziland",
                'code' => "SZ",
                'isd_prefix' => 268,
                'tld_suffix' => "sz",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Sweden",
                'code' => "SE",
                'isd_prefix' => 46,
                'tld_suffix' => "se",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Switzerland",
                'code' => "CH",
                'isd_prefix' => 41,
                'tld_suffix' => "ch",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Syria",
                'code' => "SY",
                'isd_prefix' => 963,
                'tld_suffix' => "sy",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Taiwan",
                'code' => "TW",
                'isd_prefix' => 886,
                'tld_suffix' => "tw",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Tajikistan",
                'code' => "TJ",
                'isd_prefix' => 992,
                'tld_suffix' => "tj",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Tanzania",
                'code' => "TZ",
                'isd_prefix' => 255,
                'tld_suffix' => "tz",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Thailand",
                'code' => "TH",
                'isd_prefix' => 66,
                'tld_suffix' => "th",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Togo",
                'code' => "TG",
                'isd_prefix' => 228,
                'tld_suffix' => "tg",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Tokelau",
                'code' => "TK",
                'isd_prefix' => 690,
                'tld_suffix' => "tk",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Tonga",
                'code' => "TO",
                'isd_prefix' => 676,
                'tld_suffix' => "to",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Trinidad and Tobago",
                'code' => "TT",
                'isd_prefix' => 1868,
                'tld_suffix' => "tt",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Tunisia",
                'code' => "TN",
                'isd_prefix' => 216,
                'tld_suffix' => "tn",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Turkey",
                'code' => "TR",
                'isd_prefix' => 90,
                'tld_suffix' => "tr",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Turkmenistan",
                'code' => "TM",
                'isd_prefix' => 993,
                'tld_suffix' => "tm",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Turks and Caicos Islands",
                'code' => "TC",
                'isd_prefix' => 1649,
                'tld_suffix' => "tc",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Tuvalu",
                'code' => "TV",
                'isd_prefix' => 688,
                'tld_suffix' => "tv",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "U.S. Virgin Islands",
                'code' => "VI",
                'isd_prefix' => 1340,
                'tld_suffix' => "vi",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Uganda",
                'code' => "UG",
                'isd_prefix' => 256,
                'tld_suffix' => "ug",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Ukraine",
                'code' => "UA",
                'isd_prefix' => 380,
                'tld_suffix' => "ua",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "United Arab Emirates",
                'code' => "AE",
                'isd_prefix' => 971,
                'tld_suffix' => "ae",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "United Kingdom",
                'code' => "GB",
                'isd_prefix' => 44,
                'tld_suffix' => "uk",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "United States of America",
                'code' => "US",
                'isd_prefix' => 1,
                'tld_suffix' => "us",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Uruguay",
                'code' => "UY",
                'isd_prefix' => 598,
                'tld_suffix' => "uy",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Uzbekistan",
                'code' => "UZ",
                'isd_prefix' => 998,
                'tld_suffix' => "uz",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Vanuatu",
                'code' => "VU",
                'isd_prefix' => 678,
                'tld_suffix' => "vu",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Vatican",
                'code' => "VA",
                'isd_prefix' => 379,
                'tld_suffix' => "va",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Venezuela",
                'code' => "VE",
                'isd_prefix' => 58,
                'tld_suffix' => "ve",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Vietnam",
                'code' => "VN",
                'isd_prefix' => 84,
                'tld_suffix' => "vn",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Wallis and Futuna",
                'code' => "WF",
                'isd_prefix' => 681,
                'tld_suffix' => "wf",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Western Sahara",
                'code' => "EH",
                'isd_prefix' => 212,
                'tld_suffix' => "eh",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Yemen",
                'code' => "YE",
                'isd_prefix' => 967,
                'tld_suffix' => "ye",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Zambia",
                'code' => "ZM",
                'isd_prefix' => 260,
                'tld_suffix' => "zm",
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => "Zimbabwe",
                'code' => "ZW",
                'isd_prefix' => 263,
                'tld_suffix' => "zw",
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
		Country::reguard();
    }
}
