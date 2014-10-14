<?php
/*
	PHPbase web framework
	copyright (c) 2003 @authors

	$Id: pay.php,v 0.0.1 08/08/2003 17:38:21 emanuel Exp $
	gateway interafes for payng class
*/

define ("PAY_AUTORIZE" , 1 );
define ("PAY_CAPTURE" , 2 );
define ("PAY_REFUND" , 3 );

require_once _LIBPATH . "pay.paypal.php";

/**
* abstract library class
*
* @library	Library
* @author	Emanuel [Emanuel Giurgea <office@oxylus.ro>]
* @since	PHPbase 0.0.1
*/
class CPay {
	/**
	* unique library identifier
	*
	* @var string
	*
	* @access private
	*/
	var $name;

	
	//merchant email;
	var $merch_email;


	//acces data
	var $username;
	var $password;
	var $saletype;
	var $certificate;
	

	//credit cart data
	var $ccnr;
	var $ccexp;
	var $ccvv;

	//prices
	var $amount;
	var $tax;
	var $shipping;
	var $handling;
	var $taxexcept; //excepting the tax
	
	var $ipaddress; //is logged autmaticaly

	//have no ideea
	var $po;

	//order informations
	var $orderid;
	var $orderdescription;

	//billing user data
	var $firstname;
	var $lastname;
	var $company;
	var $address1;
	var $address2;
	var $city;
	var $state;
	var $zip;
	var $country;
	var $phone;
	var $fax;
	var $email;
	var $website;

	//shipping user data
	var $shipping_firstname;
	var $shipping_lastname;
	var $shipping_company;
	var $shipping_address1;
	var $shipping_address2;
	var $shipping_city;
	var $shipping_state;
	var $shipping_zip;
	var $shipping_country;
	var $shipping_email;

	var $merchant; //avaible authorize, networkmerchants, planetpayment , quickcommerce , quickcommerce , paypal, plugandpay

	var $answer; //the decoded answer from merchant array
	var $rawanswer;  //the answer from merchant string

	var $_aproved; //boolean true if the order was aproved or false if not
	var $_gwerror; // the reason for rejecting the order;
	var $_gwerrornr; // the reason for rejecting the order;
	var $_transid; // transaction id from the merchant
	var $_authcode; //Transaction Authorization Code
	var $_test; //enabled if there will be only a test to the merchant;
	 
	var $url;

	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function SetConnection($url , $port) {
		if ($url)
			$this->url = $url;
		$this->port = $port;
	}
	
	
	
	function SetMerchant($merchant) {

		switch (strtolower($merchant)) {

			case "networkmerchants":
				$this->merchant = "networkmerchants";
				$this->url = "https://secure.networkmerchants.com/gw/api/transact.php";
				$this->port = "443";
			break;

			case "authorize":
				$this->merchant = "authorize";
				$this->url = "https://secure.authorize.net/gateway/transact.dll";
				$this->port = "443";
				//$this->url = "https://certification.authorize.net/gateway/transact.dll";
			break;

			case "planetpayment":
				$this->merchant = "planetpayment";
				$this->url = "https://secure.planetpayment.com/gateway/transact.dll";
				$this->port = "443";
			break;

			case "quickcommerce":
				$this->merchant = "quickcommerce";
				$this->url = "https://secure.quickcommerce.net/gateway/transact.dll";
				$this->port = "443";
			break;

			//unfinished at all
			case "paypal":
				$this->merchant = "paypal";
				$this->url = "https://www.paypal.com/cgi-bin/webscr";
				$this->port = "443";
			break;

			//unfinished, error on server response
			case "linkpoint":
				$this->merchant = "linkpoint";
				$this->url = "https://secure.linkpt.net:1129/LSGSXML";
				$this->certificate = "./linkpoint.pem";
				$this->port = 1129;
				$this->host = "secure.linkpt.net";
			break;

			case "eznp":
				$this->merchant = "eznp";
				$this->url = "https://secure.eznp.com/eznp/transaction.php";
			break;

			case "internationalbilling":
				$this->merchant = "internationalbilling";
				$this->url = "http://www.internationalbilling.net/autoSubmitCard.asp";
			break;

			case "swreg":
				$this->merchant = "sqreg";
				$this->url = "https://swreg.org/cgi-bin/c.cgi";
			break;

			case "monetra":
				$this->merchant = "monetra";
				//this is an engine, not a merchant

				//cheking for their module
				if (extension_loaded("mcve")) {

					//setting the certificate
					MCVE_InitEngine("./CAfile.pem");

					//starting the connection
					$this->conn_id = MCVE_InitConn(); 
						
					//forcing to ssl connections, the most secure
					$err = MCVE_SetSSL($this->conn_id, $this->url, $this->port); 

					//blocking mode ( wait until i get answer from merchant )
					MCVE_SetBlocking ($this->conn_id , 1);

					//checking if the method could be created
					if (!$err)
						die("MCVE:MODULE:Error creating SSL method");

					//estabilishing the connection with server
					$err = MCVE_Connect($this->conn_id);

					//cheking if the connection succeded
					if (!$err)
						die("MCVE:MODULE:Error connecting to server");

					//alocate memoty for a new transaction
					$this->indentifier = MCVE_TransNew($this->conn_id);

				} else {

					//xml method, when they will finish the module
				}
			break;
		}		
	}	

	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function EnableTest() {
		$this->_test = true;
		switch ($this->merchant) {
			case "networkmerchants":
				$this->password = "";
				$this->username = "demo";
			break;

			case "authorize":
				$this->test = true;
			break;

			case "linkpoint":
				//test account
				$this->url = "https://staging.linkpt.net:1129/LSGSXML";
				$this->port = "1129";				
				$this->host = "staging.linkpt.net";

				//oxylus test account
//				$this->username = "1909100898";
//				$this->password = "12345678";
			break;

			case "eznp":
				$this->username = "DemoMerchant";
				$this->password = "demo";
			break;

		}		
	}

