<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Payment extends REST_Controller {
  public function __construct() { 

    parent::__construct();
    $this->load->model('Api/LoanApiModel');
  }



  public function Paytm_post()
  {
  	$MID = $this->post('MID');
  	$ORDER_ID = $this->post('ORDER_ID');
  	$CUST_ID = $this->post('CUST_ID');
  	$INDUSTRY_TYPE_ID = $this->post('INDUSTRY_TYPE_ID');
  	$CHANNEL_ID = $this->post('CHANNEL_ID');
  	$TXN_AMOUNT = $this->post('TXN_AMOUNT');
  	$CALLBACK_URL = $this->post('CALLBACK_URL');
  	$WEBSITE = $this->post('WEBSITE');

	header("Pragma: no-cache");
	header("Cache-Control: no-cache");
	header("Expires: 0");
	// following files need to be included
	
	require_once(APPPATH.'libraries/lib/config_paytm.php');
	require_once(APPPATH.'libraries/lib/encdec_paytm.php');
	$checkSum = "";

	// below code snippet is mandatory, so that no one can use your checksumgeneration url for other purpose .
	$findme   = 'REFUND';
	$findmepipe = '|';

	$paramList = array();

	$paramList["MID"] = $MID;
	$paramList["ORDER_ID"] = $ORDER_ID;
	$paramList["CUST_ID"] = $CUST_ID;
	$paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
	$paramList["CHANNEL_ID"] = $CHANNEL_ID;
	$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
	$paramList["CALLBACK_URL"] = $CALLBACK_URL;
	$paramList["WEBSITE"] = $WEBSITE;

	foreach($this->post() as $key=>$value)
	{  
		$pos = strpos($value, $findme);
		$pospipe = strpos($value, $findmepipe);
		if ($pos === false || $pospipe === false) 
		{
			$paramList[$key] = $value;
		}
	}



	//Here checksum string will return by getChecksumFromArray() function.
	$checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
	//print_r($_POST);
	// echo json_encode(array("CHECKSUMHASH" => $checkSum,"ORDER_ID" => $_POST["ORDER_ID"],"CALLBACK_URL" => $_POST["CALLBACK_URL"], "payt_STATUS" => "1"));

 
	  	$this->response([
            'status' => FALSE,
            'message' => "Provide email and password.",
            'CHECKSUMHASH'=>$checkSum,
            'ORDER_ID'=>$this->post('ORDER_ID'),
            "CALLBACK_URL" =>$_POST['CALLBACK_URL'],
            "payt_STATUS" => "1"
        ],REST_Controller::HTTP_OK);

  	}


  	public function PaymentHistory_post(){
  		$UserId = $this->post('UserId');
  		$PaymentHistoryData = $this->LoanApiModel->getPaymentHistory($UserId);
  		$this->response([
        'status' => TRUE,
        'result' =>$PaymentHistoryData,
        'message' => 'Password Changed',
        ], REST_Controller::HTTP_OK); 
  	}
 
}
