<?php
    require_once "model.php";
    class ProductModel extends BaseModel {
        public string $productName;

        public function __construct(string $tableName): void {
            parent::__construct($tableName);
        }

        private function isContainSpecialChars(string $str): bool {
            if (preg_match("/[^a-zA-Z0-9]/", $str)) return true;
            return false;
        }

        public function validate($data): bool {
            if (empty($data)) return false;
            $countryISOCode = [
                "Afghanistan" => "AF",
                "Albania" => "AL",
                "Algeria" => "DZ",
                "America Samoa" => "AS",
                "Andorra" => "AD",
                "Angola" => "AO",
                "Anguilla" => "AI",
                "Antarctica" => "AQ",
                "Antigua and Barbuda" => "AG",
                "Argentina" => "AR",
                "Armenia" => "AM",
                "Aruba" => "AW",
                "Australia" => "AU", 
                "Austria" => "AT",
                "Azerbaijan" => "AZ",
                "Bahamas" => "BS",
                "Bahrain" => "BH",
                "Bangladesh" => "BD",
                "Barbados" => "BB",
                "Belarus" => "BY",
                "Belgium" => "BE",
                "Belize" => "BZ",
                "Benin" => "BJ",
                "Bermuda" => "BM",
                "Bhutan" => "BT",
                "Bolivia" => "BO",
                "Bosnia and Herzegovina" => "BA",
                "Bostwana" => "BW",
                "Brazil" => "BR",
                "British Indian Ocean Territory" => "IO",
                "British Virgin Island" => "VG",
                "Brunei" => "BN",
                "Bulgaria" => "BG",
                "Burkina Faso" => "BF",
                "Burundi" => "BI",
                "Cambodia" => "KH",
                "Cameroon" => "CM",
                "Canada" => "CA",
                "Cape Verde" => "CV",
                "Cayman Islands" => "KY",
                "Central African Republic" => "CF",
                "Chad" => "TD",
                "Chile" => "CL",
                "China" => "CN",
                "Christmas Island" => "CX",
                "Cocos Islands" => "CC",
                "Colombia" => "CO",
                "Comoros" => "KM",
                "Cook Islands" => "CK",
                "Costa Rica" => "CR",
                "Croatia" => "HR",
                "Cuba" => "CU",
                "Curacao" => "CW",
                "Cyprus" => "CY",
                "Czech Republic" => "CZ",
                "Democratic Republic of the Congo" => "CD",
                "Demark" => "DK",
                "Djibouti" => "DJ",
                "Dominica" => "DM",
                "Dominican Republic" => "DO",
                "East Timor" => "TL",
                "Ecuador" => "EC",
                "Egypt" => "EG",
                "El Salvador" => "SV",
                "Equatorial Guinea" => "GQ",
                "Eritrea" => "ER",
                "Estonia" => "EE",
                "Ethiopia" => "ET",
                "Falkland Islands" => "FK",
                "Faroe Islands" => "FO",
                "Fiji" => "FJ",
                "Finland" => "FI",
                "France" => "FR",
                "French Polynesia" => "PF",
                "Gabon" => "GA",
                "Gambia" => "GA",
                "Georgia" => "GE",
                "Germany" => "DE",
                "Ghana" => "GH",
                "Gibralta" => "GI",
                "Greece" => "GR",
                "Greenland" => "GL",
                "Grenada" => "GD",
                "Guam" => "GU",
                "Guatemala" => "GT",
                "Guernsey" => "GG",
                "Guinea" => "GN",
                "Guinea-Bissau" => "GW",
                "Guyana" => "GY",
                "Haiti" => "HT",
                "Honduras" => "HN",
                "Hong Kong" => "HK",
                "Hungary" => "HU",
                "Iceland" => "IS",
                "India" => "IN",
                "Indonesia" => "ID",
                "Iran" => "IR",
                "Iraq" => "IQ",
                "Ireland" => "IE",
                "Isle of Man" => "IM",
                "Israel" => "IL",
                "Italy" => "IT",
                "Ivory Coast" => "CI",
                "Jamaica" => "JM",
                "Japan" => "JP",
                "Jersey" => "JE",
                "Jordan" => "JO",
                "Kazakhstan" => "KZ",
                "Kenya" => "KE",
                "Kiribati" => "KI",
                "Kosovo" => "XK",
                "Kuwait" => "KW",
                "Kyrgyzstan" => "KG",
                "Laos" => "LA",
                "Latvia" => "LV",
                "Lebanon" => "LB",
                "Lesotho" => "LS",
                "Liberia" => "LR",
                "Libya" => "LY",
                "Liechtenstein" => "LI",
                "Lithuania" => "LT",
                "Luxembourg" => "LU",
                "Macau" => "MO",
                "Macedonia" => "MK",
                "Madagascar" => "MG",
                "Malawi" => "MW",
                "Malaysia" => "MY",
                "Maldives" => "MV",
                "Mali" => "ML",
                "Malta" => "MT",
                "Marshall Island" => "MH",
                "Mauritania" => "MR",
                "Mauritius" => "MU",
                "Mayotte" => "YT",
                "Mexico" => "MX",
                "Micronesia" => "FM",
                "Moldova" => "MD",
                "Monaco" => "MC",
                "Mongolia" => "MN",
                "Montenegro" => "ME",
                "Montserrat" => "MS",
                "Moroco" => "MA",
                "Mozambique" => "MZ",
                "Myanmar" => "MM",
                "Namibia" => "NA",
                "Nauru" => "NR",
                "Nepal" => "NP",
                "Netherlands" => "NL",
                "Netherlands Antilles" => "AN",
                "New Caledonia" => "NC",
                "New Zealand" => "NZ",
                "Nicaragua" => "NI",
                "Niger" => "NE",
                "Nigeria" => "NG",
                "Niue" => "NU",
                "North Korea" => "KP",
                "Northern Mariana Island" => "MP",
                "Norway" => "NO",
                "Oman" => "OM",
                "Pakistan" => "PK",
                "Palau" => "PW",
                "Palestine" => "PS",
                "Panama" => "PA",
                "Papua New Guinea" => "PG",
                "Paraguay" => "PY",
                "Peru" => "PE",
                "Philippines" => "PH",
                "Pitcairn" => "PN",
                "Poland" => "PL",
                "Portugal" => "PT",
                "Puerto Rico" => "PR",
                "Qatar" => "QA",
                "Republic of the Congo" => "CG",
                "Reunion" => "RE",
                "Romania" => "RO",
                "Russia" => "RU",
                "Rwanda" => "RW",
                "Saint Barthelemy" => "BL",
                "Saint Helena" => "SH",
                "Saint Kitts and Nevis" => "KN",
                "Saint Lucia" => "LC",
                "Saint Martin" => "MF",
                "Saint Pierre and Miquelon" => "PM",
                "Saint Vincent and the Grenadines" => "VC",
                "Samoa" => "WS",
                "San Marino" => "SM",
                "Sao Tome and Principe" => "ST",
                "Saudi Arabia" => "SA",
                "Senegal" => "SN",
                "Serbia" => "RS",
                "Seychelles" => "SC",
                "Sierra Leone" => "SL",
                "Singapore" => "SG",
                "Sint Maarten" => "SX",
                "Slovakia" => "SK",
                "Slovenia" => "SI",
                "Solomon Islands" => "SB",
                "Somalia" => "SO",
                "South Africa" => "ZA",
                "South Korea" => "KR",
                "South Sudan" => "SS",
                "Spain" => "ES",
                "Sri Lanka" => "LK",
                "Sudan" => "SD",
                "Suriname" => "SR",
                "Svalbard and Jan Mayen" => "SJ",
                "Swaziland" => "SZ",
                "Sweeden" => "SE",
                "Switzerland" => "CH",
                "Syria" => "SY",
                "Taiwan" => "TW",
                "Tajikistan" => "TJ",
                "Tanzania" => "TZ",
                "Thailand" => "TH",
                "Togo" => "TG",
                "Tokelau" => "TK",
                "Tonga" => "TO",
                "Trinidad and Tobago" => "TT",
                "Tunisia" => "TN",
                "Turkey" => "TR",
                "Turkmenistan" => "TM",
                "Turks and Caicos Islands" => "TC",
                "Tuvalu" => "TV",
                "U.S. Virgin Islands" => "VI",
                "Uganda" => "UG",
                "Ukraine" => "UA",
                "United Arab Emirates" => "AE",
                "United Kingdom" => "GB",
                "United States" => "US",
                "Uruguay" => "UY",
                "Uzbekistan" => "UZ",
                "Vanuatu" => "VU",
                "Vatican" => "VA",
                "Venezuela" => "VE",
                "Vietnam" => "VN",
                "Wallis and Futuna" => "WF",
                "Western Sahara" => "EH",
                "Yemen" => "YE",
                "Zambia" => "ZM",
                "Zimbabwe" => "ZW"  
            ];
            $name = $data["name"];
            $category = $data["category"];
            $quantity = $data["quantity"];
            $origin = $data["origin"];

            if ($this->isContainSpecialChars($name)
                || $this->isContainSpecialChars($category) 
                || $this->isContainSpecialChars($origin)) return false;
            
            if ($quantity < 0 || gettype($quantity) !== "integer") return false;
            if (!isset($countryISOCode[$origin])) return false;

            return true;

        }

        public function add($data): void {
            $isDataValidated = $this->validate($data);
            if (!$isDataValidated) return;
            $tableName = parent::getTableName();
            $keys = array_keys($data);
            $vals = array_values($data);
            $bindingParams = implode(" , ", array_map(function($key) {
                return ":{$key}";
            }, $keys));
            $insertedCols = implode(" , ", array_map(function($key) {
                return "{$key}";
            }, $keys));
            $query = "
                insert into
                {$tableName} ($insertedCols)
                values ({$bindingParams})
            ";
            $params = [];
            for ($i = 0; $i < count($keys); $i++) {
                $params[":{$keys[$i]}"] = $vals[$i];
            }
            $stmt = (parent::getDBConnection())->prepare($query);
            if ($stmt->execute($params)) {
                // Success
                echo "<div>Added a new product!</div>";
            } else {
                // Failure
                echo "<div>Failed to add new product!</div>";
            }
        }

        
    }
?>