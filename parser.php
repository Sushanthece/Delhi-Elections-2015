<?php 

spl_autoload_register(
    function($className)
    {
        $className = str_replace("_", "\\", $className);
        $className = ltrim($className, '\\');
        $fileName = '';
        $namespace = '';
        if ($lastNsPos = strripos($className, '\\'))
        {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        if(strpos($namespace, 'PHPHtmlParser') !== false){
        	
        }

        require $fileName;
        
    }
);

//https://github.com/paquettg/php-html-parser
use PHPHtmlParser\Dom;

$Constituencies = array(
		"4"=>"ADARSH NAGAR",
		"48"=>"AMBEDKAR NAGAR",
		"67"=>"BABARPUR",
		"53"=>"BADARPUR",
		"5"=>"BADLI",
		"22"=>"BALLIMARAN",
		"7"=>"BAWANA",
		"36"=>"BIJWASAN",
		"2"=>"BURARI",
		"20"=>"CHANDNI CHOWK",
		"46"=>"CHHATARPUR",
		"38"=>"DELHI CANTT",
		"47"=>"DEOLI",
		"33"=>"DWARKA",
		"61"=>"GANDHI NAGAR",
		"66"=>"GHONDA",
		"68"=>"GOKALPUR",
		"50"=>"GREATER KAILASH",
		"28"=>"HARI NAGAR",
		"30"=>"JANAKPURI",
		"41"=>"JANGPURA",
		"51"=>"KALKAJI",
		"70"=>"KARAWAL NAGAR",
		"23"=>"KAROL BAGH",
		"42"=>"KASTURBA NAGAR",
		"9"=>"KIRARI",
		"56"=>"KONDLI",
		"60"=>"KRISHNA NAGAR",
		"58"=>"LAXMI NAGAR",
		"26"=>"MADIPUR",
		"43"=>"MALVIYA NAGAR",
		"12"=>"MANGOL PURI",
		"21"=>"MATIA MAHAL",
		"34"=>"MATIALA",
		"45"=>"MEHRAULI",
		"18"=>"MODEL TOWN",
		"25"=>"MOTI NAGAR",
		"8"=>"MUNDKA",
		"69"=>"MUSTAFABAD",
		"35"=>"NAJAFGARH",
		"11"=>"NANGLOI JAT",
		"1"=>"NERELA",
		"40"=>"NEW DELHI",
		"54"=>"OKHLA",
		"37"=>"PALAM",
		"24"=>"PATEL NAGAR",
		"57"=>"PATPARGANJ",
		"44"=>"R K PURAM",
		"39"=>"RAJINDER NAGAR",
		"27"=>"RAJOURI GARDEN",
		"6"=>"RITHALA",
		"13"=>"ROHINI",
		"64"=>"ROHTAS NAGAR",
		"19"=>"SADAR BAZAR",
		"49"=>"SANGAM VIHAR",
		"65"=>"SEELAMPUR",
		"63"=>"SEEMA PURI",
		"62"=>"SHAHDARA",
		"15"=>"SHAKUR BASTI",
		"14"=>"SHALIMAR BAGH",
		"10"=>"SULTANPUR MAJRA",
		"29"=>"TILAK NAGAR",
		"3"=>"TIMARPUR",
		"16"=>"TRI NAGAR",
		"55"=>"TRILOKPURI",
		"52"=>"TUGHLAKABAD",
		"32"=>"UTTAM NAGAR",
		"31"=>"VIKASPURI",
		"59"=>"VISHWAS NAGAR",
		"17"=>"WAZIRPUR"
	);


$result = array();

foreach ($Constituencies as $code => $constituency_name) {

	$constituency = array();

	$constituency['code'] = $code;
	$constituency['name'] = ucwords(strtolower($constituency_name));

	$dom = new Dom;

	$dom->loadFromUrl("http://eciresults.nic.in/ConstituencywiseU05$code.htm");

	$rows = $dom->find(' table table table table tr');

	$candidates = array();

	foreach ($rows as $row){

	    $tds = $row->find('td');

	    if(count($tds) === 3){
	    	$candidate = array();
	    	$candidate['candidate'] = ucwords(strtolower($tds[0]->innerHtml));
	    	$candidate['party'] = $tds[1]->innerHtml;
	    	$candidate['votes'] = $tds[2]->innerHtml;
	    	$candidates[] = $candidate;
	    }
	    
	}

	$constituency['result'] = $candidates;

	$result[] = $constituency;
}



header('content-type: application/json; charset=utf-8');
echo json_encode($result);
