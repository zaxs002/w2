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
class COXYMallShop extends CPlugin{	
	
	var $tplvars; 

	function COXYMallShop() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();


		if (strstr($_GET["sub"] , "oxymall.plugin.shop.")) {

			$sub = str_replace("oxymall.plugin.shop." , "" ,$_GET["sub"]);
			$action = $_GET["action"];

			$this->__init();

			switch ($sub) {

				case "store":

					return $this->StoreOrder($this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:shop_accounts']} WHERE item_code='authorize'"));

				case "ajax.addcart":
					return $this->AddToCart();
				break;

				case "ajax.summary":
					return $this->AjaxSummary();
				break;

				case "ajax.cart":
					return $this->AjaxSummary($this->private->templates["order-cart"]);
				break;

				case "cart":
					return $this->ViewCart();
				break;

				case "checkout":
					$this->cartEmptyCheck();
					return $this->Billing();
				break;

				case "shipping":
					$this->cartEmptyCheck();
					return $this->Shipping();
				break;

				case "review":
					$this->cartEmptyCheck();
					return $this->Review();
				break;

				case "payment":
					$this->cartEmptyCheck();
					return $this->Payment();
				break;

#ajax part
				case "ajax.billing":
					return $this->AjaxBilling();
				break;

				case "ajax.shipping":
					return $this->AjaxShipping();
				break;

				case "orders-history":
					$this->module->plugins["users"]->__check_session();
					return $this->OrdersHistory();
				break;

				case "order-history":
					$this->module->plugins["users"]->__check_session();
					return $this->OrderHistory();
				break;


				case "profile-shop":
					$this->module->plugins["users"]->__check_session();
					return $this->ProfileShop();
				break;

				case "ajax.profile":
					return $this->ajax_update_profile();
				break;


				case "orders-download":
					$this->module->plugins["users"]->__check_session();
					return $this->ProfileDownloads();
				break;











				#development
				case "sendmail":
					echo $this->BuildOrderEmail("AU-H5CX-2NIWE");
				die();
				break;

				case "order.download":
					return $this->DownloadOrderFile();
				break;

				#authorize.net
				case "checkout.authorize":
					return $this->CheckoutAuthorize();
				break;

				#offline processingf
				case "checkout.offline.success":
					return $this->CheckoutOfflineSuccess();
				break;

				case "checkout.offline":
					return $this->CheckoutOffline();
				break;

				#paypal
				case "checkout.paypal.success":
					return $this->CheckoutPaypalSuccess();
				break;

				case "checkout.paypal.cancel":
					return $this->CheckoutPaypalCancel();
				break;

				case "checkout.paypal":
					return $this->CheckoutPaypal();
				break;

				case "checkout.paypal.ipn":
					return $this->CheckoutPaypalIPN();
				break;

			}
			
		}

		if ($_GET["sub"] == "oxymall.plugin.cart.xml") {
			return $this->GenerateXML();
		}

	}


	function __init() {
		global $_CONF;

		if ($this->__inited) {
			return "";
		}

		$this->__inited = true;
		
		$path = $this->tpl_path;

		$templates = array(
			"summary"			=> "summary.htm",
			"order-cart"		=> "order-cart.htm",
			"order-billing"		=> "order-billing.htm",
			"order-shipping"	=> "order-shipping.htm",
			"order-review"		=> "order-review.htm",
			"order-payment"		=> "order-payment.htm",

			"checkout-title"	=> "checkout-title.htm",

		
			"orders-history"	=> "orders-history.htm",
			"order-details"		=> "order-details.htm",
			"user-menu"			=> "user-menu.htm",
			"profile"			=> "profile.htm",
			"profile-downloads"	=> "profile-downloads.htm",


		);

		foreach ($templates as $key => $val) {
			$this->private->templates[$key] = new CTemplateDynamic(
				$path . $val
			);
		}

		$this->tpl_module = $this->module->plugins["modules"]->LoadDefaultModule("shop");

	} 
	
		
	function GetAllLinks($module , $links) {
	}

