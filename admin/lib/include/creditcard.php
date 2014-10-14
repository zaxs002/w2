<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus.ro
		mail: support@oxylus.ro		

	$Id: name.php,v 0.0.1 dd/mm/yyyy hh:mm:ss author Exp $
	description
*/

// dependencies

class CreditCard {

	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function Valid($type , $nr) {

		//strip any values which arent digits
		$nr = CreditCard::Strip($nr);

		//supported creditcards for size,preffix validation
		$supported = array(
							"visa" => true,
							"mc" => true,
							"discovery" => true,
							"jcb" => true,
							"amex" => true,
					);

		//check if size/preffix is supported, if not do just the luhn validation
		if (array_key_exists($type,$supported)) {

			switch ($type) {
				case "visa":
					$size = array(
								13,
								16
							);
					$preffix = "4";
				break;

				case "mc":
					$size = 16;
					$preffix = array(
									51,
									52,
									53,
									54,
									55
								);
				break;

				case "discovery":
					$size = 16;
					$preffix = "6011";
				break;

				case "jcb":
					$size = array(
								15,
								16
							);

					$preffix = array(
								"3",
								"2131",
								"1800"							
							);
				break;

				case "amex":
					$size = array(
								34,
								37
							);
					$preffix = 15;
				break;
			}

/*
		debug(array(
				"type" => $type , 
				"nr"=> $nr,
				"size" => $size,
				"preffix" => $preffix
			));
*/
			//now do the tricks
			if (isset($size) && isset($preffix)) {

				$valid = false;
				//check the size first
				if (is_array($size)) {
					foreach ($size as $key => $val) {
						if ($val == strlen($nr)) {
							//found a number, stop the cicle
							$valid = true;
							break;
						}					
					}				
				} else
					$valid = (bool) $size == strlen($nr);

				//check if valid, if not no need to check for preffix anymore
				if (!$valid)
					return false;

				$valid = false;

				if (is_array($preffix)) {
					foreach ($preffix as $key => $val) {
						if ($val == substr($nr,0,strlen($val)) ) {
							$valid = true;
							break;
						}					
					}				
				} else
					$valid = (bool) $preffix == substr($nr , 0 , strlen ($preffix));
						
				//check if valid, if not no need to check luhn
				if (!$valid)
					return false;
			}
		}	
		
		//finally do the luhn algorithm
		return CreditCard::__luhn($nr) ? $nr : false;			

	}


	function Strip($nr) {
		if (strlen($nr)) {
			for ($i = 0 ; $i<strlen($nr) ; $i++) {
				if (array_key_exists($nr[$i], array (0,1,2,3,4,5,6,7,8,9) )) {
					$_nr .= $nr[$i];
				}
			}

			$nr = $_nr;
		}
	
		return $nr;
	}

	function Protect($nr , $last = 4) {

		if (strlen($nr) > 1) {
			$count = 1;
			for ($i = strlen($nr); $i > 0 ; $i-- ) {
				if (array_key_exists($nr[$i - 1], array (0,1,2,3,4,5,6,7,8,9) )) {
					 if ($count > $last) {
						 $nr[$i - 1] = "X";					
					 } 
					 $count ++;
				}
				
			}
		}
		
		return $nr;
	}

	//i wont try to understand what here,
	//for more details http://www.beachnet.com/~hstiles/cardtype.html
	function __luhn($number) {
		$l = strlen($number);
			for ($i=0; $i<$l; $i++) {
				$q = substr($number,$l-$i-1,1)*($i%2+1);
				$r += ($q%10)+(int)($q/10);
			}
		return !($r%10);
	}
}
?>