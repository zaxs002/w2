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


			if ($_GET["module_id"]) {
				//read the module
				$this->tpl_module = $this->module->plugins["modules"]->getModuleInfo($_GET["module_id"]);
			}
			
			switch ($sub) {
				case "landing":
				case "orders":

					if ($_GET["action"] == "edit") {
						$data = new CSQLAdmin("shop/cart", $this->__parent_templates,$this->db,$this->tables,$extra);
						$extra["edit"]["after"] = $data->DoEvents();
						
					}

					//delete ther cart content if i delete a certain order
					if (($_GET["action"] == "delete") && $_GET["order_id"]) {
						$this->db->QUery("DELETE FROM {$this->tables['plugin:shop_cart']} WHERE item_order={$_GET[order_id]}");
					}
					

					$data = new CSQLAdmin("shop/orders", $this->__parent_templates,$this->db,$this->tables,$extra);

					$data->functions = array( 
							"onstore" => array(&$this , "MailOrder"),
					);					

					return $data->DoEvents();
				break;

				case "global":
						$data = new CFormSettings($this->forms_path  . $sub . ".xml" ,$_CONF["forms"]["admintemplate"] , $this->db,$this->tables);

						if ($data->Done()) {

							$this->vars->SetAll($_POST);
							$this->vars->Save();

							urlRedirect("index.php?mod=oxymall&sub=oxymall.plugin.shop.global&action=details");

						}
						return $data->Show($this->vars->data);
				break;

				case "accounts":
					
					$data = new CSQLAdmin("shop/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);

					return $data->DoEvents();
				break;

				case "shipp_methods":
				case "shipp_countries":
					$data = new CSQLAdmin("shop/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);
					return $data->DoEvents();
				break;


			}
		}
	}

	function BuildOrderEmail($code , $admin = false) {
		global $base , $_CONF;

		
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

	function MailOrder($record) {
		if ($record["order_id"] && $record["send_mail"]) {


			if ($record["order_status"] > 1) {

				$order = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:shop_orders']} WHERE order_id={$record[order_id]}");

				$email = $this->module->plugins["mail"]->SendMail(
					$this->module->plugins["mail"]->GetMail(
						$this->vars->data["set_shop_mail_admin_" . $record["order_status"]],
						array_merge(
							array(
								"order_data"	=> $this->BuildOrderEmail($order["order_code"] , false)
							),
							$order
						)
					)
				);			
			}
		}		
	}


}

?>