	function SetLogin($user , $password) {
		$this->username = $user;
		$this->password = $password;
	}

	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function SetTransactionKey($key) {
		$this->_transid = $key;
	}
	

	function SetOrderInfo($id , $description) {
		$this->orderid = $id;
		$this->orderdescription = $description;
	}

	function SetCertificate($certificate) {
		if (file_exists($certificate))
			$this->certificate = $certificate;
	}

	function SetAction($action) {
		switch ($this->merchant) {
			case "networkmerchants":	
				$this->saletype = $action;
			break;

			case "paypal":
				$this->saletype = $action;
			break;

			case "authorize":
			case "planetpayment":
			case "quickcommerce":
				switch ($action) {
					case 1: $this->saletype = "AUTH_ONLY"; break;
					case 2: $this->saletype = "AUTH_CAPTURE"; break;
					case 3: $this->saletype = "CREDIT"; break;
					default: $this->saletype = "AUTH_CAPTURE"; break;
				}
			break;

			case "eznp":
				switch ($action) {
					default: $this->saletype = "sale";break;
				}				
			break;
		}
	}

	function SetRecurring($amount , $times) {
		$this->recurring = array(
					"action" => "SUBMIT",
					"installments" => $times,
					"startdate" => "immediate",
					"periodicity" => "monthly",
					"threshold"=>3
				);
		$this->amount = $amount;
	}

	function SetPrices($amount, $tax = 0 , $shipping = 0 , $handling = 0 , $tax_except = 0) {
		$this->subtotal = $amount ;
		$this->amount = (float)($amount + $tax + $shipping); //number_format($amount,2,'.','');
		$this->tax = $tax;//number_format($tax,2,'.','');
		$this->shipping = $shipping;//number_format($shipping,2,'.','');
		$this->handling = $handling;//number_format($handling,2,'.','');
		$this->tax_except = $tax_except;
	}

	function SetCCInfo($nr ,$expm , $expy , $ccvv = "" , $no = 0) {
		$this->ccnr = $nr;
		//combined date
		$this->ccexp = $expm . $expy;
		//month and year date
		$this->ccexpm = $expm;
		$this->ccexpy = $expy;
		$this->ccvv = $ccvv;
		$this->po = $no;
	}
	
	function SetBillingInfo( $firstname, $lastname , $company, $address1, $address2 , $city, $state, $zip , $country , $email = "" , $phone = "" , $fax = "" , $site = "") {

		$this->firstname = $firstname;
		$this->lastname = $lastname;
		$this->company = $company;
		$this->address1 = $address1;
		$this->address2 = $address2;
		$this->city = $city;
		$this->state = $state;
		$this->zip = $zip;
		$this->country = $country;
		$this->email = $email;
		$this->phone = $phone;
		$this->fax = $fax;
		$this->website = $site;
	}

