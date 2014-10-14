<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus.ro
		mail: support@oxylus.ro		

	$Id: name.php,v 0.0.1 dd/mm/yyyy hh:mm:ss oxylus Exp $
	description
*/

// dependencies

/**
* description
*
* @library	
* @author	
* @since	
*/
class CPaypal{
	
	var $tplvars; 

	var $__conf = array(
				"item_fields" => array(
					"amount" => "amount",
					"item" => "item_name",
					"code" => "item_number",
					"tax" => "tax",
					"qty" => "quantity",
					"weight" => "weight",
					"weight_unit" => "weight_unit",
					"shipping" => "shipping",
					"option_1" => "on0",
					"option_2" => "on1",
					"option_1_value" => "os0",
					"option_2_value" => "os1",
					"discount"	=> "discount_amount"
				),

				"button" => "https://www.paypal.com/en_US/i/btn/x-click-but5.gif",
				"server" => "https://www.paypal.com/cgi-bin/webscr",
				"server_demo" => "https://www.sandbox.paypal.com/cgi-bin/webscr"
	);

	function CPaypal($login) {		
		$this->__fields["business"] = $login;
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
		$this->__conf["server"] = $this->__conf["server_demo"];
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
	function SetCurrency($code) {
		$this->currency_code = $code;
	}
	

	function SetPrices($amount , $shipping = 0, $tax = 0 , $discount=0) {
		$this->__fields["amount"] = number_format($amount , 2);
		$this->__fields["discount_amount"] = number_format($discount , 2);

		if ($shipping) 
			$this->__fields["shipping"] = number_format($shipping , 2);
		
		if ($tax) 
			$this->__fields["tax"] = number_format($tax , 2);
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
	function SetUrls($return , $cancel = null, $notify = null) {

		$this->__fields["return"] = $return;
		if ($cancel)
			$this->__fields["cancel_return"] = $cancel;

		if ($notify)
			$this->__fields["notify_url"] = $notify;

		$this->__fields["currency_code"] = "USD";

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
	function Process() {
		//there is no way i can do it unless write html directly here :((
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
	function OrderInfo($id , $data = array()) {

		//detect if its custom info
		if (is_array($id)) {
			$this->__fields["custom"] = $id["invoice"];

//			if ($id["invoice"]) 
//				$this->__fields["invoice"] = $id["invoice"];
		} else {
			//set the order info
			$this->__fields["custom"] = $id;
		}

		if (is_array($data)) {
			//check if its a single item
			if (!$data[key($data)]) {
				$data = array("1" => $data);

				//make it act as a single product add & proceed
				$count = 0;
				$this->__fields["cmd"] = "_xclick";

				$this->__fields["item_name"] = $id["description"];

				//check for quantity and make it undefined , usefull for informations				

			} else {
				//makt it act like a complex shipping cart.
				$count = 1;
				$this->__fields["cmd"] = "_cart";
				$this->__fields["upload"] = "1";
			}
			

			//build the cart information now
			foreach ($data as $key => $val) {
				$suf = $count == 0 ? "" : "_" . $count;

				foreach ($this->__conf["item_fields"]  as $k => $v) {
					if ($val[$k]) 
						$this->__fields[$v . "{$suf}"] = $val[$k];
				}

				$count ++;
			}
			
			
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
	function __drawform() {

//		$data[] = "<form action=\"{$this->__conf[server]}\" method=\"post\" name=\"pppayment\">\n";

		
		if (is_array($this->__fields)) {
			foreach ($this->__fields as $key => $val) {
				$data []= "<input type=\"hidden\" name=\"{$key}\" value=\"{$val}\"/>" ;
			} 
		}

//		$data[] = "<center><input type='image' src='{$this->__conf[button]}'/></center>";
		
//		$data[]="</form>";

		//$data[] = "<script>function PPSubmit() {document.forms['pppayment'].submit();} setTimeout('PPSubmit()',5000);</script>";

		return implode("\n" , $data);
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
	function IPN() {
		$vars = $_POST;

		$merchant = curl_init();
		set_time_limit(0);

		if (curl_error($merchant))
			//coudnt connect to server
			return _CONNECTION_FAILED;


		if ($vars["payment_status"] != "Completed") {
			//the transaction isnt completd, 
			//need to document in future why.
//			return -1;
		}

		//payment completed so i can continue
		
		//prepare the question
		if (is_array($vars)) {
			$q = array();

			//add the verification var
			$vars["cmd"] = "_notify-validate";

			foreach ($vars as $key => $val) {
				$q[] = $key . "=" . urlencode(stripslashes($val));
			}

			$question = implode('&' , $q);
		}

//		echo "Q: " . $question . "<br>";
		

		curl_setopt ($merchant, CURLOPT_URL,$this->__conf["server"]);
		curl_setopt ($merchant, CURLOPT_HEADER, 0);
		curl_setopt ($merchant, CURLOPT_POST, 1);
		curl_setopt ($merchant, CURLOPT_POSTFIELDS,$question); 

		curl_setopt ($merchant, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($merchant, CURLOPT_SSL_VERIFYPEER, 0);

		curl_setopt ($merchant, CURLOPT_RETURNTRANSFER, 1);

		$answer = curl_exec ($merchant);

		echo "A: " . $answer . "<br>";

		if ($answer == "VERIFIED")
			return $this->ReturnAllData($answer);
		else
			return false;
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
	function ReturnAllData() {

		$data = $_POST;

		return array(
				"order" => array(
					//"orderid" => $data["invoice"],
					"orderdescription" => $data["orderid"],
					"ipaddress" => $_SERVER["REMOTE_ADDR"],
				),
				"billing" => array(
				),
				"shipping" => array(
				),

				"payment" => array(
					"payment_status" => $data["payment_status"],
					"transid" => $data["txn_id"],
					"payment_type" => $data["payment_type"],
					"payment_date" => $data["payment_date"],

					"payer_id" => $data["payer_id"],
					"payer_email" => $data["payer_email"],

					"receiver_id" => $data["receiver_id"],
					"receiver_email" => $data["receiver_email"]

				)					
			);
	}
	

}

/*
$pp_account = "seller_1191584624_per@oxylus.ro";

switch ($_GET["sub"]) {
	case "notify":
		$paypal = new CPaypal($pp_account);
		$paypal->EnableTest();
	break;

	case "pay":
		$test->SetUrls(
			"http://flashcomponents.clients.oxylus-development.com/pp/pp_success.php",
			"http://flashcomponents.clients.oxylus-development.com/pp/pp_cancel.php",
			"http://flashcomponents.clients.oxylus-development.com/pp/pp_notify.php"
		);

		$test->OrderInfo(
			array(
				"id" => "OXD-3412-42323",
				"invoice" => "Flash Component order."

			),
			array( 
				1 => array(
							"item" => "This is a test product" ,
							"code" => "QWT20042",
							"qty" => "2",
							"amount" => "100",
						),
				2 => array(
							"item" => "Another Product" ,
							"code" => "QWT321",
							"qty" => "19",
							"amount" => "20",
						),
				3 => array(
							"item" => "Last Product" ,
							"code" => "QWT20044",
							"qty" => "1",
							"amount" => "10",
							"tax" => "2"
						)
			)
		);

		$test->SetPrices(100);

		echo $test->__drawForm();

		//echo $test->IPN($_GET);

	break;
}



*/


?>