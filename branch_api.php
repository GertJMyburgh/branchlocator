<?php

// GERT MYBURGH 2016/08/20 07:05:00

error_reporting(E_ALL);
ini_set('display_errors', '1');

require("dbinfo.php");

ini_set('max_execution_time', 0); // 0 = No limit, 600 seconds = 10 minutes

date_default_timezone_set("Africa/Johannesburg");

$log_datetime = date('Y-m-d H:i:s');

// TABLE = hollard_branches
// FIELD1  = id
// FIELD2  = province
// FIELD3  = city
// FIELD4  = branch
// FIELD5  = type (Boxer or normal)
// FIELD6  = manager
// FIELD7  = latitude
// FIELD8  = longitute
// FIELD9  = address
// FIELD10 = mapurl

class Branch_api {

    var $url = "";
    var $curl = false;
    var $debug = true;
    var $error = null;

    function __construct() {
        $ver = explode(".", phpversion());
        if (($ver[0] >= 5)) {
            //$this->debug("Version OK ".implode(".", $ver));
            if (!function_exists('json_decode') || !function_exists('json_encode')) {
                $this->debug("You need the json_encode and json_decode functions to use this Class, JSON is available in PHP 5.2.0 and up for alternatives please see http://json.org");
                $this->debug("Your PHP version is ".implode(".", $ver)." ".__FILE__);
                die();
            }
        } else {
            $this->debug("You need at least PHP 5 to use this Class ".__FILE__);
            die();
        }
    }
    
    function getProvinces() {

        try {
            $pdo = new PDO("mysql:host=" . DBHOST . ";port=3306;dbname=" . DBNAME, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "\r\n{$e->getMessage()}\r\n";
            exit;
        }

        try {
            $stmt = $pdo->prepare("SELECT DISTINCT province FROM hollard_branches");
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "\r\n{$e->getMessage()}\r\n";
        }

        // set PDO to null in order to close the connection
        $pdo = null;

        return $records;
        
    }
    
    function getCities($province) {
        
        try {
            $pdo = new PDO("mysql:host=" . DBHOST . ";port=3306;dbname=" . DBNAME, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "\r\n{$e->getMessage()}\r\n";
            exit;
        }

        try {
            $stmt = $pdo->prepare("SELECT DISTINCT province, city FROM hollard_branches WHERE province=:province");
            $stmt->bindValue(':province', $province, PDO::PARAM_STR);
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "\r\n{$e->getMessage()}\r\n";
        }
        
        // set PDO to null in order to close the connection
        $pdo = null;

        return $records;
        
    }

    function getCityInfo($province, $city) {
        
        try {
            $pdo = new PDO("mysql:host=" . DBHOST . ";port=3306;dbname=" . DBNAME, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "\r\n{$e->getMessage()}\r\n";
            exit;
        }

        try {
            $stmt = $pdo->prepare("SELECT branch, type, manager, address, mapurl FROM hollard_branches WHERE province=:province AND city=:city");
            $stmt->bindValue(':province', $province, PDO::PARAM_STR);
            $stmt->bindValue(':city', $city, PDO::PARAM_STR);
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "\r\n{$e->getMessage()}\r\n";
        }
        
        // set PDO to null in order to close the connection
        $pdo = null;

        return $records;
        
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
            $stmt = $pdo->prepare("SELECT count(*) AS totalRecords FROM hollard_branches");
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

    function IsNullOrEmptyString($value) {
        return (!isset($value) || trim($value) === '');
    }

    public function send_email($to = NULL, $title = NULL, $subject = NULL, $message = NULL) {

        $log_datetime = date("Y-m-d H:i:s");

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
            echo "[{$log_datetime}] Email successfully send.\r\n";
            return true;
        } else {
            echo "[{$log_datetime}] Email send error occurred: $this->email->print_debugger()\r\n";
            return false;
        }
    }

    public function prettyPrint($objName = '', $objValue = NULL) {
        $s = "\n";
        $s .= "<pre>";
        $s .= "<b>" . $objName . " = " . "</b>" . print_r($objValue, TRUE);
        $s .= "</pre>";
        echo $s;
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