	function SetShippingInfo( $firstname, $lastname , $company, $address1, $address2 , $city, $state, $zip , $country , $email = "" , $phone = "" , $fax = "" , $site = "") {

		$this->shipping_firstname = $firstname;
		$this->shipping_lastname = $lastname;
		$this->shipping_company = $company;
		$this->shipping_address1 = $address1;
		$this->shipping_address2 = $address2;
		$this->shipping_city = $city;
		$this->shipping_state = $state;
		$this->shipping_zip = $zip;
		$this->shipping_country = $country;
		$this->shipping_email = $email;
		$this->shipping_phone = $phone;
		$this->shipping_fax = $fax;
		$this->shipping_website = $site;

	}

	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function RefundTransID($id) {
		$this->refund_transid = $id;
	}
	

	function BuildXML ($values , $indent = 0)
	{
	 $indentstring = "\t";

	 for ($i = 0; $i < $indent; $i++)
	   $indentstring .= $indentstring;

	if (is_array($values)) {
		foreach ($values as $key => $var) {
			if (is_array($var))
				$xml .= $indentstring . "<$key>\n" . $this->BuildXML($var , $indent+1) . $indentstring . "</$key>\n";
			else
				if ($var != "")
					$xml .= $indentstring . "<$key>$var</$key>\n";
		}
		
	}
	
	 return $xml;
	}
 
