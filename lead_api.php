<?php

// GERT MYBURGH 2016/08/20 07:05:00

error_reporting(E_ALL);
ini_set('display_errors', '1');

require("dbinfo.php");

ini_set('max_execution_time', 0); // 0 = No limit, 600 seconds = 10 minutes

date_default_timezone_set("Africa/Johannesburg");

$dateTimeStamp = date('Y-m-d H:i:s');

// TABLE = hollard_leads
// FIELD2 = nameSurname
// FIELD3 = phoneNumber
// FIELD4 = product
// FIELD5 = origin <<== From which form is this request comming?

class Lead_api {

    var $url = "";
    var $curl = false;
    var $debug = true;
    var $error = null;

    function __construct() {
        $ver = explode(".", phpversion());
        if(($ver[0] >= 5)) {
            // $this->debug("Version OK ".implode(".", $ver));
            if(!function_exists('json_decode') || !function_exists('json_encode')) {
                $this->debug("You need the json_encode and json_decode functions to use this Class, JSON is available in PHP 5.2.0 and up for alternatives please see http://json.org");
                $this->debug("Your PHP version is ".implode(".", $ver)." ".__FILE__);
                die();
            }
        } else {
            $this->debug("You need at least PHP 5 to use this Class ".__FILE__);
            die();
        }
    }
    
    function insertLead($nameSurname, $phoneNumber, $product, $origin) {
        $this->saveLead("hollard_leads", $nameSurname, $phoneNumber, $product, $origin);
        $this->callURL($nameSurname, $phoneNumber, $product);
    }

