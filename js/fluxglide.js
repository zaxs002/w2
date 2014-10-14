jQuery(function($)
{
	
	/*
	====================
		DECLARATIONS
	====================
	*/
	var win 						= $(window), 
		body 						= $('BODY'),
		mainMenu 					= $('UL#main-menu'),
		mainMenuCont 				= $('DIV.sc_menu_wrapper '),
		contentWrapper 				= $('DIV#content-wrapper'),
		navExtra 					= $('DIV#nav-extra'),
		navExtraList				= $('UL#nav-extra-list'),
		bookmarkShareBtn			= $('LI#bookmark-share-btn'),
		subscribeBtn				= $('LI#subscribe-btn'),
		shoppingCartBtn				= $('LI#shopping-cart-btn'),
		bookmarkSharePanel			= $('DIV#bookmark-share-panel'),
		newsletterPanel 			= $('DIV#newsletter-panel'),
		shoppingCartPanel 			= $('DIV#shopping-cart-panel'),
		shoppingCartList 			= $('#shopping-cart-list'),
		orderCartList 				= $('#order-cart-list'),
		newsletterForm				= $('FORM#newsletter-form'),
		newsletterFormSubmitBtn 	= $('INPUT#newsletter-form-submit-btn'),
		newsletterFormMsg			= $('LI#newsletter-form-msg'),
		bgSlideshow					= $('DIV#bg-slideshow'),
		bgImagesToResize			= [],
		notification				= $('<div class="see-through-bg" id="notification">wrewerwer</div>'),
		four_cols					= $('UL.four-cols'),
		three_cols					= $('UL.three-cols'),
		thumbs_listing				= $('.thumbs-listing'),
		scroll_pane					= $('.scroll-pane'),
		showreel					= $('#showreel-module');
		
	/*
	================
		POSITION
	================
	*/
	var getPosition = function(objW, objH, contW, contH, alignH, alignV, offsetH, offsetV)
	{
		if (typeof objW === 'number' && typeof objH === 'number' && typeof contW === 'number' && typeof contH === 'number')
		{
			if (typeof alignH !== 'string') alignH = 'center';
			if (typeof alignV !== 'string') alignV = 'center';
			if (typeof offsetH !== 'number') offsetH = 0;
			if (typeof offsetV !== 'number') offsetV = 0;
			
			var p = {};
			if (alignH == 'left') { p.left = offsetH; }
			else if (alignH == 'right') { p.left = offsetH + contW - objW; }
			else { p.left = offsetH + Math.round((contW - objW) * 0.5); }
			
			if (alignV == 'top') { p.top = offsetV; }
			else if (alignV == 'bottom') { p.top = offsetV + contH - objH; }
			else { p.top = offsetV + Math.round((contH - objH) * 0.5); }
			return p;
		}
		return { left : 0, top : 0 }
	};
	
	/*
	=============
		SCALE
	=============
	*/
	var getScale = function(objW, objH, contW, contH, scale)
	{
		if (typeof objW === 'number' && typeof objH === 'number' && typeof contW === 'number' && typeof contH === 'number')
		{
			if (typeof scale !== 'string') scale = 'forceFit';
			
			var s = {};
			if (scale == 'none' || scale == 'fit' && contW >= objW && contH >= objH || scale == 'fill' && contW <= objW && contH <= objH)
			{
				s.width = objW;
				s.height = objH;
			}
			else if (scale == 'stretch')
			{
				s.width = contW;
				s.height = contH;
			}
			else
			{
				var objR = objH > 0 ? objW / objH : 0;
				rFlag = objR < (contH != 0 ? contW / contH : 0);
				
				if ((scale == 'fill' || scale == 'forceFill') && !rFlag || (scale == 'fit' || scale == 'forceFit') && rFlag)
				{
					s.height = contH;
					s.width = Math.round(contH * objR);
				}
				else
				{
					s.width = contW;
					s.height = Math.round(objR != 0 ? contW / objR : 0);
				}
			}
			return s;
		}
		return { width : 0, height : 0 };
	};
	
	/*
	====================
		NOTIFICATION
	====================
	*/
	notification
		.fadeTo(0, 0)
		.css('display', 'none')
		.prependTo(body)
		.click(function(e)
		{
			hideNotification();
			e.preventDefault();
		});
		
	var notificationTimer = false;
	var resetNotificationTimer = function()
	{
		if (notificationTimer != false)
		{
			clearTimeout(notificationTimer);
			notificationTimer = false;
		}
	}
	
	var showNotification = function(content)
	{
		resetNotificationTimer();
		notification
			.stop()
			.fadeTo(0, 0)
			.html(content)
			.css('display', 'block')
			.fadeTo('slow', 1, function()
			{
				resetNotificationTimer();
				notificationTimer = setTimeout(function() { hideNotification(); }, 2000);
			});
	};
	
	var hideNotification = function()
	{
		resetNotificationTimer();
		notification
			.stop()
			.fadeTo('slow', 0, function()
			{
				notification.css('display', 'none');
			});
	};
	

	/*
	=========================
		CHECK OBJECT TYPE
	=========================
	*/
	var is = function(kind, obj) 
	{
		var className = Object.prototype.toString.call(obj).slice(8, -1);
		return (typeof obj !== 'undefined') && obj !== null && className === kind;
	};
	
	/*
	=====================
		ARRAY SHUFFLE
	=====================
	*/
	var arrayShuffle = function(arr)
	{
		for (var i = arr.length; i > 1; --i)
		{
			arr.push(arr.splice(parseInt(Math.random() * i), 1)[0]);
		}
	};
	
	/*
	=================================
		FIX LAST ITEM OF USER BAR
	=================================
	*/
	(function()
	{
		$('NAV#user-bar').children('UL').first().children('LI').last().addClass('last');		
	})();
		
	/*
	=======================================
		RADIO AND CHECKBOX REPLACEMENTS
	=======================================
	*/
	/*(function()
	{
		var groups = {};	
		$('input[type=radio]').add('input[type=checkbox]').each(function()
		{
			var input = $(this),
				mark = $('<span>').addClass('check-box-mark'),	
				checkbox = $('<span>').addClass('check-box').append(mark);
				
			if (input.attr('type') == 'radio')
			{
				var group = input.attr('name');
				if (group)
				{
					if (!groups[group]) groups[group] = $('input[name=' + group + ']');
					input.data('group', groups[group]);
				}
			}
			
			input.before(checkbox).appendTo(checkbox).change(function()
			{
				if (input.is(':checked'))
				{
					mark.css('display', 'block');
					if (input.data('group')) input.data('group').not(input).change();
				}
				else { mark.css('display', 'none'); }				
			}).change();
		});
		groups = null;
	})();*/
	
	
	/*
	=====================
		GENERAL FIXES
	=====================
	*/
	$('a[href=#]').removeAttr('href').addClass('nolink');
	
	$('DIV.module').children('header').first().css('z-index', 150);
	/*$('TABLE').each(function()
	{
		var tr = $(this).find('TR');
		tr.first().addClass('first');
		tr.last().addClass('last');
		tr.each(function()
		{
			var td = $(this).children('TD');
			td.first().addClass('first');
			td.last().addClass('last');
		});
	});*/
	
	/*
	=================
		DROP LIST
	=================
	*/
	(function()
	{
		$('DIV.drop-list').each(function()
		{
			var self 	= $(this).removeClass('opened'),
				topBtn 	= self.children('span').first(),
				list	= self.children('ul').first().fadeTo(0, 0).css('display','none'),
				opened	= false;
			
			self.mousedown(function(e)
			{
				if (opened)
				{
					opened = false;
					list.stop().fadeTo('fast', 0, function() 
					{
						self.removeClass('opened');
						list.css('display', 'none') 
					});					
				}
				else
				{
					opened = true;
					self.addClass('opened');
					list.stop().css('display', 'block').fadeTo('fast', 1);
				}
				e.preventDefault();
			});
		});
	})();
	
	/*
	=================
		MAIN MENU
	=================
	*/
	(function()
	{
		mainMenu.children('li').has('ul').not('.selected').each(function()
		{
			var li = $(this);
			li.data('oh', li.height())
				.data('ch', li.children('a').first().outerHeight())
				.css('height', li.data('ch'))
				.hover(function()
				{
					li.stop().animate({ height: li.data('oh') });
				},
				function()
				{
					li.stop().animate({ height: li.data('ch') });
				});
		});	
	})();
	
	/*
	=========================
		VERIFICATION CODE
	=========================
	*/
	$('.verification-code').each(function()
	{
		var vc 			= $(this),
			img 		= vc.find('IMG.verification-image').first(),
			refresh 	= vc.find('A.refresh-button').first();
			
		img.click(function(e) { e.preventDefault(); });
		refresh
			.data('code-src', refresh.attr('href'))
			.removeAttr('href')
			.click(function(e)
			{
				img.attr('src', refresh.data('code-src') + '?nc=' + (new Date).getTime());				
				e.preventDefault();
			});
	});
	
	/*
	===================
		TEXT INPUTS
	===================
	*/
	$('INPUT[data-default-value]').each(function()
	{
		var inp = $(this);
		inp
			.focus(function() 
			{ 
				if (inp.val() == inp.data('default-value')) inp.val(''); 
			})
			.blur(function() 
			{ 
				if (inp.val() == '') inp.val(inp.data('default-value')); 
			});
	});
	
	/*
	=================
		AJAX FORM
	=================
	*/
	var initAjaxForm = function(form, formSubmitBtn, formMsg)
	{
		if (form.length > 0)
		{
			var waitMsg = formMsg.html();			
			formMsg.empty();
			
			form.submit(function(e)
			{
				formMsg.html(waitMsg);
				formSubmitBtn.attr('disabled', true);
				
				$.ajax(
				{
					url			:	form.attr('action'),
					type		:	form.attr('method'),
					data		:	form.serialize(),
					dataType 	: 	'text',
					success		:	function(data) 
					{
						formMsg.html(data);
						formSubmitBtn.attr('disabled', false);
						if (data.indexOf('class="success"') > 0)
						{
							if ((typeof form.attr('id') == 'undefined') || 
								!jQuery.inArray
								(
									form.attr("id") , 
									["dummy" , "account-info-form" , "shop-info-form" , "step1-form" , "step2-form" , "step3-form"]
								)) 
							{
								form.find(':input')
									.not(':button, :submit, :reset, :hidden')
									.val('')
									.attr('checked', false)
									.attr('selected', false);
							} 
							else 
							{
								
							}
						}
					}
				});				
				e.preventDefault();
			});	
		}
	};
	
	/*
	============
		CART
	============
	*/
	(function()
	{
		if (shoppingCartList.length > 0 || orderCartList.length > 0)
		{
			var prefix = 'shopping';
			if (orderCartList.length > 0) 
			{
				shoppingCartList = orderCartList;
				prefix = 'order';
				if (shoppingCartBtn.length > 0) shoppingCartBtn.remove();
			}
			var shoppingCartListInit = function()
			{
				//$('UL#' + prefix + '-cart-entries').children('LI').children('UL').each(function()
				shoppingCartList.find('TABLE.list TBODY TR').each(function()
				{
					var quantityLi			= $(this).children('TD.quantity').first(), 
						minusBtn 			= quantityLi.children('A.quantity-minus-btn').first(),
						quantityInp 		= quantityLi.children('INPUT[type=text]').first(),
						quantity 			= 1,
						plusBtn 			= quantityLi.children('A.quantity-plus-btn').first(),
						quantityModified	= false,
						refreshQuantity 	= function()
						{
							var newQuantity = quantity;
							if ($.isNumeric(quantityInp.val())) 
							{ 
								newQuantity = Math.max(1, Math.min(999, parseInt(quantityInp.val()))); 
							}
							if (quantity != newQuantity)
							{
								quantityModified = true;
								quantity = newQuantity;
							}
							quantityInp.val(quantity);
						},
						actionLi			= $(this).children('TD.action'),
						removeBtn 			= actionLi.children('A.icon-button');
						
					refreshQuantity();
					quantityModified = false;
					
					minusBtn
						.removeAttr('href')
						.click(function(e)
						{
							if (quantity > 1)
							{
								quantity--;
								quantityInp.val(quantity);
								quantityModified = true;
							}
							
							e.preventDefault();
						})
						.mouseleave(function(e)
						{
							if (quantityModified)
							{
								shoppingCartList.submit();
								quantityModified = false;
							}
							
							e.preventDefault();
						});
					
					plusBtn
						.removeAttr('href')
						.click(function(e)
						{
							quantity++;
							quantityInp.val(quantity);
							quantityModified = true;
							
							e.preventDefault();
						})
						.mouseleave(function(e)
						{
							if (quantityModified)
							{
								shoppingCartList.submit();
								quantityModified = false;
							}
							
							e.preventDefault();
						});
					
					quantityInp.blur(function() 
					{ 
						refreshQuantity();
						
						if (quantityModified)
						{
							shoppingCartList.submit();
							quantityModified = false;
						}
					});
					
					removeBtn.removeAttr('href').click(function(e)
					{
						quantity = 0;
						quantityInp.val(quantity);
						shoppingCartList.submit();
						
						e.preventDefault();
					});
				});
			};
			
			shoppingCartList.submit(function(e)
			{
				$.ajax(
				{
					url			:	shoppingCartList.attr('action'),
					type		:	shoppingCartList.attr('method'),
					data		:	shoppingCartList.serialize(),
					dataType 	: 	'text',
					success		:	function(data) 
					{
						shoppingCartList.empty();
						shoppingCartList.html(data);
						shoppingCartListInit();
						win.resize();
					}
				});
				
				e.preventDefault();
			});
			
			shoppingCartListInit();
		}
	})();
	
	/*
	=================
		NAV EXTRA
	=================
	*/
	(function()
	{
		var p = (navExtra.width() - navExtraList.width()) * .5;
		navExtraList.css({ width: navExtra.width() - p, paddingLeft: p });
		
		var panelBtns = $([]);
		if (bookmarkShareBtn.length > 0 && bookmarkSharePanel.length > 0) { panelBtns.push(bookmarkShareBtn.data('panel', bookmarkSharePanel)); }
		if (subscribeBtn.length > 0 && newsletterPanel.length > 0) { panelBtns.push(subscribeBtn.data('panel', newsletterPanel)); }
		if (shoppingCartBtn.length > 0 && shoppingCartPanel.length > 0) { panelBtns.push(shoppingCartBtn.data('panel', shoppingCartPanel)); }
		
		var select = function(btn)
			{
				if (!btn.hasClass('selected'))
				{
					var panel = btn.addClass('selected').data('panel');
					panelBtns.each(function() { if (btn != this) deSelect(this); });
					panel.stop().css('visibility', 'visible').fadeTo('slow', 1);
					if (btn === subscribeBtn)
					{
						newsletterForm[0].reset();
						newsletterFormMsg.empty();
					}
				}
			},
			deSelect = function(btn)
			{
				if (btn.hasClass('selected'))
				{
					var panel = btn.removeClass('selected').data('panel');
					panel.stop().fadeTo('fast', 0, function() { panel.css('visibility', 'hidden'); });
				}
			},
			toggle = function(btn)
			{
				if (btn.hasClass('selected')) deSelect(btn);
				else select(btn);
			};
			
		panelBtns.each(function()
		{
			var btn = this, panel = btn.data('panel'), panelX = panel.children('header').first().children('a.icon-button').has('span.x-icon').first();
			if (btn.hasClass('selected')) panel.css('visibility', 'visible');
			else panel.fadeTo(0, 0);			
			btn.click(function() { toggle(btn); });
			panelX.click(function() { deSelect(btn); });
		});		
		
	})();
	
	/*
	=======================
		SAME AS BILLING
	=======================
	*/
	(function()
	{
		var initSameAsBilling = function(sameAsBilling, billingForm, shippingForm)
		{
			if (sameAsBilling.length > 0 && billingForm.length > 0 && shippingForm.length > 0)
			{
				sameAsBilling.change(function()
				{
					if (sameAsBilling.is(':checked'))
					{
						billingForm.find(':input').each(function()
						{
							var el 	= $(this),
								el2 = shippingForm.find('[name=' + el.attr('name').replace('billing', 'shipping') + ']');
								
							el2.val(el.val());
							if (el2.is('select') && el2.change) el2.change();
						});
					}
				});
			}
		};
		
		initSameAsBilling($('INPUT#same-as-billing'), $('#billing-form'), $('#shipping-form'));
	})();
	
	/*
	=======================
		NEWSLETTER FORM
	=======================
	*/
	initAjaxForm
	(
		$('FORM#newsletter-form'), 
		$('INPUT#newsletter-form-submit-btn'), 
		$('LI#newsletter-form-msg')
	);
	
	/*
	====================
		CONTACT FORM
	=====================
	*/
	initAjaxForm
	(
		$('DIV#contact-form').children('FORM').first(), 
		$('INPUT#contact-form-submit-btn'), 
		$('LI#contact-form-msg')
	);
	
	/*
	====================
		SIGN IN FORM
	====================
	*/
	initAjaxForm
	(
		$('FORM#sign-in-form'), 
		$('INPUT#sign-in-form-submit-btn'), 
		$('LI#sign-in-form-msg')
	);
	
	/*
	======================
		JOB APPLY FORM
	======================
	*/
	initAjaxForm
	(
		$('#apply-form').children('FORM'), 
		$('INPUT#apply-form-submit-btn'), 
		$('LI#apply-form-msg')
	);
	
	/*
	====================
		COMMENT FORM
	====================
	*/
	initAjaxForm
	(
		$('#comment-form').children('FORM'), 
		$('INPUT#comment-form-submit-btn'), 
		$('LI#comment-form-msg')
	);
	
	/*
	====================
		RECOVER FORM
	====================
	*/
	initAjaxForm
	(
		$('FORM#recover-form'), 
		$('INPUT#recover-form-submit-btn'), 
		$('LI#recover-form-msg')
	);
	
	/*
	=====================
		REGISTER FORM
	=====================
	*/
	initAjaxForm
	(
		$('FORM#register-form'), 
		$('INPUT#register-form-submit-btn'), 
		$('LI#register-form-msg')
	);
	
	/*
	=========================
		ACCOUNT INFO FORM
	=========================
	*/
	initAjaxForm
	(
		$('FORM#account-info-form'), 
		$('INPUT#account-info-form-submit-btn'), 
		$('LI#account-info-form-msg')
	);

	/*
	======================
		SHOP INFO FORM
	======================
	*/
	initAjaxForm
	(
		$('FORM#shop-info-form'), 
		$('INPUT#shop-info-form-submit-btn'), 
		$('LI#shop-info-form-msg')
	);

	
	if ($('#shop-info-form').length){
		form = $('#shop-info-form');

		sel = form.find("select[name='user_billing_country']");

		sel.val(
			sel.attr("data-selected")
		);

		sel2 = form.find("select[name='user_shipping_country']");

		sel2.val(
			sel2.attr("data-selected")
		);

	}
	
	/*
	=================
		COUNTDOWN
	=================
	*/
	(function()
	{
		$('UL.timer').each(function()
		{
			var ul 			= $(this),
				ul_parent   = ul.parent();
				refresh		= false,
				daysNum		= ul.find('LI.days > SPAN.num').first(),
				hoursNum	= ul.find('LI.hours > SPAN.num').first(),
				minutesNum	= ul.find('LI.minutes > SPAN.num').first(),
				secondsNum	= ul.find('LI.seconds > SPAN.num').first(),
				timeError	= (typeof ul.data('server-time') == 'undefined') ? 0 : parseFloat(ul.data('server-time')) * 1000 - (new Date).getTime(),
				endMs 		= (new Date(ul.data('year'), parseInt(ul.data('month')) - 1, ul.data('day'), ul.data('hour'), ul.data('minute'), ul.data('second'), 0)).getTime(),
				update		= function()
				{
					var initDif, dif = initDif = Math.floor(Math.max(0, endMs - (new Date).getTime() - timeError) / 1000);
					
					var days = Math.floor(dif / 86400);
					if (days > 999) days = 999;
					else if (days < 10) days = '00' + days;
					else if (days < 100) days = '0' + days;
					
					dif = dif % 86400;
					
					var hours = Math.floor(dif / 3600);
					if (hours > 23) hours = 23;
					else if (hours < 10) hours = '0' + hours;
					
					dif = dif % 3600;
					
					var minutes = Math.floor(dif / 60);
					if (minutes > 59) minutes = 59;
					else if (minutes < 10) minutes = '0' + minutes;
					
					dif = dif % 60;
					
					var seconds = Math.floor(dif);
					if (seconds > 59) seconds = 59;
					else if (seconds < 10) seconds = '0' + seconds;
					
					daysNum.html(days);
					hoursNum.html(hours);
					minutesNum.html(minutes);
					secondsNum.html(seconds);
					
					if (initDif > 0) setTimeout(function() { update(); }, 1000);
					else if (refresh) window.location.reload(true);
					
					refresh = true;
				};
				update();
				
				var padd=Math.floor((ul_parent.width()-ul.width())/2);
				ul.css({'padding-left':padd+'px','padding-right':padd+'px',})
				
		});
	})();
	
	/*
	===================
		STEP 1 FORM
	===================
	*/
	initAjaxForm
	(
		$('FORM#step1-form'), 
		$('INPUT#step1-form-submit-btn'), 
		$('LI#step1-form-msg')
	);

	
	if ($('#step1-form').length){
		form = $('#step1-form');

		sel = form.find("select[name='order_billing_country']");
		
		sel.val(
			sel.attr("data-selected")
		);

		sel2 = form.find("select[name='order_shipping_country']");

		sel2.val(
			sel2.attr("data-selected")
		);

	}
	
	/*
	===================
		STEP 2 FORM
	===================
	*/
	initAjaxForm
	(
		$('FORM#step2-form'), 
		$('INPUT#step2-form-submit-btn'), 
		$('LI#step2-form-msg')
	);
	
	/*
	===================
		STEP 4 FORM
	===================
	*/
	initAjaxForm
	(
		$('DIV#authorize > FORM'), 
		$('INPUT#cc-form-submit-btn'), 
		$('LI#cc-form-msg')
	);
	
	/*
	=========================
		ASK QUESTION FORM
	=========================
	*/
	initAjaxForm
	(
		$('FORM#ask-question-form'), 
		$('INPUT#ask-question-form-submit-btn'), 
		$('LI#ask-question-form-msg')
	);
	
	/*
	============================
		THUMBS LISTING CLEAR
	============================
	*/
	(function()
	{
		$('DIV.thumbs-listing').each(function()
		{
			var ul = $(this).children('UL').first();
			ul.children('LI').each(function(i)
			{
				if
				(	
					ul.hasClass('three-cols') 	&& i % 3 == 0 ||
					ul.hasClass('four-cols') 	&& i % 4 == 0 ||
					ul.hasClass('five-cols') 	&& i % 5 == 0 ||
					ul.hasClass('six-cols') 	&& i % 6 == 0 ||
					ul.hasClass('seven-cols') 	&& i % 7 == 0
				) 
				{ $(this).css('clear', 'left'); }
			});
		});		
		
	})();
	
	/*
	=====================================
		FIX MODULE HEADER NAV BUTTONS
	=====================================
	*/
	$('DIV.module').children('header').has('UL.module-header-nav-btns').each(function()
	{
		var header = $(this);
		if (header.children('UL.module-header-nav-btns').first().is(':last-child'))
		{
			header.addClass('next-prev-to-right');
		}
	});
	
	/*
	==========================
		ADD TO CART BUTTON
	==========================
	*/
	(function()
	{
		$('INPUT.product-add-to-cart-btn').each(function()
		{
			var submitBtn = $(this),
				form = submitBtn.closest('FORM').first();
				
			form.submit(function(e)
			{
				$.ajax(
				{
					url			:	form.attr('action'),
					type		:	form.attr('method'),
					data		:	form.serialize(),
					dataType 	: 	'text',
					success		:	function(data) 
					{
						shoppingCartList.submit();
						showNotification(data);
					}
				});
				
				e.preventDefault();
			});
		});
	})();
	
	/*
	=======================
		PRODUCT REVIEWS
	=======================
	*/
	(function()
	{
		var productReviews = $('ARTICLE#product-reviews');
		if (productReviews.length > 0)
		{
			var productReviewsList = productReviews.children('UL#product-reviews-list'),
				loadMoreBtn = productReviews.children('A#load-more-product-reviews'),
				loadMoreAction = loadMoreBtn.attr('href'),
				pageCount = 2;
				
			loadMoreBtn.removeAttr('href').click(function(e)
			{
				if (!loadMoreBtn.hasClass('disabled'))
				{
					loadMoreBtn.addClass('disabled');
					
					$.ajax(
					{
						url			:	loadMoreAction,
						type		:	'post',
						data		:	'pid=' + loadMoreBtn.data('pid') + '&p=' + pageCount,
						dataType 	: 	'text',
						success		:	function(data) 
						{
							if (data != '')
							{
								//console.log(data);
								productReviewsList.append(data);
								loadMoreBtn.removeClass('disabled');
								win.resize();
							}
							else
							{
								loadMoreBtn.remove();
							}
						}
					});					
					pageCount++;
				}
				
				e.preventDefault();
			});
			
			initAjaxForm
			(
				$('FORM#review-form'), 
				$('INPUT#review-form-submit-btn'), 
				$('LI#review-form-msg')
			);
		}
		
	})();
	
	/*
	======================
		TABBED CONTENT
	======================
	*/
	(function()
	{
		var lis = $('UL').children('LI[data-content]');
		if (lis.length > 0)
		{
			var selected = false;
			lis.each(function()
			{
				var li = $(this), content = $('#' + li.data('content'));
				if (content.length > 0)
				{
					li.data('content', content);
					if (li.hasClass('selected') && !selected) 
					{ 
						selected = li; 
						content.css('display', 'block'); 
					}
					else 
					{
						li.removeClass('selected');
						content.css('display', 'none'); 
					}
					
					li.click(function(e)
					{
						if (!li.hasClass('selected'))
						{
							if(selected)
							{
								selected.removeClass('selected');
								selected.data('content').css('display', 'none');
							}
							selected = li;
							li.addClass('selected');
							content.css('display', 'block');
						}
						win.resize();
						e.preventDefault();
						e.stopPropagation();
					});
					
					win.resize();
				}
			});
		}
	})();
	
	/*
	============================
		BACKGROUND SLIDESHOW
	============================
	*/
	var bgImageResize = function(img)
	{
		return img
			.css(getScale(img.data('ow'), img.data('oh'), win.width(), win.height(), 'forceFill'))
			.css(getPosition(img.width(), img.height(), win.width(), win.height()));
	};
	
	(function()
	{
		bgSlideshow.on('contextmenu mousedown', function(e) { e.preventDefault(); });
		
		var ul 			= bgSlideshow.children('ul').first(), 
			images 		= [],
			numImages 	= 0;
			
		ul.children('li').each(function(i)
		{
			images[i] = $(this).children('img').first().data('src');
			numImages++;
		});
		ul.remove();
		ul = null;
		
		if (numImages > 0)
		{
			arrayShuffle(images);
			
			var crtIndex	= 0,
				crtImage 	= false,
				newImage 	= false,
				timer 		= false,
				displayNewImage = function()
				{
					if (timer)
					{
						clearTimeout(timer);
						timer = false;
					}
					newImage = $('<img>')
						.fadeTo(0, 0)
						.load(function()
						{
							bgSlideshow.append(newImage);
							if (crtImage) bgImagesToResize = [crtImage, newImage];
							else bgImagesToResize = [newImage];
							bgImageResize(newImage.data({ ow: newImage.width(), oh: newImage.height() }))
							.fadeTo(crtImage ? 5000 : 0, 1, function()
							{
								if (crtImage) crtImage.remove();
								crtImage = newImage;
								bgImagesToResize = [crtImage];
								if (numImages > 1)
								{
									timer = setTimeout(function()
									{
										if (crtIndex >= numImages - 1) crtIndex = 0;
										else crtIndex++;
										displayNewImage();
									}, 15000);
								}
							});
						})
						.attr('src', images[crtIndex]);
				};
				
			displayNewImage();
		}
		
	})();
	
	/*
	=====================
		MESSAGE BOXES
	=====================
	*/
	(function()
	{
		$('DIV.message').one('click', function(e)
		{
			var msg = $(this);
			msg.fadeTo('slow', 0, function() { msg.remove(); win.resize(); });			
			e.preventDefault();
		});
	})();
	
	/*
	=====================
		PAYMENT FORMS
	=====================
	*/
	(function()
	{
		if($('DIV#shop-step4-module').length > 0)
		{
			var initPaymentForm = function(formWrapper)
			{
				var form = formWrapper.children('form').first();
				if (form.length > 0)
				{
					var formSubmitBtn 	= form.find('INPUT[type=submit]').first(),
						formMsg 		= form.find('LI').has('DIV.wait').first(),
						waitMsg			= formMsg.html();
						
					formMsg.empty();
						
					form.submit(function(e)
					{
						formMsg.html(waitMsg);
						formSubmitBtn.attr('disabled', true);
						
						$.ajax(
						{
							url			:	form.attr('action'),
							type		:	form.attr('method'),
							data		:	form.serialize(),
							dataType 	: 	'text',
							success		:	function(data) 
							{
								formWrapper.html(data);
								win.resize();
							}
						});
						
						e.preventDefault();
					});
				}
			};
			
			initPaymentForm($('DIV#paypal'));
			initPaymentForm($('DIV#offline'));
			initPaymentForm($('DIV#pay-with-moneybookers'));
		}
	})();
	
	/*
	============================
		HANDLE WINDOW RESIZE
	============================
	*/
	function makeScrollable(wrapper, scrollable){
		// Get jQuery elements
		var wrapper = $(wrapper), scrollable = $(scrollable);
		wrapper.css({overflow: 'hidden'});						
		
		enable();	
		
		function enable(){
			// height of area at the top at bottom, that don't respond to mousemove
			var inactiveMargin = 99;					
			// Cache for performance
			var wrapperWidth = wrapper.width();
			var wrapperHeight = wrapper.height();
			// Using outer height to include padding too
			var scrollableHeight = scrollable.outerHeight() + 2*inactiveMargin;
			var lastTarget;
			//When user move mouse over menu			
			wrapper.mousemove(function(e){
				// Save target
				lastTarget = e.target;
	
				var wrapperOffset = wrapper.offset();
			
				// Scroll menu
				var top = (e.pageY -  wrapperOffset.top) * (scrollableHeight - wrapperHeight) / wrapperHeight - inactiveMargin;
				if (top < 0){
					top = 0;
				}			
				wrapper.scrollTop(top);
			});
			
			// Setting interval helps solving perfomance problems in IE
			var interval = setInterval(function(){
				if (!lastTarget) return;	
			}, 200);
			
	}}

	mainMenu.wrap('<div class="sc_menu_wrapper"><div class="sc_menu">');
	var mainMenuCont = $('DIV.sc_menu_wrapper ');

	win
		.resize(function()
		{
			contentWrapper
				.width(win.width() - contentWrapper.offset().left)
				.css('top', Math.max(0, (win.height() - contentWrapper.outerHeight()) * .5));
				
			mainMenuCont.height(win.height() - mainMenuCont.position().top - navExtra.height());

			makeScrollable("div.sc_menu_wrapper", "div.sc_menu");
			
			var i = bgImagesToResize.length;
			while (i--) { bgImageResize(bgImagesToResize[i]); }
			
		})
		.one('load', function() { win.resize(); })
		.resize();
		
	/*
	====================
		PRETTY PHOTO
	====================
	*/
	if ($.prettyPhoto)
	{
		$("a[rel^='prettyPhoto']").prettyPhoto();
	}
	
	/*
	====================
		SET HEIGHT
	====================
	*/
	
	if (four_cols.length || three_cols.length){
		var temp_h=0;
		
		thumbs_listing.children('ul').children('li').each(function(){
			var li = $(this).children('.caption');
			if (li.height()>temp_h){
				temp_h=li.height();
			}
		});
		thumbs_listing.children('ul').children('li').children('.caption').css('height',temp_h)
	}
	
	/*
	====================
		SET HEIGHT
	====================
	*/	
	if (scroll_pane.length)
		scroll_pane.jScrollPane({
				horizontalDragMinWidth: 26,
				horizontalDragMaxWidth: 26
		});
	/*
	====================
		SHOWREEL
	====================
	*/			
	if (showreel.length)
		var data_stay=showreel.find('.slides_container').attr('data-stay')*1000;
		showreel.slides({
			preload: true,
			preloadImage: 'css/img/slidesjs/loading.gif',
			play: data_stay,
			pause: 2500,
			hoverPause: true,
			animationStart: function(current){
				$('.caption').animate({bottom:-40},100);
				$('.optional').animate({opacity:0},100);
			},
			animationComplete: function(current){
				$('.caption').animate({bottom:0},200);
				$('.optional').animate({opacity:1},300);
			},
			slidesLoaded: function() {
				$('.caption').animate({bottom:0},200);
			}
		});
		
		$('.bordered').hover(
			function(){
				$(this).animate({ borderLeftWidth: "7px", borderTopWidth: "7px", borderRightWidth: "7px", borderBottomWidth: "7px",width:'-=14',height:'-=14',opacity:0.40}, 100);
			},
			function(){
				$(this).animate({ borderLeftWidth: "0px", borderTopWidth: "0px", borderRightWidth: "0px", borderBottomWidth: "0px",width:'+=14',height:'+=14',opacity:0}, 100);
			}
			
		)
		
	
	/*
	=====================
		FORMS STYLING
	=====================
	*/
	if ($.jqTransform || $.fn.jqTransform)
	{
		$("FORM").jqTransform();
	}
		


});

function loadComments(url , page) {

	$.ajax(
	{
		url			:	"ajax.comments.php",
		type		:	"post",
		data		:	"url=" + escape(url) + "&page="  + page,
		dataType 	: 	'text',
		success		:	function(data) 
		{
			$('#comments-data').html(data);
		}
	});				

}