	function CreateQuestion() {
		switch ($this->merchant) {
			case "networkmerchants":
				$question["username"] = $this->username;
				$question["password"] = $this->password;
				$question["saletype"] = $this->saletype;
				$question["ccnumber"] = $this->ccnr;
				$question["cvv"] = $this->ccvv;
				$question["ccexp"] = ($this->ccexpm < 10 ? '0' . $this->ccexpm : $this->ccexpm) . substr($this->ccexpy,0,2);
				$question["amount"] = number_format($this->amount,2);
				$question["shipping"] = $this->shipping;
				$question["tax"] = $this->tax;
				$question["orderid"] = $this->orderid;
				$question["orderdescription"] = $this->orderdescription;
				$question["ponumber"] = $this->po;
				$question["ipaddress"] = $_SERVER["REMOTE_ADDR"];
				$question["firstname"] = $this->firstname;
				$question["lastname"] = $this->lastname;
				$question["company"] = $this->company;
				$question["address1"] = $this->address1;
				$question["address2"] = $this->address2;
				$question["city"] = $this->city;
				$question["state"] = $this->state;
				$question["zip"] = $this->zip;
				$question["country"] = $this->country;
				$question["phone"] = $this->phone;
				$question["fax"] = $this->fax;
				$question["email"] = $this->email;
				$question["website"] = $this->website;
				$question["shipping_firstname"] = $this->shipping_firstname;
				$question["shipping_lastname"] = $this->shipping_lastname;
				$question["shipping_company"] = $this->shipping_company;
				$question["shipping_address1"] = $this->shipping_address1;
				$question["shipping_address2"] = $this->shipping_address2;
				$question["shipping_city"] = $this->shipping_city;
				$question["shipping_state"] = $this->shipping_state;
				$question["shipping_zip"] = $this->shipping_zip;
				$question["shipping_country"] = $this->shipping_country;
				$question["shipping_email"] = $this->shipping_email;

				foreach ($question as $key => $value) 
					$q[] = $key . "=" . urlencode($value);

				return implode ('&' , $q);
			break;


			//this 3 merchants has identical fields
			case "authorize":
			case "planetpayment":
			case "quickcommerce":
			
				$question["x_login"] = $this->username;
				$question["x_password"] = $this->password;
				$question["x_version"] = "3.1";
			
				if ($this->test) 
					$question["x_test_request"] = "TRUE";			

				//AUTH_CAPTURE, AUTH_ONLY, CAPTURE_ONLY, CREDIT, VOID, PRIOR_AUTH_CAPTURE
				//indicates the type of transaction. If the value in the field does not match any of the values stated, the transaction will be rejected.
				//If no value is submitted in this field, the gateway will process the transaction as an AUTH_CAPTURE
				//$question["saletype"] = $this->saletype;

				//Character that will be used to separate fields in the transaction response. The system will use the character passed in this field or the value stored in the Merchant Interface if no value is passed.
				//$question["x_delim_char"] = ",";

				//temporary added for fightads
				$question["x_tran_key"] = $this->_transid;


				$question["x_card_num"] = $this->ccnr;
				$question["x_card_code"] = $this->ccvv;
				$question["x_exp_date"] = $this->ccexp;
				$question["x_amount"] = $this->amount;
				$question["x_freight"] = $this->shipping;
				$question["x_tax"] = $this->tax;
				
				//Indicates whether the transaction is tax exempt.
				$question["x_tax_exempt"] = $this->tax_except;

				$question["x_invoice_num"] = $this->orderid;
				$question["x_description"] = $this->orderdescription;

				$question["x_po_num"] = $this->po;
				
				$question["x_customer_ip"] = $_server["remote_addr"];


				$question["x_first_name"] = $this->firstname;
				$question["x_last_name"] = $this->lastname;
				$question["x_company"] = $this->company;
				$question["x_address"] = $this->address1;
				$question["x_city"] = $this->city;
				$question["x_state"] = $this->state;
				$question["x_zip"] = $this->zip;
				$question["x_country"] = $this->country;
				$question["x_phone"] = $this->phone;
				$question["x_fax"] = $this->fax;
				$question["x_email"] = $this->email;

				//mail the email when order completes
				$question["x_email_customer"] = "FALSE";
				//make option about merchant email
				$question["x_merchant_email"] = $this->merchant_email;

				$question["x_ship_to_first_name"] = $this->shipping_firstname;
				$question["x_ship_to_last_name"] = $this->shipping_lastname;
				$question["x_ship_to_company"] = $this->shipping_company;
				$question["x_ship_to_address"] = $this->shipping_address1;
				$question["x_ship_to_city"] = $this->shipping_city;
				$question["x_ship_to_state"] = $this->shipping_state;
				$question["x_ship_to_zip"] = $this->shipping_zip;
				$question["x_ship_to_country"] = $this->shipping_country;
				$question["x_ship_to_phone"] = $this->shipping_phone;
				$question["x_ship_to_fax"] = $this->shipping_fax;

				$question["x_delim_data"] = "TRUE";
				$question["x_relay_response"] = "FALSE";

				//used only if is a ferunding process
				$question["x_trans_id"] = $this->refund_transid;

				foreach ($question as $key => $value) 
					$q[] = $key . "=" . urlencode($value);


				//debug($q);
			
				return implode ('&' , $q);

			break;

			case "linkpoint":

				//orderoptions
				$xml["order"]["orderoptions"]["ordertype"] = "SALE";
				$xml["order"]["orderoptions"]["result"] = "LIVE";

				//creditcard
				$xml["order"]["creditcard"]["cardnumber"] = $this->ccnr;
				$xml["order"]["creditcard"]["cardexpmonth"] = $this->ccexpm < 10 ? "0" .$this->ccexpm  : $this->ccexpm  ;
				$xml["order"]["creditcard"]["cardexpyear"] = strlen($this->ccexpy) == 4 ? substr($this->ccexpy , 2,2) : $this->ccexpy;
				$xml["order"]["creditcard"]["cvmvalue"] = $this->ccvv;
				$xml["order"]["creditcard"]["cvmindicator"] = ($this->ccvv ? "provided" : "");

				//billing data
				$xml["order"]["billing"]["name"] = $this->firstname . ($this->lastname ? " " . $this->lastname : "");
				$xml["order"]["billing"]["company"] = $this->company;
				$xml["order"]["billing"]["address1"] = $this->address1;
				$xml["order"]["billing"]["address2"] = $this->address2;
				$xml["order"]["billing"]["city"] = $this->city;
				$xml["order"]["billing"]["state"] = $this->state;
				$xml["order"]["billing"]["zip"] = $this->zip;
				$xml["order"]["billing"]["country"] = $this->country;
				$xml["order"]["billing"]["email"] = $this->email;
				$xml["order"]["billing"]["phone"] = $this->phone;
				$xml["order"]["billing"]["fax"] = $this->fax;
				
				//shipping data
				$xml["order"]["shipping"]["name"] = $this->shipping_firstname . " " . $this->shipping_lastname;
				$xml["order"]["shipping"]["address1"] = $this->shipping_address1;
				$xml["order"]["shipping"]["address2"] = $this->shipping_address2;
				$xml["order"]["shipping"]["city"] = $this->shipping_city;
				$xml["order"]["shipping"]["state"] = $this->shipping_state;
				$xml["order"]["shipping"]["zip"] = $this->shipping_zip;
				$xml["order"]["shipping"]["country"] = $this->shipping_country;

				//transaction details								orderid 
				$xml["order"]["transactiondetails"]["oid"] = $this->orderid;
				$xml["order"]["transactiondetails"]["ponumber"] = $this->po;
				$xml["order"]["transactiondetails"]["taxexempt"] = "NO";
				$xml["order"]["transactiondetails"]["terminaltype"] = "UNSPECIFIED";
				$xml["order"]["transactiondetails"]["ip"] = $_SERVER["REMOTE_ADDR"];
				$xml["order"]["transactiondetails"]["transactionorigin"] = "ECI";

				//merchantinfo
				$xml["order"]["merchantinfo"]["configfile"] = $this->username;
				$xml["order"]["merchantinfo"]["keyfile"] = $this->certificate;

				//payment
				$xml["order"]["payment"]["chargetotal"] = $this->amount;
				$xml["order"]["payment"]["tax"] = $this->tax;
				$xml["order"]["payment"]["vattax"] = $this->vattax;
				$xml["order"]["payment"]["shipping"] = $this->shipping;
				$xml["order"]["payment"]["subtotal"] = $this->amount - $this->tax - $this->vattax - $this->shipping;

				if (is_array($this->recurring)) {
					$xml["order"]["periodic"] = $this->recurring;
					$xml["order"]["payment"] = array ("chargetotal" => $this->amount);
				}
				

				$xml = $this->BuildXML ($xml);

				return $xml;
			break;

			case "sqreg":
				$question["s"] = $this->username;
				
				$question["pt"] = 1; //payment type 1-5, find out what everithing means
				$question["cn"] = $this->ccnr; //card number
				$question["in"] = $this->ccvv; //issue number, what the hell this could be
				$question["mm"] = $this->ccexpm; //cc expire month
				$question["yy"] = $this->ccexpy; //cc expire year

				//$question["amount"] = $this->amount;
				//$question["shipping"] = $this->shipping;
				//$question["tax"] = $this->tax;

				//making the orderid to be the product id
				$question["p"] = $this->orderid;
				//$question["orderdescription"] = $this->orderdescription;
				//$question["ponumber"] = $this->po;
				//$question["ipaddress"] = $_SERVER["REMOTE_ADDR"];
				$question["fn"] = $this->firstname;
				$question["sn"] = $this->lastname;
				$question["co"] = $this->company;
				$question["a1"] = $this->address1;
				$question["a2"] = $this->address2;
				$question["city"] = $this->city;
				$question["st"] = $this->state;
				$question["zp"] = $this->zip;
				$question["ct"] = $this->country;
				$question["pn"] = $this->phone;
				$question["em"] = $this->email;

				$question["dfn"] = $this->shipping_firstname;
				$question["dsn"] = $this->shipping_lastname;
				$question["dco"] = $this->shipping_company;
				$question["da1"] = $this->shipping_address1;
				$question["da2"] = $this->shipping_address2;
				//$question["da3"] = $this->shipping_city;

				$question["dst"] = $this->shipping_state;
				$question["dzp"] = $this->shipping_zip;
				$question["dct"] = $this->shipping_country;
				
				//ip address
				$question["ip"] = $_SERVER["REMOTE_ADDR"];
				foreach ($question as $key => $value) 
					$q[] = $key . "=" . urlencode($value);

				return implode ('&' , $q);
			break;

			case "eznp":

				$question["username"] = $this->username;
				$question["password"] = $this->password;
		
				$question["transtype"] = $this->saletype;
				$question["reference"] = $this->orderid;

				$question["cardholdername"] = $this->firstname . " " . $this->lastname;
				$question["address"] = $this->address1 . " " . $this->address2;
				$question["city"] = $this->city;
				$question["state"] = $this->state;
				$question["zip"] = $this->zip;
				$question["country"] = $this->country;
				$question["email"] = $this->email;
				$question["phone"] = $this->phone;

				$question["ipaddress"] = $_SERVER["SERVER_ADDR"];

				$question["amount"] = number_format($this->amount,2);
				$question["cardnumber"] = $this->ccnr;
				$question["cardtype"] = $this->cctype;

				$question["expyear"] = strlen($this->ccexpy) == 4 ? substr($this->ccexpy , 2,2) : $this->ccexpy;
				$question["expmonth"] = $this->ccexpm;
				
				foreach ($question as $key => $value) 
					$q[] = $key . "=" . urlencode($value);
			
				return implode ('&' , $q);

			break;

			case "internationabilling":
/*
userID
	

The userID of one of your users

cardNumber
	

The credit card number – no spaces

cardName
	

The name appearing on the credit card itself

cardExpiry
	

The expiry date of the card in either
myy or mmyy format

cardCVV
	

The CVV number of the card

cardStreet
	

The street address of the card holder

cardCity
	

The city in which the card holder lives

cardState
	

The state in which the card holder lives

cardPostcode
	

As above

cardCountry
	

As above (full name of country)

cardPhone
	

Contact phone number for billing verification

cardEmail
	

An email address for the card holder

cardAmount
	

The amount to bill the card (in $US).
This does NOT include the additional margin added by InternationalBilling.net

cardProduct
	

What is the card holder purchasing 
*/
			break;

			case "monetra":
				if (extension_loaded("mcve")) {


					MCVE_TransParam($this->conn_id , $this->identifier , MC_USERNAME , $this->username);
					MCVE_TransParam($this->conn_id , $this->identifier , MC_PASSWORD , $this->password);

					MCVE_TransParam($this->conn_id , $this->identifier , MC_TRANTYPE, MC_TRAN_SALE);
					MCVE_TransParam($this->conn_id , $this->identifier , MC_ACCOUNT , $this->ccnr);
					MCVE_TransParam($this->conn_id , $this->identifier , MC_EXPDATE , ($this->ccexpm < 10 ? "0" .$this->ccexpm  : $this->ccexpm ) . (strlen($this->ccexpy) == 4 ? substr($this->ccexpy , 2,2) : $this->ccexpy) );

					if ($this->ccvv)
						MCVE_TransParam($this->conn_id , $this->identifier , MC_CV , $this->ccvv );

					MCVE_TransParam($this->conn_id , $this->identifier , MC_AMOUNT , $this->amount);
					MCVE_TransParam($this->conn_id , $this->identifier , MC_PTRANNUM , $this->orderid);

					MCVE_TransParam($this->conn_id , $this->identifier , MC_STREET , $this->address );
					MCVE_TransParam($this->conn_id , $this->identifier , MC_ZIP , $this->zip);

				}				
			break;

		}		
	}