    function countDBRecords() {

        $countDBRecords = 0;

        try {
            $pdo = new PDO("mysql:host=" . DBHOST . ";port=3306;dbname=" . DBNAME, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "\r\n{$e->getMessage()}\r\n";
            exit;
        }

        try {
            $stmt = $pdo->prepare("SELECT count(*) AS totalRecords FROM hollapsvdy_db1.hollard_leads");
            $stmt->execute();
            $row = $stmt->fetch();
            $countDBRecords = $row["totalRecords"];
        } catch (PDOException $e) {
            echo "\r\n{$e->getMessage()}\r\n";
        }

        // set PDO to null in order to close the connection
        $pdo = null;

        return $countDBRecords;
    }

    function saveLead($tableName, $nameSurname, $phoneNumber, $product, $origin) {

        $dateTimeStamp = date('Y-m-d H:i:s');

        try {
            $pdo = new PDO("mysql:host=" . DBHOST . ";port=3306;dbname=" . DBNAME, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "\r\n{$e->getMessage()}\r\n";
            exit;
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO {$tableName}(nameSurname, phoneNumber, product, activeTimeStamp, origin)
                VALUES(:nameSurname, :phoneNumber, :product, :activeTimeStamp, :origin)");
            $stmt->execute(array(
                "nameSurname" => $nameSurname,
                "phoneNumber" => $phoneNumber,
                "product" => $product,
                "activeTimeStamp" => $dateTimeStamp,
                "origin" => $origin
            ));

        } catch (PDOException $e) {
            echo "\r\n{$e->getMessage()}\r\n";
        }

        // set PDO to null in order to close the connection
        $pdo = null;
    }

    function IsNullOrEmptyString($value) {
        return (!isset($value) || trim($value) === '');
    }

    function callURL($nameSurname, $phoneNumber, $product) {

        $dateTimeStamp = date('Y-m-d H:i:s');
        $continue = false;
        $allData = array();
        $strData = "";

        if ($product === "Funeral") {

            $allData = array
                (
                "affID" => "THRIVE",
                "fID" => "147",
                "sID" => "11",
                "lID" => "2",
                "SourceID" => "RMM External Vendor Siebel",
                "ChannelID" => "",
                "ProductName" => "CRMSMS",
                "AutoDistributeYN" => "0",
                "subjectLine" => "HOLLARD THRIVE TEST Lead",
                "p1" => "Funeral",
                "competition" => "0",
                "publisher" => "HOLLARD",
                "refPrefix" => "LRP",
                "contactable" => "YES",
                "cURL" => "",
                "recipient" => "curtis@thrivemedia.co.za",
                "banner_size" => "300x250",
                "cellNo" => $phoneNumber,
                "name" => $nameSurname,
                "surname" => "lead",
                "altNo" => "",
                "email" => "curtis@thrivemedia.co.za",
                "ID" => "6407089237708",
                "cNAME" => "HCC_DIRECTORY_FUNERAL",
                "client" => "HOLLARD"
            );
            $insertURL = "https://www.thriveonline.co.za/LRP/InsertFuneralLead.php?" . http_build_query($allData, "", "&");
            $continue = true;
            
        } elseif ($product === "Legal") {

            $allData = array
                (
                "affID" => "THRIVE",
                "fID" => "147",
                "sID" => "11",
                "lID" => "2",
                "SourceID" => "RMM External Vendor Siebel",
                "ChannelID" => "",
                "ProductName" => "CRMSMS",
                "AutoDistributeYN" => "0",
                "subjectLine" => "HOLLARD THRIVE TEST Lead",
                "p1" => "Legal",
                "competition" => "0",
                "publisher" => "HOLLARD",
                "refPrefix" => "LRP",
                "contactable" => "YES",
                "cURL" => "",
                "recipient" => "curtis@thrivemedia.co.za",
                "banner_size" => "300x250",
                "cellNo" => $phoneNumber,
                "name" => $nameSurname,
                "surname" => "lead",
                "altNo" => "",
                "email" => "curtis@thrivemedia.co.za",
                "ID" => "6407089237708",
                "cNAME" => "HCC_DIRECTORY_LEGAL",
                "client" => "HOLLARD"
            );
            $insertURL = "https://www.thriveonline.co.za/LRP/InsertFuneralLead.php?" . http_build_query($allData, "", "&");
            $continue = true;
            
        } elseif ($product === "Life") {

            $allData = array
                (
                "affID" => "THRIVE",
                "fID" => "147",
                "sID" => "11",
                "lID" => "2",
                "SourceID" => "RMM External Vendor Siebel",
                "ChannelID" => "",
                "ProductName" => "CRMSMS",
                "AutoDistributeYN" => "0",
                "subjectLine" => "HOLLARD THRIVE TEST Lead",
                "p1" => "Life",
                "competition" => "0",
                "publisher" => "HOLLARD",
                "refPrefix" => "LRP",
                "contactable" => "YES",
                "cURL" => "",
                "recipient" => "curtis@thrivemedia.co.za",
                "banner_size" => "300x250",
                "cellNo" => $phoneNumber,
                "name" => $nameSurname,
                "surname" => "lead",
                "altNo" => "",
                "email" => "curtis@thrivemedia.co.za",
                "ID" => "6407089237708",
                "cNAME" => "HCC_DIRECTORY_LIFE",
                "client" => "HOLLARD"
            );
            $insertURL = "https://www.thriveonline.co.za/LRP/InsertFuneralLead.php?" . http_build_query($allData, "", "&");
            $continue = true;
            
        } else {
            $continue = false;
        }

        if ($continue) {

            if (class_exists('HttpRequest')) {

                $r = new HttpRequest($insertURL, HttpRequest::METH_POST);
                $r->addPostFields($allData);

                try {
                    $r->send()->getBody();
                } catch (HttpException $ex) {
                    echo 'HttpRequest ERROR ' . $ex . "\r\n";
                }

            } else {

                if (function_exists('curl_version')) {
                    // 1. Initialise CURL
                    $curlHandle = curl_init();
                    // 2. Set options
                    // 2.1. URL to send the request to
                    curl_setopt($curlHandle, CURLOPT_URL, $insertURL);
                    // 2.2. Return instead of outputting directly
                    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
                    // 2.3. Whether to include the header in the output. Set to false here
                    curl_setopt($curlHandle, CURLOPT_HEADER, 0);
                    // Above we add our values that we need to pass to the query string that
                    // will be passed as part of the URL that we are calling. You can however
                    // perform a POST and use $_POST on the other side where the values are passed to.
                    // Do a POST request
                    // curl_setopt($curlHandle, CURLOPT_POST, 1);
                    // Adding the POST variables to the request
                    // curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $allData);
                    // 3. Execute the request and fetch the response.
                    $response = curl_exec($curlHandle);
                    // 4. Check for errors
                    if ($response === FALSE) {
                        echo "cURL Error: " . curl_error($curlHandle);
                    }
                    // 5. Close and free up the curl handle                    
                    curl_close($curlHandle);
                    // 6. Display raw output
                    // echo "<pre>";
                    // print_r($response);
                    // echo "</pre>";
                } else if (file_get_contents(__FILE__) && ini_get('allow_url_fopen')) {
                    $xml = new SimpleXMLElement(file_get_contents($insertURL));
                } else {
                    echo '[' . $dateTimeStamp . '] ' . 'You have neither cUrl installed nor allow_url_fopen activated. Please setup one of those!' . "\r\n";
                    exit;
                }
            }
        }
    }

    public function send_email($to = NULL, $title = NULL, $subject = NULL, $message = NULL) {

        $dateTimeStamp = date("Y-m-d H:i:s");

        if (empty($to) || empty($subject) || empty($message)) {
            return false;
        }

        $this->load->library("email");

        // Initializes all the email variables to an empty state. This function is intended for use if you run
        // the email sending function in a loop, permitting the data to be reset between cycles.
        $this->email->clear();

        // If you set the parameter to TRUE any attachments will be cleared as well:
        // $this->email->clear(TRUE);

        $this->email->from("gert@thrivetech.co.za", "ThriveTechnology");
        $this->email->to($to);
        // $this->email->cc("gert@thrivetech.co.za");
        $this->email->set_mailtype("html");
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            echo "[{$dateTimeStamp}] Email successfully send.\r\n";
            return true;
        } else {
            echo "[{$dateTimeStamp}] Email send error occurred: $this->email->print_debugger()\r\n";
            return false;
        }
    }

    public function myEcho($objName = '', $objValue = NULL) {
        $s = "\n";
        $s .= "<pre>";
        $s .= "<b>" . $objName . " = " . "</b>" . var_export($objValue, TRUE);
        $s .= "</pre>";
        echo $s;

        if ($_POST) {
            echo '<pre>';
            echo htmlspecialchars(print_r($_POST, true));
            echo '</pre>';
        }
    }

    function getError() {
        return $this->error;
    }

    function debug($str, $nl = true) {
        if ($this->debug) {
            echo $str;
            if ($nl) {
                echo "\n";
            }
        }
    }

}

?>
