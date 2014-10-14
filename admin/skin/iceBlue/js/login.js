
		var __code = false;
		var __url_submit = "index.php?mod=auth&sub=ajax&action=login";
		var __url_recover = "index.php?mod=auth&sub=ajax&action=recover";

		function ShowForget() {
				
			pos = getAbsolutePos(document.getElementById("forgotLink"));

			form = document.getElementById("recoverForm");
			form.style.top = (pos.y + 14) + "px";
			form.style.left = pos.x  + "px";
			form.style.display = form.style.display  == "block" ? "none" : "block";

			if (form.style.display  == "block") {
				document.getElementById("recoverEmail").focus();
			}
		}

		function ShowError(txt){
			document.getElementById("errorContent").innerHTML = txt;
			document.getElementById("errorMsg").style.display = "block";
		}

		function ShowRecoverComplete(){ 
				ShowError("<span style='color: green'>Please check your email for the new password!</span>");
		}

		function SubmitForget() {
			var form = document.getElementById("recover");

			var response = HTTPPostRequest(
				false,
				__url_recover,
				{
					"email" : form.email.value
				}
			);

			switch (response) {
				case "invalid":
					ShowError("Invalid email!");
				break;

				case "ok":
					ShowError("<span style='color: green'>Please check your email and follow the instructions there to finish the recover password process!</span>");
					ShowForget();
				break;
			}
		
		}


		function SubmitLogin(){
			var form = document.getElementById("form");

			if (!form.username.value || !form.password.value) {
				ShowError(__code ? "Please fill in all fields!" : "Please fill in both username and password!");

			} else {

				var response = HTTPPostRequest(
					false,
					__url_submit,
					{
						"username" : form.username.value,
						"password" : form.password.value,
						"remember" : form.remember.checked ? "1" : "0",
						"code" : form.code.value
					}
				);

				switch (response) {
					case "invalid":
						ShowError("Invalid account!");
					break;

					case "password":
						ShowError("Invalid password!");
						form.password.value = "";
						form.password.focus();
					break;

					case "ok":
						window.location.reload();				
					break;

					case "code":
						//show the fill in value
						document.getElementById("content").className = "fullform";
						document.getElementById("security").src='index.php?global=security&date=' + (new Date()).getTime();

						//reset the code
						form.code.value = "";

						if (__code == true) {
							ShowError("Verification code and image must match!");
						} else {
							ShowError("Enter the verification code in order to login!");
							__code = true;
						}
						
					break;
				}
				
			}
		}