	function ReturnAllData() {

		$user["username"] = $this->username;
		$user["password"] = $this->password;
		
		$price["amount"] = $this->amount;
		$price["shipping"] = $this->shipping;
		$price["tax"] = $this->tax;
		$price["handling"] = $this->handling;

		$order["orderid"] = $this->orderid;
		$order["orderdescription"] = $this->orderdescription;
		$order["ipaddress"] = $_SERVER["REMOTE_ADDR"];

		$billing["firstname"] = $this->firstname;
		$billing["lastname"] = $this->lastname;
		$billing["company"] = $this->company;
		$billing["address1"] = $this->address1;
		$billing["address2"] = $this->address2;
		$billing["city"] = $this->city;
		$billing["state"] = $this->state;
		$billing["zip"] = $this->zip;
		$billing["country"] = $this->country;
		$billing["phone"] = $this->phone;
		$billing["fax"] = $this->fax;
		$billing["email"] = $this->email;
		$billing["website"] = $this->website;

		$shipping["shipping_firstname"] = $this->shipping_firstname;
		$shipping["shipping_lastname"] = $this->shipping_lastname;
		$shipping["shipping_company"] = $this->shipping_company;
		$shipping["shipping_address1"] = $this->shipping_address1;
		$shipping["shipping_address2"] = $this->shipping_address2;
		$shipping["shipping_city"] = $this->shipping_city;
		$shipping["shipping_state"] = $this->shipping_state;
		$shipping["shipping_zip"] = $this->shipping_zip;
		$shipping["shipping_country"] = $this->shipping_country;
		$shipping["shipping_email"] = $this->shipping_email;

		$answer["response"] = $this->_gwerorr;
		$answer["transid"] = $this->_transid;
		$answer["authcode"] = $this->_authcode;
		$answer["aproved"] = $this->_aproved;


		//compacting all data in return 
		$return["all"] = array_merge ($answer , $order, $price , $user , $billing , $shipping);
		
		$return["complex"]["answer"] = $answer;
		$return["complex"]["shipping"] = $shipping;
		$return["complex"]["billing"] = $billing;
		$return["complex"]["price"] = $price;
		$return["complex"]["order"] = $order;
		$return["complex"]["user"] = $user;

		return $return;
	}
	
