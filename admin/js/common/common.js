/*
	OXYLUS Developement web framweork
	copyright (c) 2002-2005 OXYLUS Developement

	$Id: common.js,v 0.0.1 10/05/2005 20:38:15 Exp $
	Dinamic libraries loader

	Note: tested in IE 5.0 , MOZILLA FIREFOX, OPERA

	contact:
		www.oxylus.ro
		devel@oxylus.ro

		office@oxyls.ro

	ALL THIS CODE IS THE PROPERTY OF OXYLUS DEVELOPEMENT. YOU CAN'T USE ANY OF THIS CODE WITHOUT
	A WRITTEN ACCORD BETWEEN YOU AND OXYLUS DEVELOPEMENT. ALL ILLEGAL USES OF CODE WILL BE TREATED
	ACCORDING THE LAWS FROM YOUR COUNTRY.

	THANK YOU FOR YOUR UNDERSTANDING.
	FOR MORE INFORMATION PLEASE CONTACT US AT: office@oxylus.ro
*/

	function SelectElement(select,which) {
		for (var i = 0; i < select.options.length; i++) {          
			if ( select.options[i].value == which )                    
				select.options[i].selected=true;
		}
	}

	function RadioElement(radio,which) {
		for (var i = 0; i < radio.length; i++) {          
			if ( radio[i].value == which )                    
				radio[i].checked=true;
		}
	}

	function GetSelectText(select) {
		for (var i = 0; i < select.options.length; i++) {          
			if ( select.options[i].selected == true )                    
				return select.options[i].text;
		}
	}

	function GetSelectValue(select) {
		for (var i = 0; i < select.options.length; i++) {          
			if ( select.options[i].selected == true )                    
				return select.options[i].value;
		}
	}

	function NewWindow(mypage, myname, w, h, scroll) {
		var winl = (screen.width - w) / 2;
		var wint = (screen.height - h) / 2;
		winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+',toolbar=no,menubar=no,statusbar=no,status=no,resizable=no'
		return window.open(mypage, myname, winprops)
	}

	function Name2Url( link  ) {

		var replace = {
				"À"	:	"A",
				"Á"	:	"A",
				"Â"	:	"A",
				"Ã"	:	"A",
				"Ä"	:	"A",
				"Å"	:	"A",
				"Ç"	:	"C",
				"È"	:	"E",
				"É"	:	"E",
				"Ê"	:	"E",
				"Ë"	:	"E",
				"Ì"	:	"I",
				"Í"	:	"I",
				"Î"	:	"I",
				"Ï"	:	"I",
				"Ð"	:	"D",
				"Ñ"	:	"N",
				"Ò"	:	"O",
				"Ó"	:	"O",
				"Ô"	:	"O",
				"Õ"	:	"O",
				"Ö"	:	"O",
				"Ù"	:	"U",
				"Ú"	:	"U",
				"Û"	:	"U",
				"Ü"	:	"U",
				"Ý"	:	"Y",
				"Ţ"	:	"T",
				"Ť"	:	"T",
				"Š"	:	"S",
				"Ş"	:	"S",
				"Ŝ"	:	"S",
				"Ś"	:	"S",
				"Ř"	:	"R",
				"Ŕ"	:	"R",
				"Ń"	:	"N",
				"Ņ"	:	"N",
				"Ň"	:	"N",

				
				"à"	:	"a",
				"á"	:	"a",
				"â"	:	"a",
				"ã"	:	"a",
				"ä"	:	"a",
				"å"	:	"a",
				"ç"	:	"c",
				"è"	:	"e",
				"é"	:	"e",
				"ê"	:	"e",
				"ë"	:	"e",
				"ì"	:	"i",
				"í"	:	"i",
				"î"	:	"i",
				"ï"	:	"i",
				"ð"	:	"d",
				"ñ"	:	"n",
				"ò"	:	"o",
				"ó"	:	"o",
				"ô"	:	"o",
				"õ"	:	"o",
				"ö"	:	"o",
				"ù"	:	"u",
				"ú"	:	"u",
				"û"	:	"u",
				"ü"	:	"u",
				"ý"	:	"y",
				"ţ"	:	"t",
				"ť"	:	"t",
				"š"	:	"s",
				"ş"	:	"s",
				"ŝ"	:	"s",
				"ś"	:	"s",
				"ř"	:	"r",
				"ŕ"	:	"r",
				"ń"	:	"n",
				"ņ"	:	"n",
				"ň"	:	"n",

				" " : "-",
				"&" : "-and-",
				"?" : "", 
				":" : "-", 
				")" : "-", 
				"(" : "-", 
				"{" : "-", 
				"}" : "-", 
				"'" : "-",
				"/" : "-",
				"!" : "",
				"," : "-",
				"\"" : "",
				"(" : "-",
				")" : "-",
				"'" : "",
				"'" : "",
				"__" : "-"
			}

		var data = link.trim();

		for (i in replace){
			data = str_replace( i , replace[i] , data);
		}

		while (data.indexOf("--") != -1){
			data = str_replace( "--" , "-" , data);
		}

		return data;
	}


	function getAbsolutePos (el) {
		var r = { 
				x: el.offsetLeft, 
				y: el.offsetTop , 
				width: el.offsetWidth, 
				height: el.offsetHeight
			};

		if (el.offsetParent) {
			var tmp = getAbsolutePos (el.offsetParent);
			r.x += tmp.x;
			r.y += tmp.y;
		}

		return r;
	};


  
   function basename(path) {
  
       return path.replace(/\\/g,'/').replace( /.*\//, '' );
  
   }
  
    
  
   function dirname(path) {
  
       return path.replace(/\\/g,'/').replace(/\/[^\/]*$/, '');;
  
   }

