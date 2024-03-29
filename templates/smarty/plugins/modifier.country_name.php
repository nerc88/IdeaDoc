<?php
/**
 * Smarty country_name modifier plugin
 *
 * Type:     modifier<br>
 * Name:     country_name<br>
 * Purpose:  возврящает название страны по русски по переданому условному обозначению страны по стандарту ISO
 * 
 * @param string $code передаваемое в модификатор значение
 * @param int $default значение если страна не найдена
 * @return string
 */
function smarty_modifier_country_name($code, $lang='rus', $default=null)
{
	$countriesEngNames = array(
		"GB" => "United Kingdom",
		"US" => "United States",
		"CA" => "Canada",
		"MX" => "Mexico",
		"BM" => "Bermuda",
		"SE" => "Sweden",
		"IT" => "Italy",
		"A2" => "Satellite Provider",
		"CH" => "Switzerland",
		"PR" => "Puerto Rico",
		"IN" => "India",
		"VI" => "Virgin Islands, U.S.",
		"DE" => "Germany",
		"IR" => "Iran, Islamic Republic of",
		"BO" => "Bolivia",
		"NG" => "Nigeria",
		"NL" => "Netherlands",
		"FR" => "France",
		"IL" => "Israel",
		"ES" => "Spain",
		"PA" => "Panama",
		"CL" => "Chile",
		"BS" => "Bahamas",
		"AR" => "Argentina",
		"DM" => "Dominica",
		"BE" => "Belgium",
		"IE" => "Ireland",
		"BZ" => "Belize",
		"BR" => "Brazil",
		"ZA" => "South Africa",
		"SC" => "Seychelles",
		"TZ" => "Tanzania, United Republic of",
		"EG" => "Egypt",
		"RW" => "Rwanda",
		"DZ" => "Algeria",
		"SZ" => "Swaziland",
		"GH" => "Ghana",
		"CM" => "Cameroon",
		"MG" => "Madagascar",
		"KE" => "Kenya",
		"AO" => "Angola",
		"NA" => "Namibia",
		"MA" => "Morocco",
		"SL" => "Sierra Leone",
		"CI" => "Cote D'Ivoire",
		"GA" => "Gabon",
		"MU" => "Mauritius",
		"TG" => "Togo",
		"LY" => "Libyan Arab Jamahiriya",
		"SN" => "Senegal",
		"SD" => "Sudan",
		"UG" => "Uganda",
		"ZW" => "Zimbabwe",
		"MZ" => "Mozambique",
		"ZM" => "Zambia",
		"BW" => "Botswana",
		"LR" => "Liberia",
		"CD" => "Congo, The Democratic Republic of the",
		"BJ" => "Benin",
		"TN" => "Tunisia",
		"JP" => "Japan",
		"EU" => "Europe",
		"AU" => "Australia",
		"TH" => "Thailand",
		"CN" => "China",
		"MY" => "Malaysia",
		"PK" => "Pakistan",
		"NZ" => "New Zealand",
		"KR" => "Korea, Republic of",
		"HK" => "Hong Kong",
		"SG" => "Singapore",
		"BD" => "Bangladesh",
		"ID" => "Indonesia",
		"PH" => "Philippines",
		"TW" => "Taiwan",
		"AF" => "Afghanistan",
		"VN" => "Vietnam",
		"VU" => "Vanuatu",
		"NC" => "New Caledonia",
		"BN" => "Brunei Darussalam",
		"AP" => "Asia/Pacific Region",
		"GR" => "Greece",
		"SA" => "Saudi Arabia",
		"PL" => "Poland",
		"CZ" => "Czech Republic",
		"RU" => "Russian Federation",
		"CY" => "Cyprus",
		"NO" => "Norway",
		"AT" => "Austria",
		"UA" => "Ukraine",
		"TJ" => "Tajikistan",
		"DK" => "Denmark",
		"PT" => "Portugal",
		"TR" => "Turkey",
		"GE" => "Georgia",
		"BY" => "Belarus",
		"IQ" => "Iraq",
		"AM" => "Armenia",
		"LB" => "Lebanon",
		"MD" => "Moldova, Republic of",
		"BG" => "Bulgaria",
		"FI" => "Finland",
		"OM" => "Oman",
		"LV" => "Latvia",
		"KZ" => "Kazakstan",
		"EE" => "Estonia",
		"SK" => "Slovakia",
		"JO" => "Jordan",
		"HU" => "Hungary",
		"KW" => "Kuwait",
		"AL" => "Albania",
		"LT" => "Lithuania",
		"SM" => "San Marino",
		"BT" => "Bhutan",
		"RO" => "Romania",
		"RS" => "Serbia",
		"HR" => "Croatia",
		"LU" => "Luxembourg",
		"IS" => "Iceland",
		"LI" => "Liechtenstein",
		"CR" => "Costa Rica",
		"MK" => "Macedonia",
		"MT" => "Malta",
		"GM" => "Gambia",
		"MW" => "Malawi",
		"SI" => "Slovenia",
		"FK" => "Falkland Islands (Malvinas)",
		"AZ" => "Azerbaijan",
		"MC" => "Monaco",
		"HT" => "Haiti",
		"GU" => "Guam",
		"JM" => "Jamaica",
		"FM" => "Micronesia, Federated States of",
		"EC" => "Ecuador",
		"CO" => "Colombia",
		"PE" => "Peru",
		"KY" => "Cayman Islands",
		"GP" => "Guadeloupe",
		"HN" => "Honduras",
		"YE" => "Yemen",
		"VG" => "Virgin Islands, British",
		"LC" => "Saint Lucia",
		"SY" => "Syrian Arab Republic",
		"NI" => "Nicaragua",
		"DO" => "Dominican Republic",
		"AN" => "Netherlands Antilles",
		"GT" => "Guatemala",
		"VE" => "Venezuela",
		"BA" => "Bosnia and Herzegovina",
		"HM" => "Heard Island and McDonald Islands",
		"UY" => "Uruguay",
		"SV" => "El Salvador",
		"AE" => "United Arab Emirates",
		"TT" => "Trinidad and Tobago",
		"LK" => "Sri Lanka",
		"BV" => "Bouvet Island",
		"MH" => "Marshall Islands",
		"BH" => "Bahrain",
		"CK" => "Cook Islands",
		"GI" => "Gibraltar",
		"PY" => "Paraguay",
		"AG" => "Antigua and Barbuda",
		"LS" => "Lesotho",
		"KN" => "Saint Kitts and Nevis",
		"WS" => "Samoa",
		"PW" => "Palau",
		"QA" => "Qatar",
		"KH" => "Cambodia",
		"AI" => "Anguilla",
		"AS" => "American Samoa",
		"TC" => "Turks and Caicos Islands",
		"MP" => "Northern Mariana Islands",
		"UZ" => "Uzbekistan",
		"MO" => "Macau",
		"UM" => "United States Minor Outlying Islands",
		"RE" => "Reunion",
		"GY" => "Guyana",
		"CU" => "Cuba",
		"CG" => "Congo",
		"A1" => "Anonymous Proxy",
		"BB" => "Barbados",
		"LA" => "Lao People's Democratic Republic",
		"SR" => "Suriname",
		"AW" => "Aruba",
		"FJ" => "Fiji",
		"MS" => "Montserrat",
		"GD" => "Grenada",
		"VC" => "Saint Vincent and the Grenadines",
		"NP" => "Nepal",
		"KG" => "Kyrgyzstan",
		"ME" => "Montenegro",
		"TD" => "Chad",
		"FO" => "Faroe Islands",
		"SO" => "Somalia",
		"ML" => "Mali",
		"PS" => "Palestinian Territory, Occupied",
		"BI" => "Burundi",
		"GN" => "Guinea",
		"ET" => "Ethiopia",
		"KM" => "Comoros",
		"MR" => "Mauritania",
		"MQ" => "Martinique",
		"NE" => "Niger",
		"VA" => "Holy See (Vatican City State)",
		"TM" => "Turkmenistan",
		"YT" => "Mayotte",
		"BF" => "Burkina Faso",
		"AD" => "Andorra",
		"AQ" => "Antarctica",
		"GL" => "Greenland",
		"WF" => "Wallis and Futuna",
		"PG" => "Papua New Guinea",
		"MN" => "Mongolia",
		"PF" => "French Polynesia",
		"MV" => "Maldives",
		"CF" => "Central African Republic",
		"ER" => "Eritrea",
		"GW" => "Guinea-Bissau",
		"DJ" => "Djibouti",
		"GQ" => "Equatorial Guinea",
		"CV" => "Cape Verde",
		"ST" => "Sao Tome and Principe",
		"GF" => "French Guiana",
		"SB" => "Solomon Islands",
		"TV" => "Tuvalu",
		"KI" => "Kiribati",
		"TO" => "Tonga",
		"IO" => "British Indian Ocean Territory",
		"NU" => "Niue",
		"TK" => "Tokelau",
		"NR" => "Nauru",
		"NF" => "Norfolk Island",
		"MM" => "Myanmar",
		"KP" => "Korea, Democratic People's Republic of"
	);
    $countriesNames    = array(
        'GB' => 'Великобритания', 'US' => 'США', 'CA' => 'Канада', 'MX' => 'Мексика', 'BM' => 'Бермуды',
        'SE' => 'Швеция', 'IT' => 'Италия', 'CH' => 'Швейцария', 'PR' => 'Пуэрто-Рико', 'IN' => 'Индия',
        'VI' => 'Американские Виргинские острова', 'DE' => 'Германия', 'IR' => 'Иран', 'BO' => 'Боливия',
        'NG' => 'Нигерия', 'NL' => 'Нидерланды', 'FR' => 'Франция', 'IL' => 'Израиль', 'ES' => 'Испания',
        'PA' => 'Панама', 'CL' => 'Чили', 'BS' => 'Багамы', 'AR' => 'Аргентина', 'DM' => 'Доминика',
        'BE' => 'Бельгия', 'IE' => 'Ирландия', 'BZ' => 'Белиз', 'BR' => 'Бразилия', 'ZA' => 'ЮАР',
        'SC' => 'Сейшелы', 'TZ' => 'Танзания', 'EG' => 'Египет', 'RW' => 'Руанда', 'DZ' => 'Алжир',
        'SZ' => 'Свазиленд', 'GH' => 'Гана', 'CM' => 'Камерун', 'MG' => 'Мадагаскар', 'KE' => 'Кения',
        'AO' => 'Ангола', 'NA' => 'Намибия', 'MA' => 'Марокко', 'SL' => 'Сьерра-Леоне', 'CI' => 'Кот-д’Ивуар',
        'GA' => 'Габон', 'MU' => 'Маврикий', 'TG' => 'Того', 'LY' => 'Ливия', 'SN' => 'Сенегал', 'SD' => 'Судан',
        'UG' => 'Уганда', 'ZW' => 'Зимбабве', 'MZ' => 'Мозамбик', 'ZM' => 'Замбия', 'BW' => 'Ботсвана',
        'LR' => 'Либерия', 'CD' => 'Демократическая Республика Конго', 'BJ' => 'Бенин', 'TN' => 'Тунис',
        'JP' => 'Япония', 'EU' => 'Европейский Союз', 'AU' => 'Австралия', 'TH' => 'Таиланд', 'CN' => 'Китайская Народная Республика',
        'MY' => 'Малайзия', 'PK' => 'Пакистан', 'NZ' => 'Новая Зеландия', 'KR' => 'Южная Корея', 'HK' => 'Гонконг',
        'SG' => 'Сингапур', 'BD' => 'Бангладеш', 'ID' => 'Индонезия', 'PH' => 'Филиппины', 'TW' => 'Тайвань',
        'AF' => 'Афганистан', 'VN' => 'Вьетнам', 'VU' => 'Вануату', 'NC' => 'Новая Каледония', 'BN' => 'Бруней',
        'GR' => 'Греция', 'SA' => 'Саудовская Аравия', 'PL' => 'Польша', 'CZ' => 'Чехия', 'RU' => 'Россия',
        'CY' => 'Кипр', 'NO' => 'Норвегия', 'AT' => 'Австрия', 'UA' => 'Украина', 'TJ' => 'Таджикистан',
        'DK' => 'Дания', 'PT' => 'Португалия', 'TR' => 'Турция', 'GE' => 'Грузия', 'BY' => 'Белоруссия',
        'IQ' => 'Ирак', 'AM' => 'Армения', 'LB' => 'Ливан', 'MD' => 'Молдавия', 'BG' => 'Болгария', 'FI' => 'Финляндия',
        'OM' => 'Оман', 'LV' => 'Латвия', 'KZ' => 'Казахстан', 'EE' => 'Эстония', 'SK' => 'Словакия',
        'JO' => 'Иордания', 'HU' => 'Венгрия', 'KW' => 'Кувейт', 'AL' => 'Албания', 'LT' => 'Литва',
        'SM' => 'Сан-Марино', 'BT' => 'Бутан', 'RO' => 'Румыния', 'RS' => 'Сербия',
        'HR' => 'Хорватия',
        'LU' => 'Люксембург',
        'IS' => 'Исландия',
        'LI' => 'Лихтенштейн',
        'CR' => 'Коста-Рика',
        'MK' => 'Македония',
        'MT' => 'Мальта',
        'GM' => 'Гамбия',
        'MW' => 'Малави',
        'SI' => 'Словения',
        'FK' => 'Фолклендские острова',
        'AZ' => 'Азербайджан',
        'MC' => 'Монако',
        'HT' => 'Гаити',
        'GU' => 'Гуам',
        'JM' => 'Ямайка',
        'FM' => 'Федеративные Штаты Микронезии',
        'EC' => 'Эквадор',
        'CO' => 'Колумбия',
        'PE' => 'Перу',
        'KY' => 'Каймановы острова',
        'GP' => 'Гваделупа',
        'HN' => 'Гондурас',
        'YE' => 'Йемен',
        'VG' => 'Британские Виргинские острова',
        'LC' => 'Сент-Люсия',
        'SY' => 'Сирия',
        'NI' => 'Никарагуа',
        'DO' => 'Доминиканская республика',
        'AN' => 'Нидерландские Антильские острова',
        'GT' => 'Гватемала',
        'VE' => 'Венесуэла',
        'BA' => 'Босния и Герцеговина',
        'HM' => 'Острова Херд и Макдоналд',
        'UY' => 'Уругвай',
        'SV' => 'Сальвадор',
        'AE' => 'Объединённые Арабские Эмираты',
        'TT' => 'Тринидад и Тобаго',
        'LK' => 'Шри-Ланка',
        'BV' => 'остров Буве',
        'MH' => 'Маршалловы острова',
        'BH' => 'Бахрейн',
        'CK' => 'Острова Кука',
        'GI' => 'Гибралтар',
        'PY' => 'Парагвай',
        'AG' => 'Антигуа и Барбуда',
        'LS' => 'Лесото',
        'KN' => 'Сент-Китс и Невис',
        'WS' => 'Самоа',
        'PW' => 'Палау',
        'QA' => 'Катар',
        'KH' => 'Камбоджа',
        'AI' => 'Ангилья',
        'AS' => 'Американское Самоа',
        'TC' => 'острова Тёркс и Кайкос',
        'MP' => 'Северные Марианские острова',
        'UZ' => 'Узбекистан',
        'MO' => 'Макао',
        'UM' => 'Внешние малые острова (США)',
        'RE' => 'Реюньон',
        'GY' => 'Гайана',
        'CU' => 'Куба',
        'CG' => 'Республика Конго',
        'BB' => 'Барбадос',
        'LA' => 'Лаос',
        'SR' => 'Суринам',
        'AW' => 'Аруба',
        'FJ' => 'Фиджи',
        'MS' => 'Монсеррат',
        'GD' => 'Гренада',
        'VC' => 'Сент-Винсент и Гренадины',
        'NP' => 'Непал',
        'KG' => 'Киргизстан',
        'ME' => 'Черногория',
        'TD' => 'Чад',
        'FO' => 'Фарерские острова',
        'SO' => 'Сомали',
        'ML' => 'Мали',
        'PS' => 'Палестинская автономия',
        'BI' => 'Бурунди',
        'GN' => 'Гвинея',
        'ET' => 'Эфиопия',
        'KM' => 'Коморские острова',
        'MR' => 'Мавритания',
        'MQ' => 'Мартиника',
        'NE' => 'Нигер',
        'VA' => 'Ватикан',
        'TM' => 'Туркменистан',
        'YT' => 'Майот',
        'BF' => 'Буркина Фасо',
        'AD' => 'Андорра',
        'AQ' => 'Антарктида',
        'GL' => 'Гренландия',
        'WF' => 'острова Уоллис и Футуна',
        'PG' => 'Папуа-Новая Гвинея',
        'MN' => 'Монголия',
        'PF' => 'Французская Полинезия',
        'MV' => 'Мальдивы',
        'CF' => 'Центрально-Африканская Республика',
        'ER' => 'Эритрея',
        'GW' => 'Гвинея-Бисау',
        'DJ' => 'Джибути',
        'GQ' => 'Экваториальная Гвинея',
        'CV' => 'Кабо-Верде',
        'ST' => 'Сан-Томе и Принсипи',
        'GF' => 'Французская Гвиана',
        'SB' => 'Соломоновы острова',
        'TV' => 'Тувалу',
        'KI' => 'Кирибати',
        'TO' => 'Тонга',
        'IO' => 'Британская территория в Индийском океане',
        'NU' => 'Ниуэ',
        'TK' => 'Токелау',
        'NR' => 'Науру',
        'NF' => 'остров Норфолк',
        'MM' => 'Мьянма',
        'KP' => 'КНДР'
    );
    $default = ($default === null) ? $code : $default;
    if ($lang=='eng') {
    	return (array_key_exists($code, $countriesEngNames)) ? $countriesEngNames[$code] : $default;
    }
    return (array_key_exists($code, $countriesNames)) ? $countriesNames[$code] : $default;
}
?>