	function Aproved() {
		return $this->_aproved;
	}

	function TransactionID() {
		return $this->_transid;
	}

	function DecodeAnswer( $answer ) {
		switch ($this->merchant) {

			case "networkmerchants":				

				$_answer = explode("&", $answer);
				$answer = array();
				if (is_array($_answer))				
					foreach ($_answer as $key => $val) {
						$tmp = explode("=" , $val);
						$answer[$tmp[0]] = $tmp[1];
					}
				
				$this->answer = $answer;

				if ($answer["response"] == 1) {
					$this->_aproved = 1;
					$this->_transid = $answer["transactionid"];
					$this->_gwerorr = $answer["responsetext"];
					$this->_authcode = $answer["authcode"];
				} else {

					$this->_aproved = 0;
					$this->_gwerorr = $answer["responsetext"];
					$this->_transid = $answer["transactionid"];
				}
			break;

			case "authorize":
			case "planetpayment":
			case "quickcommerce":

				//atentie, "," poate fi sedtata din campurile de trimitere la merchant, de preferita pus 
				$answer = explode(",", $answer); 
				$this->answer = $answer;


				if ($answer[0] == 1) {
					$this->_aproved = 1;
					$this->_transid = $answer[6];
					$this->_authcode = $answer[4];
				} else {
					$this->_aproved = 0;
					$this->_gwerorr = $answer[3];
					$this->_gwerorrnr = $answer[2];
					$this->_transid = $answer[6];
				}
			break;

			case "linkpoint":

/*
<r_csp>CSI</r_csp>
<r_time>Fri Mar 17 16:13:43 2006</r_time>
<r_ref>0003425523</r_ref>
<r_error></r_error>
<r_ordernum>AC146403-441B42A6-816-66AE8</r_ordernum>
<r_message>APPROVED</r_message>
<r_code>1234560003425523:NNNN:100009808639:</r_code>
<r_tdate>1142636884</r_tdate>
<r_score></r_score>
<r_authresponse></r_authresponse>
<r_approved>APPROVED</r_approved>
<r_avs>NNNN</r_avs>
*/

				$answer = $this->decodeXML($answer);

				$this->answer = $answer ;

				if ($answer["r_approved"] == "APPROVED") {

					$this->_aproved = 1;
					$this->_transid = $answer["r_code"];

				} else {
					$this->_aproved = 0;
					//preprocessing for error number
					//$temp = explode(":" , $answer["r_error"]);

					if ($temp[0] == "CC-4023")
						//preprocessing a little
						$this->_gwerorr = "You have been billed already.";					
					
					$this->gw_error = $temp[0];
					$this->_gwerorr = $answer["r_error"];

				}
			break;

			case "monetra":
				//cheking for their module
				if (extension_loaded("mcve")) {

					
					//MCVE_ReturnStatus($this->conn_id , $this->identifier);
					$code = MCVE_ReturnCode($this->conn_id , $this->identifier);

					if ($code == 2) {
						$this->_aproved = 1;
						$this->_transid = "";
						$this->_authcode = "";
					} else {
						$this->_aproved = 0;
						$this->_gwerorr = "Incorrect data. Please enter your information correct."  . "<br>{ ".mcve_transactiontext($this->conn_id, $this->identifier) . "($code)" . " }";
						$this->_gwerorrnr = $code;
						$this->_transid = $answer[6];
					}

				}
				
			break;

			case "eznp":
				//removing the "
				$answer = str_replace("\"" , "" , $answer);
				//exploding after ,
				$answer = explode(",", $answer); 
				$this->answer = $answer;

				if ($answer[0] == "A") {

					$this->_aproved = 1;
					$this->_transid = $answer[3];

				} else {
					$this->_aproved = 0;
					$this->_gwerorr = $answer[2];
					$this->_gwerorrnr = $answer[1];
					$this->_transid = $answer[3];
				}
			break;
		}		

		//spelling correction, this vars are similar with the missspelled ones
		$this->_gwerror = $this->_gwerorr;
		$this->_gwerrornr = $this->_gwerorrnr;

		return $answer;
	}
	