	function CheckoutPaypalIPN() {

//		SaveFileContents("n/" . time() . ".txt" , serialize($_POST));
//		$_POST = unserialize(GetFileContents("n/1320163232.txt"));

		$account = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:shop_accounts']} WHERE item_code='paypal'");


		$data = $_POST;

		$paypal = new CPaypal($account["item_account"]);

		if (is_array($return = $paypal->IPN())) { 

			//store this transaction in log
			$data["trans_date"] = time();
			$this->db->QueryInsert(
				$this->tables['plugin:shop_log_paypal'],
				$data
			);

			//read the order
			$order = $this->db->QFetchArray(
				"SELECT * FROM {$this->tables['plugin:shop_orders']} WHERE order_code='{$data[custom]}'"
			);


			//add the transaction id
			if (!$order["order_trans_id"]) {
				$new_order["order_trans_id"] = $data["txn_id"];
			}

			switch ($data["payment_status"]) {

				case "Pending":
					$new_order["order_status"] = "1";
				break;

				case "Completed":
					$new_order["order_status"] = "2";
					$new_order["order_payment_date"] = time();
				break;


				case "Refunded":
					$new_order["order_status"] = "3";
				break;
			}

			$this->db->QueryUpdate(
				$this->tables['plugin:shop_orders'],
				$new_order,
				"order_id={$order[order_id]}"
			);

			if (($new_order["order_status"] == "2") && ($new_order["order_status"] != $order["order_status"])) {

				//update the order
				$products = $this->db->QFetchRowArray(
					"SELECT item_product_sku FROM {$this->tables['plugin:shop_cart']} WHERE item_order={$order[order_id]}"
				);

				if (count($products)) {

					foreach ($products as $key => $val) {				
						//update the sales count for this product
						$this->db->Query(
							"UPDATE {$this->tables['plugin:shop_items']} SET item_sales = item_sales+1 WHERE item_sku ='{$val[item_product_sku]}'"
						);
					}

				}			


				//send the mail to admin
				$email = $this->module->plugins["mail"]->SendMail(
					$this->module->plugins["mail"]->GetMail(
						$this->vars->data["set_shop_mail_admin"],
						array_merge(
							array(
								"order_data"	=> $this->BuildOrderEmail($order["order_code"] , true)
							),
							$order
						)
					)
				);			

				//send mail to client

				$email = $this->module->plugins["mail"]->SendMail(
					$this->module->plugins["mail"]->GetMail(
						$this->vars->data["set_shop_mail_client_2"],
						array_merge(
							array(
								"order_data"	=> $this->BuildOrderEmail($order["order_code"] , false)
							),
							$order
						)
					)
				);

			}

			if (($new_order["order_status"] == "3") && ($new_order["order_status"] != $order["order_status"])) {
				$email = $this->module->plugins["mail"]->SendMail(
					$this->module->plugins["mail"]->GetMail(
						$this->vars->data["set_shop_mail_client_3"],
						array_merge(
							array(
								"order_data"	=> $this->BuildOrderEmail($order["order_code"] , false)
							),
							$order
						)
					)
				);
			}


			die("seding mail");
		}
		
		echo "ok";
		die();
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

	function CheckoutPaypalSuccess() {

		global $_CONF;

		$account = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:shop_accounts']} WHERE item_code='paypal'");

		$this->module->plugins["modules"]->RedirectToModule(
			$account["item_page_ok"]
		);

	}
	function CheckoutPaypalCancel() {

		global $_CONF;

		$account = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:shop_accounts']} WHERE item_code='paypal'");

		$this->module->plugins["modules"]->RedirectToModule(
			$account["item_page_error"]
		);

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
	function LoadModule() {
		$module = $this->module->plugins["modules"]->LoadDefaultModule("shop");

		return array(
			"module_code"	=> "cart",
			"module_file"	=> "cart.swf",
			"mod_name"		=> $module["settings"]["set_title"],
			"mod_invisible"	=> 1,
			"mod_id"		=> "-1",
			"mod_url"		=> "cart",
			"mod_urltitle"	=> $module["settings"]["set_title"],
		);
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
	function __paymentAccounts($template) { 
		global $base;

		$bool = array(
			1	=> "true",
			0	=> "false"
		);

		$accounts = $this->db->QFetchRowArray("SELECT * FROM {$this->tables['plugin:shop_accounts']} WHERE item_status ORDER BY item_order ASC");

		if (is_array($accounts)) {
			foreach ($accounts as $key => $val) {
				$accounts[$key]["item_card"] = $bool[(int)$val["item_card"]];
				$accounts[$key]["item_type"] = $bool[(int)$val["item_type"]];
			}
		}
		

		return $base->html->table(
			$template , 
			"Payment",
			$accounts
			
		);
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
	function __countries($template) {
		global $base;

		$countries = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:shop_countries']} WHERE item_status=1 ORDER BY item_title ASC"
		);

		if (is_array($countries)) {
			foreach ($countries as $key => $val) {
				if ($val["item_states"]) {
					$tmp = explode("\n" , $val["item_states"]);
					$states = array();

					foreach ($tmp as $k => $v) {
						$states[] = array(
							"item_title"	=> trim($v),
						);
					}


					$countries[$key]["states"] = $base->html->Table(
						$template , 
						"States",
						$states
					);
				} else 
					$countries[$key]["states"] = "";
			}
			
		}

		$data = $base->html->Table(
			$template , 
			"Countries",
			$countries
		);

		return $data;
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
	function __years($template) {
		global $base;

		$start = date("Y");

		for ($i = $start; $i<= $start+10 ; $i++ ) {
			$years[] = array(
				"title"		=> $i,
				"default"	=> "0"
			);			
		}

		$years[0]["default"] = "1";

		return $base->html->Table(
			$template , 
			"Years" , 
			$years
		);

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
	function __tax($price) {
		global $_SESS;


		if ($this->vars->data["set_shop_shipping_country"] != $_SESS["checkout"]["billing"]["order_billing_country"]) {
	
			//international tax
			if ($this->vars->data["set_tax_international"]) {
				return $price * $this->vars->data["set_tax_international"] / 100;
			} else 
				return 0;			
		} 

		if ($this->vars->data["set_tax_domestic"]) {
			return $price * $this->vars->data["set_tax_domestic"] / 100;
		} else 
			return 0;			
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
	function UpdateOrder($oc , $data) {
		$this->db->QueryUpdate(
			$this->tables['plugin:shop_orders'],
			$data,
			"order_code=\"{$oc}\""
		);

		return true;
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
	function PrepareOrder($data) {
			

		if (is_array($data["Product"])) {
			foreach ($data["Product"] as $key => $val) {

				$product = array(
					"quantity" => $val["quantity"],
					"price" => $val["price"],
					"product" => $val["name"],
					"sku" => $val["productId"],
					"options" => $val["options"] ? implode("," , $val["options"]) : "",
				);
				

				$_cart[] = 	$product;
			}
		}


		$data["cart"] = $_cart;

		return $data;


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
	function StoreOrder($account = false) {
		global $_SESS;

		$cart = $_SESS["cart"];
		$data = $_SESS["checkout"]["billing"];

		$cart = $this->ProcessCart(false);

		//add the shipping
		if ($_SESS["checkout"]["shipping"]) {
			$shipping = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:shop_shipping']} WHERE item_id=\"{$_SESS[checkout][shipping]}\"");
		}		

		$order = array(

			"order_status"				=> 0,	//pending
			"order_date"				=> time(),
			"order_user"				=> $_SESS["client"]["user_id"],

			"order_price_subtotal"		=> $cart["subtotal"],
			"order_price_discount"		=> 0,
			"order_price_shipping"		=> $cart["shipping"],
			"order_price_tax"			=> $cart["tax"],
			"order_price_total"			=> $cart["total"],
			"order_products"			=> $cart["products"],

			"order_price_currency"		=> $this->vars->data["set_shop_currency"],

			"order_shipping_method"		=> $shipping["item_id"],
			"order_shipping_method_name"=> $shipping["item_title"],

			"order_payment_method"		=> $account["item_id"],
			"order_payment_method_name"	=> $account["item_title"],

			"order_billing_first_name"	=> $data["order_billing_first_name"],
			"order_billing_last_name"	=> $data["order_billing_last_name"],
			"order_billing_address_1"	=> $data["order_billing_address_1"],
			"order_billing_address_2"	=> $data["order_billing_address_2"],
			"order_billing_city"		=> $data["order_billing_city"],
			"order_billing_state"		=> $data["order_billing_state"],
			"order_billing_zip"			=> $data["order_billing_zip"],
			"order_billing_country"		=> $data["order_billing_country"],
			"order_billing_phone"		=> $data["order_billing_phone"],
			"order_billing_email"		=> $data["order_billing_email"],

			"order_shipping_first_name"	=> $data["order_shipping_first_name"],
			"order_shipping_last_name"	=> $data["order_shipping_last_name"],
			"order_shipping_address_1"	=> $data["order_shipping_address_1"],
			"order_shipping_address_2"	=> $data["order_shipping_address_2"],
			"order_shipping_city"		=> $data["order_shipping_city"],
			"order_shipping_state"		=> $data["order_shipping_state"],
			"order_shipping_zip"		=> $data["order_shipping_zip"],
			"order_shipping_country"	=> $data["order_shipping_country"],
			"order_shipping_phone"		=> $data["order_shipping_phone"],
		);

		//store the order and record the id 
		$oid = $this->db->QueryINsert(
			$this->tables["plugin:shop_orders"],
			$order
		);

		//update the ordercode
		$oc = $this->GenerateOrderCode($account);

		//save the order code
		$this->db->QueryUpdate(
			$this->tables["plugin:shop_orders"],
			array(
				"order_code"	=> $oc,
			),
			"order_id={$oid}"
		);

		//store the products
		if (is_array($cart["items"])) {
			foreach ($cart["items"] as $key => $val) {
				$this->db->QueryInsert(
					$this->tables["plugin:shop_cart"],
					array(
						"item_order"		=> $oid,
						"item_date"			=> time(),
						"item_price"		=> $val["price_raw"],
						"item_quantity"		=> $val["qty"],
						"item_total"		=> $val["total_price_raw"],
						"item_product"		=> $val["title"],
						"item_product_sku"	=> $val["sku"],
						"item_product_id"	=> $val["id"],
						"item_options"		=> $val["options"],
					)
				);
			}			
		}
		
		return array(
			"order"			=> $order,
			"order_code"	=> $oc,
			"cart"			=> $cart["items"],
			"oid"			=> $oid,
		);
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
	function CheckoutPaypal() {

		$account = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:shop_accounts']} WHERE item_code='paypal'");

		$template = new CTemplate($this->tpl_path . "checkout-paypal.htm");

		//store the order in database
		$result = $this->StoreOrder(
			$account
		);


		//get the shopp account
		$paypal = new CPaypal($account["item_account"]);

		//build the url

		global $_CONF;

		$paypal->SetUrls(
			$_CONF["url"] . "checkout-paypal-success.php",
			$_CONF["url"] . "checkout-paypal-cancel.php",
			$_CONF["url"] . "checkout-paypal-ipn.php"
		);
		
		$paypal->SetPrices(
			$result["order"]["order_price_subtotal"],
			$result["order"]["order_price_shipping"],
			$result["order"]["order_price_tax"],
			$result["order"]["order_price_discount"]	
		);


		$paypal->OrderInfo(
			array(
				"id" => "",
				"invoice" => $result["order_code"],
				"description" => $account["item_order_description"]
			)
		);  


		//add the currency code
		$paypal->SetCurrency(strtoupper($this->vars->data["set_shop_currency"]));


		return $template->blockReplace(
			"Main",
			array(
				"form"	=> $paypal->__drawForm(),
				"item_redirect"	=> $account["item_redirect"],
			)
		);
	}


	function CheckoutOffline() {

		$account = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:shop_accounts']} WHERE item_code='offline'");

		//store the order in database
		$result = $this->StoreOrder(
			$account
		);

		//update order to pending status
		$this->db->QueryUpdate(
			$this->tables["plugin:shop_orders"],
			array(
				"order_status" => "1",
			),
			"order_code='{$result[order_code]}'"
		);


		//send the mail to admin

		$email = $this->module->plugins["mail"]->SendMail(
			$this->module->plugins["mail"]->GetMail(
				$this->vars->data["set_shop_mail_admin"],
				array_merge(
					array(
						"order_data"	=> $this->BuildOrderEmail($result["order_code"] , true)
					),
					$result["order"]
				)
			)
		);			

		//send mail to client

		$email = $this->module->plugins["mail"]->SendMail(
			$this->module->plugins["mail"]->GetMail(
				$this->vars->data["set_shop_mail_client_1"],
				array_merge(
					array(
						"order_data"	=> $this->BuildOrderEmail($result["order_code"] , false)
					),
					$result["order"]
				)
			)
		);

		//clear cart 
		$this->ClearCart();

		return  $this->module->plugins["common"]->SuccessMSG(
			"",
			$this->module->plugins["modules"]->RedirectToModule(
				$account["item_page_ok"],
				true
			)
		);

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
	function CheckoutAuthorize() {
		global $_SESS;

		//check for default fields
		$fields = array(
			"nr" , "name" , "type" , "year" , "month" , "cvv2"
		);

		foreach ($fields as $key => $val) {
			if (!$_POST[$val]) {
				return  $this->module->plugins["common"]->ErrorMsg(
					$this->tpl_module["settings"]["set_step4_error"]
				);
			}			
		}
		
	
		$account = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:shop_accounts']} WHERE item_code='authorize'");

		
		$price = $this->ProcessCart();

		$test = new CPay();
		$test->SetMerchant("authorize");

		
		$test->SetLogin($account["item_account"],$account["item_password"]);
		$test->_transid = $account["item_gatewayid"];

		if ($account["item_demo"]) {
			$test->EnableTest();
		}


		//($nr ,$expm , $expy , $ccvv = "" , $no = 0)
		$test->SetCCInfo($_POST["nr"],$_POST["month"] , $_POST["year"],$_POST["cvv2"]);

		$test->SetBillingInfo( 
				$_SESS["checkout"]["billing"]["order_billing_first_name"],
				$_SESS["checkout"]["billing"]["order_billing_last_name"],
				"",
				$_SESS["checkout"]["billing"]["order_billing_address_1"],
				$_SESS["checkout"]["billing"]["order_billing_address_2"], 
				$_SESS["checkout"]["billing"]["order_billing_city"], 
				$_SESS["checkout"]["billing"]["order_billing_state"], 
				$_SESS["checkout"]["billing"]["order_billing_zip"], 
				$_SESS["checkout"]["billing"]["order_billing_country"], 
				$_SESS["checkout"]["billing"]["order_billing_email"], 
				$_SESS["checkout"]["billing"]["order_billing_phone"]
		);

		$test->SetShippingInfo( 
				$_SESS["checkout"]["billing"]["order_shipping_first_name"],
				$_SESS["checkout"]["billing"]["order_shipping_last_name"],
				"",
				$_SESS["checkout"]["billing"]["order_shipping_address_1"],
				$_SESS["checkout"]["billing"]["order_shipping_address_2"], 
				$_SESS["checkout"]["billing"]["order_shipping_city"], 
				$_SESS["checkout"]["billing"]["order_shipping_state"], 
				$_SESS["checkout"]["billing"]["order_shipping_zip"], 
				$_SESS["checkout"]["billing"]["order_shipping_country"], 
				$_SESS["checkout"]["billing"]["order_shipping_email"], 
				$_SESS["checkout"]["billing"]["order_shipping_phone"]
		);

		$trans_id = $this->GenerateOrderCode($account);

		$test->SetOrderInfo( $trans_id , $account["item_order_description"]);
		$test->SetAction(PAY_CAPTURE);
		$test->SetPrices($price["total"] , $price["tax"] , $price["shipping"]);
		$test->CallMerchant();

		if ($test->Aproved()) {

			$ord = $this->StoreOrder($account);
			$this->UpdateOrder(
				$ord["order_code"],
				array(
					"order_code"			=> $trans_id,
					"order_status"			=> "2",
					"order_payment_date"	=> time(),
					"order_trans_id"		=> $test->_transid,
				)
			);

			//update the sales
			$order_data = $this->db->QFetchArray(
				"SELECT * FROM {$this->tables['plugin:shop_orders']} WHERE order_code='{$trans_id}'"
			);

			//update the order
			$products = $this->db->QFetchRowArray(
				"SELECT item_product_sku FROM {$this->tables['plugin:shop_cart']} WHERE item_order={$order_data[order_id]}"
			);

			if (count($products)) {
				foreach ($products as $key => $val) {				
					//update the sales count for this product
					$this->db->Query(
						"UPDATE {$this->tables['plugin:shop_items']} SET item_sales = item_sales+1 WHERE item_sku ='{$val[item_product_sku]}'"
					);
				}
			}			



			//send the mail to admin

			$email = $this->module->plugins["mail"]->SendMail(
				$this->module->plugins["mail"]->GetMail(
					$this->vars->data["set_shop_mail_admin"],
					array_merge(
						array(
							"order_data"	=> $this->BuildOrderEmail($trans_id , true)
						),
						$ord["order"]
					)
				)
			);			

			//send mail to client

			$email = $this->module->plugins["mail"]->SendMail(
				$this->module->plugins["mail"]->GetMail(
					$this->vars->data["set_shop_mail_client_2"],
					array_merge(
						array(
							"order_data"	=> $this->BuildOrderEmail($trans_id , false)
						),
						$ord["order"]
					)
				)
			);

			//clear cart 
			$this->ClearCart();

			return  $this->module->plugins["common"]->SuccessMSG(
				"",
				$this->module->plugins["modules"]->RedirectToModule(
					$account["item_page_ok"],
					true
				)
			);

		} else {
			return  $this->module->plugins["common"]->ErrorMsg(
				$test->_gwerorr
			);
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
	function GenerateOrderCode($account) {
		do {
			$oc= $account["item_order_preffix"] . "-" . strtoupper(randomWord(4)) . "-" . strtoupper(randomword("5"));
		} while (is_array($this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:shop_orders']} WHERE order_code='{$oc}'")));

		return $oc;
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
	function BuildOrderEmail($code , $admin = false) {
		global $base;

		
		$status = array(
			"1"	=> "pending",
			"2"	=> "completed",
			"3"	=> "refunded",
		);

		$template = new CTemplateDynamic($this->tpl_path . "mail-order.htm");

		$order = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:shop_orders']} WHERE order_code=\"{$code}\"");

		if (!is_array($order)) {
			return "";
		}

		//read the cart content
		$cart = $this->db->QFetchRowArray("SELECT * FROM {$this->tables['plugin:shop_cart']} WHERE item_order={$order[order_id]}");

		if (is_array($cart)) {

			foreach ($cart as $key => $val) {
				$cart[$key]["cnt"] = ++$cnt;

				$product = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:shop_items']} WHERE item_sku='{$val[item_product_sku]}'");

				$files = $this->db->QFetchRowArray("SELECT * FROM {$this->tables['plugin:shop_files']} WHERE item_parent='{$product[item_id]}'");

				if (is_array($files)) {
					$cart[$key]["download"] = $base->html->table(
						$template , 
						"Download",
						$files
					);
				} else 
					$cart[$key]["download"] = $template->blockReplace("NoDownload" , array());
				

			}

			//process the data
			$order["order_date"] = date("d M Y g:i:a" , $order["order_date"]);
			$order["status"] = $status[$order["order_status"]];


			$price_fields = array(
				"order_price_subtotal" , "order_price_shipping" , "order_price_tax" , "order_price_discount" , "order_price_total"
			);

			foreach ($price_fields as $key => $val) {
				$order[$val] = number_format($order[$val] , 2);
			}
			


			if ((($order["order_status"] == "2")||($order["order_status"] == "7")) && !$admin) {
				$cart_template = "Cart";
			} else {
				$cart_template = "CartNF";
			}
			
			return $template->blockReplace(
				"Main",
				array(
					"client"	=> $template->blockReplace(
						"Client",
						$order
					),

					"cart"		=> CTemplateStatic::Replace(
						$base->html->Table(
							$template,
							$cart_template,
							$cart
						),
						$order
					)
				)
			);

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
	function DownloadOrderFile() {
		global $_SESS;

		$order = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:shop_orders']} WHERE order_code=\"{$_GET['o']}\"");
		$file = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:shop_files']} WHERE item_id=\"{$_GET[f]}\"");
		$product = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:shop_items']} WHERE item_id='{$file[item_parent]}'");
		$cart = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:shop_cart']} WHERE item_product_sku='{$product[item_sku]}' AND item_order='{$order[order_id]}'");

		$downloads = $this->db->QFetchRowArray("SELECT * FROM {$this->tables['plugin:shop_files_history']} WHERE file_order=\"{$order[order_code]}\" AND file_file='{$file[item_id]}'");

		$_downloads = array();

		if (is_Array($downloads)) {
			foreach ($downloads as $key => $val) {
				$_downloads[$val["file_ip"]] = "1";
			}			
		}

		if (is_array($order) && is_array($file) && is_array($product) && is_array($cart) && (count($_downloads) < $this->vars->data["set_shop_download_exceeded"])) {

			//if user is logged in dont log the download

			if (!$_SESS["client"]["user_id"]) {
				//store the record
				$this->db->QueryInsert(
					$this->tables["plugin:shop_files_history"],
					array(
						"file_order"	=> $order["order_code"],
						"file_file"		=> $file["item_id"],
						"file_date"		=> time(),
						"file_ip"		=> $_SERVER["REMOTE_ADDR"],
					)
				);
			}
			

			//check for download history

			$mime = new CMime();
			$mime->FileName($file["item_file_file"]);
			$mime->Set("unknown");

			//read thefile contnets
			readfile("upload/shop/files/{$file[item_id]}.file");
			die();
		}

		$this->module->plugins["modules"]->RedirectToModule(
			$this->vars->data["set_shop_download_exceeded"]
		);
	
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
	function AddToCart() {
		global $_SESS;

		$product = $this->module->plugins["products"]->GetProduct($_GET["pid"]);

		if (!is_array($product)) {
			die("error");
		}
		

		if (is_array($product)) {
			$product = $this->module->plugins["products"]->ProcessProduct($product , true);
		}
	
		//process the final price

		$unit_price = $product["item_price"];

		if (is_array($_POST["o"])) {
			foreach ($_POST["o"] as $key => $val) {

				if (is_array($product["variations"][$key]) && is_array($product["variations"][$key]["options"][$val])) {
					$unit_price += $product["variations"][$key]["options"][$val]["price"];
				}				
			}			
		}
		
		//check if i have the product in cart and increment the quantity

/*
		if (count($_SESS["cart"])) {
			foreach ($_SESS["cart"] as $key => $val) {
				if (($val["p"] == $product["item_id"]) && !is_array(array_diff((array)$v["variations"] , (array)$_POST["o"]))  && ($val["price"] == $unit_price)) {
					$_SESS["cart"][$key]["qty"]++;
					$found = true;
				}				
			}			
		}
*/

		//if not found add as a new record in session
		if (!$found) {
			$_SESS["cart"][] = array(
				"p"				=> $product["item_id"],
				"price"			=> $unit_price,
				"variations"	=> $_POST["o"],
				"qty"			=> max($_POST["q"] ,1), 
				"ship"			=> $product["item_shipping"]
			);
		}

		return $this->module->plugins["common"]->SuccessMsg(
			$product["item_title"] . " was added to cart ! "
		);

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
	function hasShipping() {
		global $_SESS;

		if (is_array($_SESS["cart"])) {
			foreach ($_SESS["cart"] as $key => $val) {
				if ($val["ship"]) {
					return true;
				}
				
			}			
		}
		
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
	function AjaxSummary($template = null) {
		global $_SESS , $base;

		$this->__init();

		if ($template === null) {
			$template = $this->private->templates["summary"];
		}

		if ($_POST["qty"]) {
			foreach ($_POST["qty"] as $key => $val) {
				if ($_SESS["cart"][$key]) {

					if ($val > 0) {
						$_SESS["cart"][$key]["qty"] = $val;
					} else {
						unset($_SESS["cart"][$key]);
					}
					
				}								
			}			
		}
		

		if (is_array($_SESS["cart"]) && count($_SESS["cart"])) {
			foreach ($_SESS["cart"] as $key => $val) {
				$data[$key] = $val;
				$data[$key]["raw"] = $this->module->plugins["products"]->GetProduct($val["p"] , true);
			}			
		}

		if (is_array($data)) {
			foreach ($data as $key => $val) {
				$options = array();

				if (is_array($val["variations"])) {
					foreach ($val["variations"] as $k => $v) {
						if (trim($v)) {
							$options[] = $v ;
						}
					}
				}
				
				$products[] = array(
					"item_title"	=> $val["raw"]["item_title"],
					"item_id"		=> $val["raw"]["item_title"],
					"price"			=> $this->module->plugins["products"]->FormatPrice($val["price"]),
					"total_price"	=> $this->module->plugins["products"]->FormatPrice($val["price"] * max($val["qty"] , 1)),
					"qty"			=> max($val["qty"],1),
					"options"		=> is_array($options) ? implode("," , $options) : "",
					"key"			=> $key,
				);

				$total += $val["price"] * max($val["qty"] , 1);
				$products_count += max($val["qty"] , 1);
			}			
		}
		

		return CTemplateStatic::Replace(
			$template->blockReplace(
				"Main" , 
				array(
					"products"			=> $base->html->table(
						$template,
						""	,	
						$products
					),

					"total"				=> $this->module->plugins["products"]->formatPrice($total),

					"products_count"	=> $products_count,

					"button_checkout"	=> $template->blockReplace($products_count? "CheckoutButton" : "CheckoutButtonDisabled" , array()),
				)
			),
			array_merge(
				$this->tpl_module["settings"],
				array(
					"link:cart"		=> $this->module->plugins["modules"]->PrepareLink("cart/"  ),
					"link:checkout"	=> $this->module->plugins["modules"]->PrepareLink("cart/" . "checkout/" ),
					"link:continue"	=> $this->module->plugins["modules"]->PrepareLink("" ),
				)
			)
		);
	}


	function Summary() {
		$this->__init();

		if (!$this->tpl_module["module_unique_enabled"]) {
			return "";
		}

		$return = CTemplateStatic::Replace(
			$this->private->templates["summary"]->blockReplace(
				"Widget" , 
				array(
					//this should be removed to free mysql server from unecessary queries
					"content"	=> $this->AjaxSummary(),
				)
			),
			$this->tpl_module["settings"]
		);

		return $this->texts(
			$return
		);

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
	function isEnabled() {
		$this->__init();

		if ($this->tpl_module["module_unique_enabled"])
			return true;
		else 
			return false;
	}
	

	function Button() {

		$this->__init();

		if (!$this->tpl_module["module_unique_enabled"]) {
			return "";
		}

		return $this->private->templates["summary"]->blockReplace(
			"Button" , 
			$this->tpl_module["settings"]
		);
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
	function ViewCart() {

		$this->module->plugins["modules"]->SetSeo(array(
			"seo_title"	=> $this->tpl_module["settings"]["set_seo_title"],
			"seo_desc"	=> $this->tpl_module["settings"]["set_seo_desc"],
			"seo_keys"	=> $this->tpl_module["settings"]["set_seo_keys"],
		));

		return CTemplateStatic::Replace(
			$this->private->templates["order-cart"]->blockreplace(
				"Step",
				array(
					"content" => $this->AjaxSummary($this->private->templates["order-cart"]),
					"steps"		=> $this->checkoutSteps("1"),

				)
			),
			$this->actionLinks()
		);
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
	function ActionLinks() {

		$links = array(
			"link:cart"	=> $this->module->plugins["modules"]->prepareLink("cart/"),
			"link:step1"	=> $this->module->plugins["modules"]->prepareLink("cart/checkout/"),
			"link:step2"	=> $this->module->plugins["modules"]->prepareLink("cart/checkout/shipping/"),
			"link:step3"	=> $this->module->plugins["modules"]->prepareLink("cart/checkout/review/"),
			"link:step4"	=> $this->module->plugins["modules"]->prepareLink("cart/checkout/payment/"),
			"link:history-order"	=> $this->module->plugins["modules"]->prepareLink("account/history/"),
			"link:history"	=> $this->module->plugins["modules"]->prepareLink("account/history/"),
			"link:profile"	=> $this->module->plugins["modules"]->prepareLink("account/profile-shop/"),
			"link:download"	=> $this->module->plugins["modules"]->prepareLink("account/download/"),
		);


		return $links;
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
	function Billing() {
		global $_SESS;

		$this->module->plugins["modules"]->SetSeo(array(
			"seo_title"	=> $this->tpl_module["settings"]["set_seo_title"],
			"seo_desc"	=> $this->tpl_module["settings"]["set_seo_desc"],
			"seo_keys"	=> $this->tpl_module["settings"]["set_seo_keys"],
		));


		//i need to do a detection to see if i have shipping too, the best is to do in "cart summary"
		$is_shipping = $this->hasShipping();

		$data["countries"] = $this->module->plugins["shop"]->GetCountries(false , true);

		
		$return = $this->private->templates["order-billing"]->blockReplace(
			"Main",
			array(
				"countries"	=> $data["countries"],
				
				"shipping_form"	=> $is_shipping ? $this->private->templates["order-billing"]->Blockreplace(
					"ShippingForm",
					$data
				) : "",

				"shipping_title"	=> $is_shipping ? $this->private->templates["order-billing"]->Blockreplace(
					"ShippingTitle",
					array(
					)
				) : "",

				"shipping_control"	=> $is_shipping ? $this->private->templates["order-billing"]->Blockreplace(
					"ShippingControl",
					array(
					)
				) : "",

				"email_field"		=> !$_SESS["client"] ? $this->private->templates["order-billing"]->blockReplace(
					"Email" , 
					$data
				) : "",

				"steps"				=> $this->checkoutSteps("2"),
			
			)
			
		);

		//replace button with no shippoing one
		if (!$is_shipping) {
			$this->tpl_module["settings"]["set_step1_button_2"] = $this->tpl_module["settings"]["set_step1_button_2_2"];
		}
		

		return CTemplateSTatic::EmptyVars(
			$this->Texts($return),
			$_SESS["checkout"]["billing"]
		);
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
	function AjaxBilling() {
		global $_SESS;

		$fields = array(
			"shipping"	=> array(
				"order_shipping_phone",
				"order_shipping_country",
				"order_shipping_zip",
				"order_shipping_state",
				"order_shipping_city",
				"order_shipping_address_1",
				"order_shipping_address_2",
				"order_shipping_last_name",
				"order_shipping_first_name",
			),
			"billing"	=> array(
				"order_billing_phone",
				"order_billing_country",
				"order_billing_zip",
				"order_billing_state",
				"order_billing_city",
				"order_billing_address_1",
				"order_billing_address_2",
				"order_billing_last_name",
				"order_billing_first_name",
				"order_billing_email",
			),
		);

		//remove the email 
		if (is_array($_SESS["client"])) {
			$_POST["order_billing_email"] = $_SESS["client"]["user_email"];
		}

		if (!$this->hasShipping()) {
			$shipping = false;

			unset($fields["shipping"]);
			$data = $fields["billing"];
		} else {
			
			$data = array_merge(
				$fields["billing"],
				$fields["shipping"]
			);

			$shipping = true;
		}

		foreach ($data as $key => $val) {

			if (!$_POST[$val]) {
				return  $this->module->plugins["common"]->ErrorMsg(
					$this->tpl_module["settings"]["set_step1_error"]
				);
			}			
		}

		//all good ..

		//remove the old session 
		unset($_SESS["checkout"]["billing"]);

		foreach ($data as $key => $val) {
			$_SESS["checkout"]["billing"][$val] = $_POST[$val];
		}
		
		return  $this->module->plugins["common"]->SuccessMsg(
			$this->tpl_module["settings"]["set_step1_success"],
			$this->module->plugins["modules"]->PrepareLink($shipping ? "cart/checkout/shipping/" : "cart/checkout/review/")
		);

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
	function Shipping() {
		global $_SESS , $base;

		$this->module->plugins["modules"]->SetSeo(array(
			"seo_title"	=> $this->tpl_module["settings"]["set_seo_title"],
			"seo_desc"	=> $this->tpl_module["settings"]["set_seo_desc"],
			"seo_keys"	=> $this->tpl_module["settings"]["set_seo_keys"],
		));

		if ($this->vars->data["set_shop_shipping_country"] == $_SESS["checkout"]["billing"]["order_shipping_country"]) {
			$local = 0;
		} else 
			$local = 1;
		
		$methods = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:shop_shipping']} WHERE item_status=1 AND item_intl={$local} ORDER BY item_price ASC "
		);

		if (is_Array($methods)) {
			foreach ($methods as $key => $val) {
				$methods[$key]["price"] = $val["item_price"] ? $this->module->plugins["products"]->FormatPrice($val["item_price"]) : $this->tpl_module["settings"]["set_step2_price_free"];

				$methods[$key]["checked"] = $val["item_id"] == $_SESS["checkout"]["shipping"] ? $this->private->templates["order-shipping"]->BlockReplace("Checked" , array()) : "";
			}			
		}
		
			
		$return = $this->private->templates["order-shipping"]->blockReplace(
			"Main",
			array(
				"methods"	=> $base->html->table(
					$this->private->templates["order-shipping"] , 
					"", 
					$methods
				),

				"default"	=> $_SESS["checkout"]["shipping"],

				"steps"		=> $this->checkoutSteps("3"),

			)
		);

		return CTemplateSTatic::EmptyVars(
			$this->Texts($return),
			$_SESS["checkout"]["shipping"]
		);
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
	function AjaxShipping() {
		global $_SESS;

		if (!$_POST["method"]) {
			return  $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_step2_error"]
			);
		}
		
		$_SESS["checkout"]["shipping"] = $_POST["method"];

		return  $this->module->plugins["common"]->SuccessMsg(
			$this->tpl_module["settings"]["set_step2_success"],
			$this->module->plugins["modules"]->PrepareLink("cart/checkout/review/")
		);

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
	function Review() {
		global $_SESS , $base;

		$this->module->plugins["modules"]->SetSeo(array(
			"seo_title"	=> $this->tpl_module["settings"]["set_seo_title"],
			"seo_desc"	=> $this->tpl_module["settings"]["set_seo_desc"],
			"seo_keys"	=> $this->tpl_module["settings"]["set_seo_keys"],
		));


		$hasShipping = $this->hasShipping();

		$cart = $this->ProcessCart();

			
		$return = $this->private->templates["order-review"]->blockReplace(
			"Main",
			array(

				"total"				=> $this->module->plugins["products"]->FormatPrice($cart["total"]),
				"shipping"			=> "",
				"tax"				=> "",

				"products"			=> $base->html->table(
					$this->private->templates["order-review"],
					"Products",
					$cart["items"]
				),

				"billing_info"		=> $this->private->templates["order-review"]->blockReplace(
					"BillingInfo",
					$_SESS["checkout"]["billing"],
					""
				),

				"shipping_info"		=> $hasShipping ? $this->private->templates["order-review"]->blockReplace(
					"ShippingInfo",
					$_SESS["checkout"]["billing"]
				) : "",

				"shipping_title"		=> $hasShipping ? $this->private->templates["order-review"]->blockReplace(
					"ShippingTitle",
					array()
				) : "",

				"back_button"			=> $this->private->templates["order-review"]->blockReplace(
					$hasShipping ? "BackShipping" : "BackNoShipping",
					array()
				),

				"steps"		=> $this->checkoutSteps("4"),
				

			)
		);

		return $this->Texts($return);
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
	function ProcessCart($add = true) {
		global $_SESS;
		if (is_array($_SESS["cart"]) && count($_SESS["cart"])) {
			foreach ($_SESS["cart"] as $key => $val) {
				$data[$key] = $val;
				$data[$key]["raw"] = $this->module->plugins["products"]->GetProduct($val["p"] , true);
			}			
		}

		if (is_array($data)) {
			foreach ($data as $key => $val) {
				$options = array();

				if (is_array($val["variations"])) {
					foreach ($val["variations"] as $k => $v) {
						if (trim($v)) {
							$options[] = $v ;
						}
					}
				}
				
				$products[] = array(
					"title"	=> $val["raw"]["item_title"],
					"id"		=> $val["raw"]["item_id"],
					"price"			=> $this->module->plugins["products"]->FormatPrice($val["price"]),
					"total_price"	=> $this->module->plugins["products"]->FormatPrice($val["price"] * max($val["qty"] , 1)),
					"qty"			=> max($val["qty"],1),
					"options"		=> is_array($options) ? implode("," , $options) : "",
					"key"			=> $key,
					"sku"			=> $val["raw"]["item_sku"],

					"price_raw"		=> $val["price"],
					"total_price_raw"		=> $val["price"] * max($val["qty"] , 1),
				);

				$subtotal += $val["price"] * max($val["qty"] , 1);
				$products_count += max($val["qty"] , 1);
			}			
		}

		$total = $subtotal;

		if ($_SESS["checkout"]["shipping"]) {			
			$method = $this->db->QFEtchArray("SELECT * FROM {$this->tables['plugin:shop_shipping']} WHERE item_id='{$_SESS[checkout][shipping]}'");

			if ($add) {
				$products[] = array(
					"title"			=>	"{SET_STEP3_SHIPPING}",
					"options"		=> $method["item_title"],
					"price"			=> "-",
					"qty"			=> "-",
					"total_price"	=> $method["item_price"] ? $this->module->plugins["products"]->FormatPrice($method["item_price"]) : $this->tpl_module["settings"]["set_step3_shipping_free"],
				);
			}

			//add the shipping price to total
			$shipping_price = $method["item_price"];
			$total += $method["item_price"];			
		}

		//do the checking for tax
		$tax = $this->__tax($subtotal);

		if ($add) {
			$products[] = array(
				"title"			=>	"{SET_STEP3_TAX}",
				"options"		=> "",
				"price"			=> "-",
				"qty"			=> "-",
				"total_price"	=> $tax ? $this->module->plugins["products"]->FormatPrice($tax) : $this->tpl_module["settings"]["set_step3_tax_free"],
			);
		}

		$total += $tax;
		

		return array(
			"products"		=> $products_count,
			"items"			=> $products,
			"total"			=> $total,
			"subtotal"		=> $subtotal,
			"shipping"		=> $shipping_price,
			"tax"			=> $tax,
		);
		debug($products,1);

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
	function Payment() {
		global $base;

		$this->module->plugins["modules"]->SetSeo(array(
			"seo_title"	=> $this->tpl_module["settings"]["set_seo_title"],
			"seo_desc"	=> $this->tpl_module["settings"]["set_seo_desc"],
			"seo_keys"	=> $this->tpl_module["settings"]["set_seo_keys"],
		));


		$accounts = $this->db->QFetchRowArray(
			"SELECT *FROM {$this->tables['plugin:shop_accounts']} WHERE item_status=1 ORDER BY item_order ASC"
		);

		//process the years
		for ($i = date("Y"); $i <= date("Y") + 5 ; $i++ ) {
			$years .= "<option>{$i}</option>";			
		}


		if (is_array($accounts)) {
			$found = false;
			foreach ($accounts as $key => $val) {
				$accounts[$key]["class"] = !$found ? "selected" : "";
				$found = true;

				$val["years"] = $years;

				$accounts[$key]["content"]	= $this->private->templates["order-payment"]->blockreplace(
					$val["item_card"] ? "AccountCreditCard" : "AccountLink",
					$val
				);

				
			}			
		}		

		

		$return = $this->private->templates["order-payment"]->blockReplace(
			"Main",
			array(
				"accounts"	=> $base->html->Table(
					$this->private->templates["order-payment"],
					"Accounts",
					$accounts
				),

				"accounts_data"	=> $base->html->Table(
					$this->private->templates["order-payment"],
					"AccountsData",
					$accounts
				),

				"steps"		=> $this->checkoutSteps("5"),

			)
		);

		return $this->Texts($return);

	}
	



	
	function Texts($content) {

		return CTemplateStatic::Replace(
			$content ,

			array_merge(
				$this->tpl_module["settings"],
				$this->ActionLinks()
			)
		);
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
	function GetCountries($all = true , $html = false) {
		$countries = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:shop_countries']}"  . ($all ? "" : " WHERE item_status=1 ") . " ORDER BY item_title "
		);

		if (is_array($countries)) {
			foreach ($countries as $key => $val) {
				$_countries[] = "<option value='{$val[item_iso]}'>{$val[item_title]}</option>";
			}			


			if ($html) {
				return implode("\n" , $_countries);
			}

			return $countries;

		}
			
	}
	
	function ClearCart() {
		global $_SESS;

		unset($_SESS["cart"]);

		unset($_SESS["checkout"]["shipping"]);
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
	function OrdersHistory() {
		global $base, $_SESS;

		$orders = $this->GetOrders();

		if (is_array($orders["records"])) {
			foreach ($orders["records"] as $key => $val) {
				$orders["records"][$key]["price"] = $this->module->plugins["products"]->FormatPrice($val["order_price_total"]);
				$orders["records"][$key]["date"] = Date($this->tpl_module["settings"]["set_history_date_format"] , $val["order_date"]);
				$orders["records"][$key]["status"] = $this->tpl_module["settings"]["set_history_status_". $val["order_status"]];
			}			
		}
		


		$return = $this->private->templates["orders-history"]->blockReplace(
			"Main",
			array(
				"orders"		=> $base->html->Table(
					$this->private->templates["orders-history"],
					"",
					$orders["records"]
				),


				"paging"=> $this->module->plugins["paging"]->Paging(
					$orders["pages"] , 
					$orders["page"], 
					array(
						"first"		=> $this->module->plugins["modules"]->PrepareLink("account/history/"),
						"all"		=> $this->module->plugins["modules"]->PrepareLink("account/history/{PAGE}") ,
					),
					array(
						"ipp"	=> $orders["ipp"],
						"total"	=> $orders["count"]
					)
				),

				"shop_menu"	=> $this->UserMenu("2"),
				"user_menu"	=> $this->module->plugins["users"]->UserMenu(),
			)
		);

		return $this->Texts($return);
	}
	

	function GetOrders() {
		global $_SESS;
		
		$count = $this->tpl_module["settings"]["set_account_orders_pp"];
		$page = $_GET["page"];

		$item_count = $this->db->RowCount(
			$this->tables['plugin:shop_orders'],
			"WHERE order_user={$_SESS[client][user_id]} AND order_status>0 "
		);

		$page = $_GET["page"];

		if (!$page && $item_count) {
			$page = 1;
		} else 
			$page = (int)$page;

		$items = $this->db->QFetchRowArray(
			"SELECT * " . 
			"FROM {$this->tables['plugin:shop_orders']} " . 
			"WHERE order_user={$_SESS[client][user_id]} AND order_status>0 " . 
			"ORDER BY  order_date DESC " .
			"LIMIT " . ( max(0,($page - 1 ) * $count )) . " , " . $count 
		);

		if (is_Array($items)) {
			foreach ($items as $key => $val) {

			}			
		}

		return array(
			"records"	=> $items, 
			"count"		=> $item_count , 
			"pages"		=> $item_count ? ceil($item_count / $count) : 1,
			"page"		=> $page,

			"ipp"		=> $count,
		);

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
	function OrderHistory() {
		global $_SESS , $base;

		$order = $this->db->QFetchArray(
			"SELECT * FROM {$this->tables['plugin:shop_orders']} WHERE order_code='{$_GET[code]}' AND order_user='{$_SESS[client][user_id]}'"
		);

		if (!is_Array($order)) {
			urlredirect($this->module->plugins["modules"]->PrepareLink("account/history/"));
		}

		$cart = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:shop_cart']} WHERE item_order={$order[order_id]}"
		);

		if (is_array($cart)) {
			foreach ($cart as $key => $val) {
				$cart[$key]["item_price"] = $this->module->plugins["products"]->FormatPrice($val["item_price"]);
				$cart[$key]["item_total"] = $this->module->plugins["products"]->FormatPrice($val["item_total"]);
			}
			
		}
		

		//format prices
		$prices = array(
			"order_price_total" , "order_price_tax" , "order_price_shipping"
		);

		foreach ($prices as $key => $val) {
			$order[$val] = $this->module->plugins["products"]->FormatPrice($order[$val]);
		}
		
		//format order
		$order["date"] = Date($this->tpl_module["settings"]["set_history_date_format"] , $order["order_date"]);


		$order["products"] = CTemplateStatic::Replace(
			$base->html->table(
				$this->private->templates["order-details"],
				"Products",
				$cart
			),
			$order
		);

		$return = CTemplateStatic::Replace(
			$this->private->templates["order-details"]->blockReplace(
				"Main",
				$order
			),
			array(
				"shop_menu"	=> $this->UserMenu("2"),
				"user_menu"	=> $this->module->plugins["users"]->UserMenu(),
			)
		);

		return $this->Texts(
			$return
		);
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
	function UserMenu($selected = "") {
		$this->__init();

		if (!$this->isEnabled()) {
			return "";
		}
		
		

		return $this->texts(
			$this->private->templates["user-menu"]->BlockReplace(
				"Menu",
				array(
					"selected_1"	=> $selected == "1" ? "selected" : "",
					"selected_2"	=> $selected == "2" ? "selected" : "",

					"download"		=> $this->tpl_module["settings"]["set_account_download"] ? $this->private->templates["user-menu"]->blockReplace(
						"Download" , 
						array(
							"selected_3"	=> $selected == "3" ? "selected" : "",
						)
					) : "",
				)
			)
		);
			
	}

	
	function ProfileShop() {
		global $_SESS;

		$data = $_SESS["client"];

		$data["countries"] = $this->GetCountries(false , true);


		$return = CTemplateStatic::Replace(
			$this->private->templates["profile"]->blockreplace(
				"Shop",
				$data
			),
			array(
				"shop_menu"	=> $this->UserMenu("1"),
				"user_menu"	=> $this->module->plugins["users"]->UserMenu(),
			)
		);

		return $this->texts(
			$return
		);
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
	function ajax_update_profile() {
		global $_SESS;

		if (!$_SESS["client"]["user_id"]) {
			return $this->module->plugins["common"]->SuccessMsg(
				"",
				$this->module->plugins["modules"]->PrepareLink("signin/")
			);
		}

		if ($_SERVER["REQUEST_METHOD"] != "POST") {
			return "invalid request";
		}		

		$fields = array(
			"user_shipping_phone",
			"user_shipping_country",
			"user_shipping_zip",
			"user_shipping_state",
			"user_shipping_city",
			"user_shipping_address_1",
			"user_shipping_address_2",
			"user_shipping_last_name",
			"user_shipping_first_name",
			"user_billing_phone",
			"user_billing_country",
			"user_billing_zip",
			"user_billing_state",
			"user_billing_city",
			"user_billing_address_1",
			"user_billing_address_2",
			"user_billing_last_name",
			"user_billing_first_name",
		);

		
		//prepare the update field
		foreach ($fields as $key => $val) {			
			$new_data[$val] = $_POST[$val];
		}

		$this->db->QueryUpdate(
			$this->tables['plugin:users'],
			$new_data,
			"user_id=" . $_SESS["client"]["user_id"]
		);

		$this->module->plugins["users"]->UpdateSession();

		return  $this->module->plugins["common"]->SuccessMsg(
			$this->tpl_module["settings"]["set_account_shop_saved"]
		);

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
	function CheckoutSteps($step) {
		global $base , $_SESS;

		$steps = array(
			"1"	=> array(
				"title"		=>	$this->tpl_module["settings"]["set_steps_1_title"],
				"subtitle"	=>	$this->tpl_module["settings"]["set_steps_1_subtitle"],
				"link"		=>	$this->module->plugins["modules"]->PrepareLink("cart/")
			),

			"2"	=> array(
				"title"		=>	$this->tpl_module["settings"]["set_steps_2_title"],
				"subtitle"	=>	$this->tpl_module["settings"]["set_steps_2_subtitle"],
				"link"		=>	$this->module->plugins["modules"]->PrepareLink("cart/checkout/")
			),

			"2_ns"	=> array(
				"title"		=>	$this->tpl_module["settings"]["set_steps_2_title_ns"],
				"subtitle"	=>	$this->tpl_module["settings"]["set_steps_2_subtitle_ns"],
				"link"		=>	$this->module->plugins["modules"]->PrepareLink("cart/checkout/")
			),

			"3"	=> array(
				"title"		=>	$this->tpl_module["settings"]["set_steps_3_title"],
				"subtitle"	=>	$this->tpl_module["settings"]["set_steps_3_subtitle"],
				"link"		=>	$this->module->plugins["modules"]->PrepareLink("cart/checkout/shipping/")
			),

			"4"	=> array(
				"title"		=>	$this->tpl_module["settings"]["set_steps_4_title"],
				"subtitle"	=>	$this->tpl_module["settings"]["set_steps_4_subtitle"],
				"link"		=>	$this->module->plugins["modules"]->PrepareLink("cart/checkout/review/")
			),

			"4_ns"	=> array(
				"title"		=>	$this->tpl_module["settings"]["set_steps_4_title_ns"],
				"subtitle"	=>	$this->tpl_module["settings"]["set_steps_4_subtitle_ns"],
				"link"		=>	$this->module->plugins["modules"]->PrepareLink("cart/checkout/review/")
			),

			"5"	=> array(
				"title"		=>	$this->tpl_module["settings"]["set_steps_5_title"],
				"subtitle"	=>	$this->tpl_module["settings"]["set_steps_5_subtitle"],
				"link"		=>	$this->module->plugins["modules"]->PrepareLink("cart/checkout/payment/")
			),

			"5_ns"	=> array(
				"title"		=>	$this->tpl_module["settings"]["set_steps_5_title_ns"],
				"subtitle"	=>	$this->tpl_module["settings"]["set_steps_5_subtitle_ns"],
				"link"		=>	$this->module->plugins["modules"]->PrepareLink("cart/checkout/payment/")
			),

		);

		$hasShipping = $this->HasShipping();

		if (!$hasShipping) {

			$steps["2"] = $steps["2_ns"];
			$steps["4"] = $steps["4_ns"];
			$steps["5"] = $steps["5_ns"];

			unset($steps["2_ns"]);
			unset($steps["4_ns"]);
			unset($steps["5_ns"]);
			unset($steps["3"]);
		} else {
			unset($steps["2_ns"]);
			unset($steps["4_ns"]);
			unset($steps["5_ns"]);
		}
		

		
		foreach ($steps as $key => $val) {

			if (!$found) {
				$steps[$key]["class"] = "checked";
			}

			if ($key == $step) {
				$found = true;
				$steps[$key]["class"] = "selected";
			}
			
			if ($found && ($key != $step)) {
				$steps[$key]["class"] = "disabled";
				$steps[$key]["link"] = "#";
			}			
			
		}


		//prepare the quick shop summary
		if (is_array($_SESS["cart"]) && count($_SESS["cart"])) {
			foreach ($_SESS["cart"] as $key => $val) {
				$products += $val["qty"];
				$total += $val["qty"] * $val["price"];
			}			
		}

		
		$return = CTemplateStatic::Replace(
			$base->html->Table(
				$this->private->templates["checkout-title"],
				"Steps" ,
				$steps
			),
			array(
				"title"	=> $this->private->templates["checkout-title"]->BlockReplace(
					"Title",
					array(
						"products"	=> (int)$products,
						"total"		=> $this->module->plugins["products"]->FormatPrice($total),
					)
				)
			)
		);

		return $this->Texts($return);	
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
	function cartEmptyCheck() {
		global $_SESS;

		if (!$_SESS["cart"] || !count($_SESS["cart"])) {

			urlredirect(
				$this->module->plugins["modules"]->PrepareLink("cart/")
			);
		}

		if ($this->vars->data["set_shop_require_users"]) {
			$this->module->plugins["users"]->__check_session(
				"cart/checkout/"
			);
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
	function ProfileDownloads() {
		global $_SESS , $base;

		$records = $this->GetDownloads();

		$return = $this->private->templates["profile-downloads"]->blockReplace(
			"Main" , 
			array(
				
				"files"		=> $base->html->Table(
					$this->private->templates["profile-downloads"],
					"",
					$records	["records"]
				),
						
			
				"shop_menu"	=> $this->UserMenu("3"),
				"user_menu"	=> $this->module->plugins["users"]->UserMenu(),


				"paging"=> $this->module->plugins["paging"]->Paging(
					$records["pages"] , 
					$records["page"], 
					array(
						"first"		=> $this->module->plugins["modules"]->PrepareLink("account/download/"),
						"all"		=> $this->module->plugins["modules"]->PrepareLink("account/download/{PAGE}") ,
					),
					array(
						"ipp"	=> $records["ipp"],
						"total"	=> $records["count"]
					)
				),

			)
		);

		return $this->Texts($return);

		/*


LIMIT 0 , 30
*/
	}
	
	function GetDownloads() {
		global $_SESS;
		
		$count = $this->tpl_module["settings"]["set_download_pp"];
//		$count = 10;
		$page = $_GET["page"];


		$_count = $this->db->QFetchArray(
			"SELECT 
				count(f.item_id) as count
			FROM 
				{$this->tables['plugin:shop_orders']} AS o, 
				{$this->tables['plugin:shop_cart']} AS c, 
				{$this->tables['plugin:shop_files']} AS f
			WHERE 
				f.item_parent = c.item_product_id
				AND o.order_id = c.item_order 
				AND o.order_user={$_SESS[client][user_id]}
				AND (order_status=2 OR order_status=5)
			ORDER BY 
				order_date DESC, 
				item_product ASC
			"
		);

		$item_count = $_count["count"];

		$page = $_GET["page"];

		if (!$page && $item_count) {
			$page = 1;
		} else 
			$page = (int)$page;


		$files = $this->db->QFetchRowArray(
			"SELECT 
				f.item_title as file_title, 
				f.item_id as file_id , 
				f.item_file_file as file_file, 
				f.item_last_update	as file_date,
				item_product,item_product_sku, 
				item_date,order_code , 
				order_date
			FROM 
				{$this->tables['plugin:shop_orders']} AS o, 
				{$this->tables['plugin:shop_cart']} AS c, 
				{$this->tables['plugin:shop_files']} AS f
			WHERE 
				f.item_parent = c.item_product_id
				AND o.order_id = c.item_order 
				AND o.order_user={$_SESS[client][user_id]}
				AND (order_status=2 OR order_status=5)

			ORDER BY 
				order_date DESC, 
				item_product ASC

			LIMIT " . ( max(0,($page - 1 ) * $count )) . " , " . $count 
			
		);


		if (is_array($files)) {
			foreach ($files as $key => $val) {

				$files[$key]["file_date"] = date($this->tpl_module["settings"]["set_download_date_file"] , $val["file_date"]);

				if (($val["item_product"] != $product) || ($order_id != $val["order_code"])) {
					$val["order_date"] = date($this->tpl_module["settings"]["set_download_date_order"] , $val["order_date"]);

					$files[$key]["extra"] = $this->private->templates["profile-downloads"]->blockReplace(
						"Product",
						$val
					);


					$product = $val["item_product"];
					$order_id = $val["order_code"];
				} else {
					$files[$key]["extra"] = "";
				}

			}
			
		}

		return array(
			"records"	=> $files, 
			"count"		=> $item_count , 
			"pages"		=> $item_count ? ceil($item_count / $count) : 1,
			"page"		=> $page,

			"ipp"		=> $count,
		);

	}


		
}


?>