	function CallMerchant() {
		$question = $this->CreateQuestion();

		switch ($this->merchant) {
			case "monetra":
				//cheking for their module
				if (extension_loaded("mcve")) {

					//sending transaction to server
					$err = MCVE_TransSend($this->conn_id , $this->identifier);

					//cheking if the connection succeded
					if (!$err)
						die("MCVE:MODULE:Not enought data");
				
					return $this->DecodeAnswer($answer);
				}
				
			break;

			default:

				$merchant = curl_init($this->url);

				set_time_limit(0);



				$this->url = "";

				// post back to PayPal system to validate
				$header .= "POST /gateway/transact.dll HTTP/1.0\r\n";
				$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
				$header .= "Content-Length: " . strlen($question) . "\r\n\r\n";
				$fp = fsockopen ('ssl://secure.authorize.net', 443, $errno, $errstr, 30);

				if (!$fp) {
				// HTTP ERROR
				} else {
					fputs ($fp, $header . $question);
					while (!feof($fp)) {
						$answer .= fgets ($fp, 1024);
					}
					fclose ($fp);
				}		

/*

				if (curl_error($merchant))
					//coudnt connect to server
					return _CONNECTION_FAILED;

				//curl_setopt ($merchant, CURLOPT_URL,$this->url);
				curl_setopt ($merchant, CURLOPT_HEADER, 0);
				//curl_setopt ($merchant, CURLOPT_POST, 1);
				curl_setopt ($merchant, CURLOPT_POSTFIELDS,$question); 


				if ($this->certificate) {
					curl_setopt ($merchant, CURLOPT_SSLCERT, $this->certificate);
//					debug(GetFileContents($this->certificate));
				}

				//curl_setopt ($merchant, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt ($merchant, CURLOPT_SSL_VERIFYPEER, FALSE);

				curl_setopt ($merchant, CURLOPT_RETURNTRANSFER, 1);
//				curl_setopt ($merchant, CURLOPT_SSL_VERIFYPEER, 0); 

				$answer = curl_exec ($merchant);

				curl_close ($merchant);

				//saveFileContents("question-" . time() .  ".xml" , $question);
				//saveFileContents("answer-" . time() .  ".xml" , $answer);

*/
				$answer = explode("\n" , $answer);
				$answer = trim($answer[8]);
				
				$this->rawanswer = $answer;
				return $this->DecodeAnswer($answer);

			break;
		}
		
	}
	

	/**
	* constructor which sets the lib`s name
	*
	* @param string $name	unique library identifier
	*
	* @return void
	*
	* @acces public
	*/
	function CPay() {
		$this->name = "pay";
	}

	function decodeXML($xmlstg)
	{
		preg_match_all ("/<(.*?)>(.*?)\</", $xmlstg, $out, PREG_SET_ORDER);
		
		$n = 0;
		while (isset($out[$n]))
		{
			$retarr[$out[$n][1]] = strip_tags($out[$n][0]);
			$n++; 
		}

		return $retarr;
	}


}
/*

Current API Login ID: 	46yQw8Jq
Current Transaction Key: 	44QQ667698tfrZWG


$test = new CPay();
$test->SetMerchant("eznp");
$test->SetLogin("agapecomp1","4GapeGF");
$test->EnableTest();
$test->_transid = "ag5XSSK1s5";
//($nr ,$expm , $expy , $ccvv = "" , $no = 0)
$test->SetCCInfo("4111111111111111","01" , "05","123","334");
$test->SetBillingInfo( "Emanuel","Giurgea","Oxylus.ro","Ion Simionescu 7" , "" , "Iasi" , "NA" , "6600" , "Romania" , "office@oxylus.ro" , "+4 0742094758" , "+4 0742094758" ,"http://oxylus.ro");
$test->SetShippingInfo( "Emanuel","Giurgea","Oxylus.ro","Ion Simionescu 7" , "" , "Iasi" , "NA" , "6600" , "Romania" , "office@oxylus.ro" , "+4 0742094758" , "+4 0742094758" ,"http://oxylus.ro");
$test->SetOrderInfo("1254325" , "YOur order from my new site");
$test->SetAction (PAY_CAPTURE);
$test->SetPrices(108, 20 , 10);
$test->CallMerchant();
$test->Aproved();
echo "<pre style=\"background-color:white\">";
print_r($test->ReturnAllData());
*/
/*
History:

v0.1.6
	Wensdat 28 April 2004
		Added EZNP support.


v0.1.5
	Tuesday 2 February 2004
		Added full support for monetra ( using their php module only, when will apear the xml module 
		will be implemented too), only pay/refund.
		Many thanks to Rusia :)

v0.1.4b
	Saturday 24 January 2004	
		Changed the xml generation for linkpoint
		Changed SetCCInfo, now the expiration month and year are difenret variables
		Certification file must be in ./linkpoint.pem. in case you dont want this to be public use 
		.htaccess to protect it
		Wensday 25 Feb 2004, first client which is using linkpoint with out problems. Seems the problem
		is from linkpoint and from a version of curl not, from this script.

v0.1.4a
	Wednesday 14 January 2004
		Affed support for linkpoint.com, tested with fightads

v0.1.3
	Monday 5 January 2004
		Full support for authorize net and it's resellers, tested and also refound option.

v0.1.2
	Thursday 14 August 2003
		When the order is complete the library sends mail to client and owner withe the order content.


v0.1.1
	Wensday 13 August 2003
		Added support for 3 new merchants authorize.net / planetpayment / quickcommerce, all of them
		are using the same engine as authorize.net


v0.1
	Friday 8 August 2003
		The day when it was created. In the begining it has support for network merchants gateway
		www.networkmerchants.com

*/

?>