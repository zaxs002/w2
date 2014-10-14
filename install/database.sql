DROP TABLE IF EXISTS `site_oxymall_core_modules`;
CREATE TABLE IF NOT EXISTS `site_oxymall_core_modules` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_seo` int(1) NOT NULL,
  `module_mobile` int(1) NOT NULL,
  `module_name` varchar(255) DEFAULT NULL,
  `module_code` varchar(255) DEFAULT NULL,
  `module_file` varchar(255) DEFAULT NULL,
  `module_settings` longtext,
  `module_unique` int(1) DEFAULT NULL,
  `module_unique_enabled` int(1) DEFAULT NULL,
  `module_links` text,
  `module_help` text,
  `module_system` int(1) NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=111 ;

INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(1, 0, 1, 'About', 'about', 'about.swf', '', 1, 0, 'Module Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.user&action=details&mod_id={MODULE_ID}\r\nTexts|index.php?mod=oxymall&sub=oxymall.plugin.about.landing&module_id={MODULE_ID}', '', 0);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(2, 0, 0, 'Banner Rotator', 'banner', 'rotator.swf', 'a:3:{s:21:\\"set_description_width\\";s:3:\\"300\\";s:8:\\"set_stay\\";s:1:\\"3\\";s:14:\\"set_fbcomments\\";s:1:\\"0\\";}', 1, 0, 'Module Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.user&action=details&mod_id={MODULE_ID}\r\nItems|index.php?mod=oxymall&sub=oxymall.plugin.banner.landing&module_id={MODULE_ID}\r\nVideo Tutorial|index.php?mod=oxymall&sub=oxymall.plugin.modules.help&module_id={MODULE_ID}', '', 0);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(3, 0, 0, 'Clients', 'clients', 'clients.swf', 'a:3:{s:9:\\"set_items\\";s:2:\\"12\\";s:14:\\"set_fbcomments\\";s:1:\\"0\\";s:19:\\"set_categories_type\\";s:1:\\"3\\";}', 1, 0, 'Module Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.user&action=details&mod_id={MODULE_ID}\r\nCategories|index.php?mod=oxymall&sub=oxymall.plugin.clients.landing&module_id={MODULE_ID}\r\nImages|index.php?mod=oxymall&sub=oxymall.plugin.clients.images&module_id={MODULE_ID}\r\nVideo Tutorial|index.php?mod=oxymall&sub=oxymall.plugin.modules.help&module_id={MODULE_ID}', '', 0);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(4, 0, 0, 'Contact', 'contact', 'contact.swf', 'a:10:{s:14:\\"set_mail_admin\\";s:13:\\"contact_admin\\";s:15:\\"set_mail_client\\";s:14:\\"contact_client\\";s:17:\\"set_email_message\\";s:37:\\"Department: {DEPARTMENT}\r\n\r\n{MESSAGE}\\";s:27:\\"set_verificationcodecaption\\";s:17:\\"Verification Code\\";s:27:\\"set_verificationcoderefresh\\";s:6:\\"RELOAD\\";s:25:\\"set_verificationcodeerror\\";s:25:\\"Invalid verification code\\";s:28:\\"set_contactsendbuttoncaption\\";s:12:\\"SEND MESSAGE\\";s:22:\\"set_resetbuttoncaption\\";s:10:\\"RESET FORM\\";s:22:\\"set_sendingmessagetext\\";s:29:\\"Sending email, please wait...\\";s:14:\\"set_succestext\\";s:11:\\"Thank you !\\";}', 1, 0, 'Module Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.user&action=details&mod_id={MODULE_ID}\r\nTexts|index.php?mod=oxymall&sub=oxymall.plugin.contact.texts&module_id={MODULE_ID}\r\nLinks|index.php?mod=oxymall&sub=oxymall.plugin.contact.links&module_id={MODULE_ID}\r\nFields|index.php?mod=oxymall&sub=oxymall.plugin.contact.fields&module_id={MODULE_ID}\r\nReceived Messages|index.php?mod=oxymall&sub=oxymall.plugin.contact.landing&module_id={MODULE_ID}\r\nVideo Tutorial|index.php?mod=oxymall&sub=oxymall.plugin.modules.help&module_id={MODULE_ID}', '', 0);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(5, 0, 1, 'Gallery', 'gallery', 'gallery.swf', 'a:4:{s:9:\\"set_items\\";s:2:\\"12\\";s:16:\\"set_items_column\\";s:1:\\"4\\";s:14:\\"set_fbcomments\\";s:1:\\"1\\";s:19:\\"set_categories_type\\";s:1:\\"3\\";}', 1, 0, 'Module Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.user&action=details&mod_id={MODULE_ID}\r\nAlbums|index.php?mod=oxymall&sub=oxymall.plugin.gallery.landing&module_id={MODULE_ID}\r\nImages|index.php?mod=oxymall&sub=oxymall.plugin.gallery.images&module_id={MODULE_ID}\r\nVideo Tutorial|index.php?mod=oxymall&sub=oxymall.plugin.modules.help&module_id={MODULE_ID}', '', 0);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(6, 0, 0, 'Jobs', 'jobs', 'careers.swf', 'a:24:{s:9:\\"set_items\\";s:1:\\"5\\";s:15:\\"set_date_format\\";s:11:\\"m d Y g:i a\\";s:23:\\"set_date_format_details\\";s:7:\\"jS  F Y\\";s:14:\\"set_fbcomments\\";s:1:\\"0\\";s:19:\\"set_categories_type\\";s:1:\\"3\\";s:23:\\"set_text_details_button\\";s:12:\\"Read Details\\";s:22:\\"set_text_resume_button\\";s:17:\\"Apply to this job\\";s:14:\\"set_text_apply\\";s:18:\\"Apply for this Job\\";s:18:\\"set_text_list_date\\";s:10:\\"Posted on:\\";s:18:\\"set_text_list_back\\";s:15:\\"Back to listing\\";s:21:\\"set_text_details_back\\";s:4:\\"BACK\\";s:21:\\"set_text_details_next\\";s:4:\\"NEXT\\";s:21:\\"set_text_upload_field\\";s:13:\\"Upload Resume\\";s:15:\\"set_text_upload\\";s:6:\\"Upload\\";s:20:\\"set_text_send_button\\";s:9:\\"APPLY NOW\\";s:13:\\"set_text_send\\";s:11:\\"Please wait\\";s:16:\\"set_text_success\\";s:24:\\"Your resume was received\\";s:16:\\"set_post_comment\\";s:1035:\\"Fusce accumsan elementum massa ac tincidunt. Pellentesque faucibus dolor eget est vestibulum eget varius purus faucibus. Aliquam bibendum tortor nec lacus dictum ultricies. Quisque non faucibus justo. Sed commodo faucibus tortor at luctus. Ut ipsum sem, euismod a tristique at, suscipit non quam. In faucibus odio nec eros rhoncus blandit.\r\n\r\nMorbi nec mi turpis. Fusce in turpis sem, at ultricies urna. Nulla nec imperdiet enim. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. In lobortis, mauris id ultrices blandit, erat neque faucibus tellus, vitae venenatis elit neque in odio. Curabitur vehicula aliquam diam ac sodales. \r\n\r\n    Lorem ipsum dolor sit amet, consectetur adipiscing elit.\r\n    Sed vel diam ac velit adipiscing placerat suscipit eu dui.\r\n    Phasellus ut nibh id mauris dignissim dictum et ut urna.\r\n    Praesent ac metus risus, et semper mauris.\r\n    Vivamus luctus risus quis nisl sagittis eget suscipit turpis luctus.\r\n    Nullam suscipit turpis eget orci tincidunt tempor.\r\n\\";s:14:\\"set_mail_admin\\";s:20:\\"careers_resume_admin\\";s:15:\\"set_mail_client\\";s:21:\\"careers_resume_client\\";s:17:\\"set_email_message\\";s:60:\\"Name: {FIRST_NAME} {LAST_NAME}\r\n\r\nPhone: {PHONE}\r\n\r\n{RESUME}\\";s:27:\\"set_verificationcodecaption\\";s:18:\\"Verification Image\\";s:27:\\"set_verificationcoderefresh\\";s:7:\\"Refresh\\";s:25:\\"set_verificationcodeerror\\";s:27:\\"Invalid verification code !\\";}', 1, 0, 'Module Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.user&action=details&mod_id={MODULE_ID}\r\nFields|index.php?mod=oxymall&sub=oxymall.plugin.jobs.fields&module_id={MODULE_ID}\r\nJobs|index.php?mod=oxymall&sub=oxymall.plugin.jobs.landing&module_id={MODULE_ID}\r\nCategories|index.php?mod=oxymall&sub=oxymall.plugin.jobs.cats&module_id={MODULE_ID}\r\nResumes|index.php?mod=oxymall&sub=oxymall.plugin.jobs.resumes&module_id={MODULE_ID}\r\nVideo Tutorial|index.php?mod=oxymall&sub=oxymall.plugin.modules.help&module_id={MODULE_ID}', '', 0);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(7, 0, 1, 'News', 'news', 'news.swf', 'a:8:{s:9:\\"set_items\\";s:1:\\"5\\";s:15:\\"set_date_format\\";s:13:\\"jS \\\\\\\\o\\\\\\\\f F Y\\";s:23:\\"set_date_format_details\\";s:13:\\"jS \\\\\\\\o\\\\\\\\f F Y\\";s:14:\\"set_fbcomments\\";s:1:\\"1\\";s:18:\\"set_text_list_date\\";s:10:\\"Posted on:\\";s:18:\\"set_text_list_back\\";s:15:\\"Back to listing\\";s:21:\\"set_text_details_back\\";s:4:\\"BACK\\";s:21:\\"set_text_details_next\\";s:4:\\"NEXT\\";}', 1, 0, 'Module Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.user&action=details&mod_id={MODULE_ID}\r\nNews Items|index.php?mod=oxymall&sub=oxymall.plugin.news.landing&module_id={MODULE_ID}&action=details\r\nVideo Tutorial|index.php?mod=oxymall&sub=oxymall.plugin.modules.help&module_id={MODULE_ID}', '', 0);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(8, 0, 0, 'Portfolio', 'portfolio', 'portfolio.swf', 'a:6:{s:9:\\"set_items\\";s:1:\\"9\\";s:14:\\"set_fbcomments\\";s:1:\\"0\\";s:16:\\"set_items_column\\";s:1:\\"3\\";s:19:\\"set_categories_type\\";s:1:\\"3\\";s:18:\\"set_text_list_back\\";s:16:\\"Back to category\\";s:13:\\"set_text_link\\";s:23:\\"Visit project\\\\\\\\\\\\\\''s site\\";}', 1, 0, 'Module Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.user&action=details&mod_id={MODULE_ID}\r\nHeader|index.php?mod=oxymall&sub=oxymall.plugin.portfolio.landing&module_id={MODULE_ID}&action=details\r\nCategories|index.php?mod=oxymall&sub=oxymall.plugin.portfolio.cats&module_id={MODULE_ID}\r\nProjects|index.php?mod=oxymall&sub=oxymall.plugin.portfolio.projects&module_id={MODULE_ID}\r\nVideo Tutorial|index.php?mod=oxymall&sub=oxymall.plugin.modules.help&module_id={MODULE_ID}', '', 0);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(9, 0, 0, 'Services', 'services', 'services.swf', 'a:3:{s:9:\\"set_items\\";s:1:\\"8\\";s:14:\\"set_fbcomments\\";s:1:\\"0\\";s:19:\\"set_categories_type\\";s:1:\\"3\\";}', 1, 0, 'Module Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.user&action=details&mod_id={MODULE_ID}\r\nCategories|index.php?mod=oxymall&sub=oxymall.plugin.services.landing&module_id={MODULE_ID}\r\nImages|index.php?mod=oxymall&sub=oxymall.plugin.services.images&module_id={MODULE_ID}\r\nVideo Tutorial|index.php?mod=oxymall&sub=oxymall.plugin.modules.help&module_id={MODULE_ID}', '', 0);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(10, 0, 1, 'Homepage', 'homepage', 'homepage.swf', 'a:1:{s:14:\\"set_fbcomments\\";s:1:\\"0\\";}', 1, 0, 'Module Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.user&action=details&mod_id={MODULE_ID}\r\nHeader|index.php?mod=oxymall&sub=oxymall.plugin.homepage.landing&module_id={MODULE_ID}&action=details\r\nImages|index.php?mod=oxymall&sub=oxymall.plugin.homepage.images&module_id={MODULE_ID}\r\nVideo Tutorial|index.php?mod=oxymall&sub=oxymall.plugin.modules.help&module_id={MODULE_ID}', '', 0);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(11, 0, 0, 'Users Comments', 'comments', '', 'a:24:{s:9:\\"set_title\\";s:33:\\"{COMMENTS} comments on this topic\\";s:11:\\"set_titleno\\";s:39:\\"No comments, be the first one to post !\\";s:9:\\"set_items\\";s:2:\\"20\\";s:12:\\"set_items_fb\\";s:2:\\"20\\";s:11:\\"set_display\\";s:1:\\"0\\";s:24:\\"set_comments_date_format\\";s:12:\\"j F Y, g:i a\\";s:17:\\"set_comments_said\\";s:7:\\"said : \\";s:14:\\"set_post_title\\";s:13:\\"Leave a Reply\\";s:13:\\"set_post_name\\";s:11:\\"Your Name :\\";s:14:\\"set_post_email\\";s:13:\\"Your E-mail :\\";s:16:\\"set_post_website\\";s:27:\\"Your Website ( optional ) :\\";s:16:\\"set_post_message\\";s:14:\\"Your Message :\\";s:20:\\"set_post_button_post\\";s:12:\\"POST COMMENT\\";s:22:\\"set_post_alert_sending\\";s:16:\\"Please wait ....\\";s:20:\\"set_post_alert_email\\";s:36:\\"Please enter a valid email address !\\";s:19:\\"set_post_alert_name\\";s:24:\\"Please enter your name !\\";s:22:\\"set_post_alert_message\\";s:27:\\"Please enter your message !\\";s:22:\\"set_post_alert_success\\";s:37:\\"Your message was successfuly posted !\\";s:16:\\"set_post_comment\\";s:278:\\"Some extra info here\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\r\n\\";s:15:\\"set_post_capcha\\";s:1:\\"1\\";s:21:\\"set_post_capcha_title\\";s:19:\\"Verification Image:\\";s:23:\\"set_post_capcha_refresh\\";s:7:\\"Refresh\\";s:21:\\"set_post_alert_capcha\\";s:45:\\"The code you entered doesnt match the image !\\";s:14:\\"set_mail_admin\\";s:13:\\"comment_admin\\";}', 0, 1, 'Module Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.default&action=details&module_id={MODULE_ID}\r\nComments|index.php?mod=oxymall&sub=oxymall.plugin.comments.landing', '', 0);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(12, 0, 0, 'External Link', 'external-link', 'external-link', NULL, 1, 0, 'Module Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.user&action=details&mod_id={MODULE_ID}\r\n', NULL, 1);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(103, 0, 1, 'Category', 'category', '', '', 1, 0, '', '', 1);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(13, 0, 0, 'Backgrounds', 'background', '', 'a:7:{s:17:\\"set_animationtime\\";s:3:\\"1.5\\";s:17:\\"set_animationtype\\";s:6:\\"linear\\";s:10:\\"set_random\\";s:1:\\"1\\";s:14:\\"set_resizemode\\";s:1:\\"0\\";s:24:\\"set_imagefinalalphavalue\\";s:3:\\"100\\";s:21:\\"set_activateslideshow\\";s:1:\\"1\\";s:18:\\"set_slideshowtimer\\";s:2:\\"10\\";}', 0, 1, 'Module Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.default&action=details&module_id={MODULE_ID}\r\nGlobal Backgrounds|index.php?mod=oxymall&sub=oxymall.plugin.background.landing&module_id={MODULE_ID}\r\nModule Backgrounds|index.php?mod=oxymall&sub=oxymall.plugin.background.modules&module_id={MODULE_ID}', '', 0);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(16, 0, 0, 'Shopping Cart', 'shop', 'cart.swf', 'a:155:{s:13:\\"set_seo_title\\";s:13:\\"Shopping Cart\\";s:12:\\"set_seo_desc\\";s:0:\\"\\";s:12:\\"set_seo_keys\\";s:0:\\"\\";s:9:\\"set_title\\";s:12:\\"Cart Content\\";s:15:\\"set_title_items\\";s:5:\\"items\\";s:16:\\"set_pricecaption\\";s:7:\\"Price :\\";s:20:\\"set_addtocartcaption\\";s:11:\\"ADD TO CART\\";s:16:\\"set_itemscaption\\";s:5:\\"items\\";s:22:\\"set_productnamecaption\\";s:12:\\"PRODUCT NAME\\";s:24:\\"set_onlycartpricecaption\\";s:5:\\"PRICE\\";s:19:\\"set_quantitycaption\\";s:8:\\"QUANTITY\\";s:16:\\"set_totalcaption\\";s:5:\\"TOTAL\\";s:27:\\"set_continueshoppingcaption\\";s:17:\\"CONTINUE SHOPPING\\";s:19:\\"set_checkoutcaption\\";s:19:\\"PROCEED TO CHECKOUT\\";s:21:\\"set_grandtotalcaption\\";s:13:\\"GRAND TOTAL :\\";s:21:\\"set_removeitemtooltip\\";s:11:\\"Remove Item\\";s:17:\\"set_actioncaption\\";s:6:\\"Action\\";s:16:\\"set_quantityplus\\";s:13:\\"Quantity Plus\\";s:17:\\"set_quantityminus\\";s:14:\\"Quantity Minus\\";s:14:\\"set_removeitem\\";s:11:\\"Remove Item\\";s:20:\\"set_opentooltipalert\\";s:13:\\"Shopping Cart\\";s:21:\\"set_closetooltipalert\\";s:19:\\"Close Shopping Cart\\";s:34:\\"set_addedtocartnotificationcaption\\";s:23:\\"New Item Added to Cart:\\";s:11:\\"set_month_1\\";s:7:\\"January\\";s:11:\\"set_month_2\\";s:8:\\"February\\";s:11:\\"set_month_3\\";s:5:\\"March\\";s:11:\\"set_month_4\\";s:5:\\"April\\";s:11:\\"set_month_5\\";s:3:\\"May\\";s:11:\\"set_month_6\\";s:4:\\"June\\";s:11:\\"set_month_7\\";s:4:\\"July\\";s:11:\\"set_month_8\\";s:6:\\"August\\";s:11:\\"set_month_9\\";s:9:\\"September\\";s:12:\\"set_month_10\\";s:7:\\"October\\";s:12:\\"set_month_11\\";s:8:\\"November\\";s:12:\\"set_month_12\\";s:8:\\"December\\";s:24:\\"set_account_shop_billing\\";s:12:\\"Billing Info\\";s:25:\\"set_account_shop_shipping\\";s:13:\\"Shipping Info\\";s:27:\\"set_account_shop_first_name\\";s:11:\\"First Name:\\";s:26:\\"set_account_shop_last_name\\";s:10:\\"Last Name:\\";s:24:\\"set_account_shop_address\\";s:8:\\"Address:\\";s:25:\\"set_account_shop_address2\\";s:0:\\"\\";s:21:\\"set_account_shop_city\\";s:5:\\"City:\\";s:22:\\"set_account_shop_state\\";s:7:\\"State: \\";s:20:\\"set_account_shop_zip\\";s:4:\\"Zip:\\";s:24:\\"set_account_shop_country\\";s:8:\\"Country:\\";s:22:\\"set_account_shop_phone\\";s:6:\\"Phone:\\";s:21:\\"set_account_shop_same\\";s:15:\\"same as billing\\";s:25:\\"set_account_shop_button_1\\";s:4:\\"Save\\";s:25:\\"set_account_shop_button_2\\";s:6:\\"Cancel\\";s:23:\\"set_account_shop_saving\\";s:14:\\"Please wait...\\";s:22:\\"set_account_shop_saved\\";s:17:\\"Profile updated !\\";s:15:\\"set_steps_title\\";s:4:\\"Shop\\";s:18:\\"set_steps_subtitle\\";s:13:\\"Cart Contents\\";s:15:\\"set_steps_items\\";s:15:\\"item(s) in cart\\";s:18:\\"set_steps_subtotal\\";s:11:\\"Subtotal : \\";s:17:\\"set_steps_1_title\\";s:5:\\"Order\\";s:20:\\"set_steps_1_subtitle\\";s:13:\\"Shopping Cart\\";s:17:\\"set_steps_2_title\\";s:6:\\"Step 1\\";s:20:\\"set_steps_2_subtitle\\";s:20:\\"Billing and Shipping\\";s:20:\\"set_steps_2_title_ns\\";s:6:\\"Step 1\\";s:23:\\"set_steps_2_subtitle_ns\\";s:7:\\"Billing\\";s:17:\\"set_steps_3_title\\";s:6:\\"Step 2\\";s:20:\\"set_steps_3_subtitle\\";s:22:\\"Select Shipping Method\\";s:17:\\"set_steps_4_title\\";s:6:\\"Step 3\\";s:20:\\"set_steps_4_subtitle\\";s:17:\\"Review Your Order\\";s:20:\\"set_steps_4_title_ns\\";s:6:\\"Step 2\\";s:23:\\"set_steps_4_subtitle_ns\\";s:17:\\"Review Your Order\\";s:17:\\"set_steps_5_title\\";s:6:\\"Step 4\\";s:20:\\"set_steps_5_subtitle\\";s:16:\\"Make the Payment\\";s:20:\\"set_steps_5_title_ns\\";s:6:\\"Step 3\\";s:23:\\"set_steps_5_subtitle_ns\\";s:16:\\"Make the Payment\\";s:17:\\"set_step1_billing\\";s:12:\\"Billing Info\\";s:18:\\"set_step1_shipping\\";s:13:\\"Shipping Info\\";s:20:\\"set_step1_first_name\\";s:13:\\"First Name : \\";s:19:\\"set_step1_last_name\\";s:11:\\"Last Name :\\";s:17:\\"set_step1_address\\";s:9:\\"Address :\\";s:18:\\"set_step1_address2\\";s:0:\\"\\";s:14:\\"set_step1_city\\";s:6:\\"City :\\";s:15:\\"set_step1_state\\";s:8:\\"State : \\";s:13:\\"set_step1_zip\\";s:10:\\"Zip Code :\\";s:17:\\"set_step1_country\\";s:10:\\"Country : \\";s:15:\\"set_step1_phone\\";s:7:\\"Phone :\\";s:15:\\"set_step1_email\\";s:8:\\"E-Mail :\\";s:14:\\"set_step1_same\\";s:16:\\"Same as billing \\";s:18:\\"set_step1_button_1\\";s:16:\\"View/Manage Cart\\";s:18:\\"set_step1_button_2\\";s:21:\\"NEXT: SHIPPING METHOD\\";s:20:\\"set_step1_button_2_2\\";s:18:\\"NEXT: REVIEW ORDER\\";s:16:\\"set_step1_saving\\";s:17:\\"Sending data ....\\";s:17:\\"set_step1_success\\";s:28:\\"Redirecting to next step ...\\";s:15:\\"set_step1_error\\";s:27:\\"Please fill in all fields !\\";s:15:\\"set_step2_title\\";s:22:\\"Select Shipping Method\\";s:17:\\"set_step2_service\\";s:7:\\"Service\\";s:18:\\"set_step2_duration\\";s:8:\\"Duration\\";s:15:\\"set_step2_price\\";s:5:\\"Price\\";s:20:\\"set_step2_price_free\\";s:37:\\"<font color=\\\\\\\\\\\\\\''green\\\\\\\\\\\\\\''>FREE</font>\\";s:18:\\"set_step2_button_1\\";s:26:\\"Back: Billing and Shipping\\";s:18:\\"set_step2_button_2\\";s:18:\\"NEXT: REVIEW ORDER\\";s:16:\\"set_step2_saving\\";s:16:\\"Sending data ...\\";s:17:\\"set_step2_success\\";s:28:\\"Redirecting to next step ...\\";s:15:\\"set_step2_error\\";s:36:\\"Please select your desired carried !\\";s:15:\\"set_step3_title\\";s:12:\\"Review Order\\";s:18:\\"set_step3_button_1\\";s:28:\\"Back: Select Shipping Method\\";s:20:\\"set_step3_button_1_2\\";s:18:\\"Back: Billing Info\\";s:18:\\"set_step3_button_2\\";s:13:\\"NEXT: PAYMENT\\";s:18:\\"set_step3_shipping\\";s:8:\\"Shipping\\";s:13:\\"set_step3_tax\\";s:3:\\"Tax\\";s:18:\\"set_step3_tax_free\\";s:37:\\"<font color=\\\\\\\\\\\\\\''green\\\\\\\\\\\\\\''>FREE</font>\\";s:23:\\"set_step3_shipping_free\\";s:37:\\"<font color=\\\\\\\\\\\\\\''green\\\\\\\\\\\\\\''>FREE</font>\\";s:15:\\"set_step4_title\\";s:12:\\"Make Payment\\";s:16:\\"set_step4_header\\";s:14:\\"some text here\\";s:16:\\"set_step4_button\\";s:18:\\"Back: Review Order\\";s:21:\\"set_nameoncardcaption\\";s:14:\\"Name on Card :\\";s:25:\\"set_nameoncarddescription\\";s:70:\\"Please enter the name exactly<br>as it is written on your credit card.\\";s:19:\\"set_cardtypecaption\\";s:11:\\"Card Type :\\";s:23:\\"set_cardtypedescription\\";s:28:\\"Please select your card type\\";s:21:\\"set_cardnumbercaption\\";s:13:\\"Card Number :\\";s:25:\\"set_cardnumberdescription\\";s:53:\\"You can find this number<br>on the front of your card\\";s:21:\\"set_expirydatecaption\\";s:11:\\"Expiry Date\\";s:25:\\"set_expirydatedescription\\";s:45:\\"Please enter the <br>expiry date of your card\\";s:15:\\"set_cvv2caption\\";s:4:\\"CVV2\\";s:19:\\"set_cvv2description\\";s:95:\\"The CVV2 is a three or four digit number<br>found on the front or the back of your credit card.\\";s:17:\\"set_step4_sending\\";s:14:\\"Please wait...\\";s:15:\\"set_step4_error\\";s:27:\\"Please fill in all fields !\\";s:16:\\"set_history_code\\";s:4:\\"Code\\";s:17:\\"set_history_total\\";s:5:\\"Total\\";s:16:\\"set_history_date\\";s:4:\\"Date\\";s:18:\\"set_history_status\\";s:6:\\"Status\\";s:19:\\"set_history_payment\\";s:6:\\"Method\\";s:23:\\"set_history_date_format\\";s:5:\\"d/m/Y\\";s:20:\\"set_history_status_1\\";s:7:\\"Pending\\";s:20:\\"set_history_status_2\\";s:9:\\"Completed\\";s:20:\\"set_history_status_3\\";s:8:\\"Refunded\\";s:20:\\"set_history_status_4\\";s:8:\\"Canceled\\";s:20:\\"set_history_status_5\\";s:7:\\"Shipped\\";s:16:\\"set_history_back\\";s:17:\\"Back to My Orders\\";s:25:\\"set_history_details_title\\";s:5:\\"Order\\";s:29:\\"set_history_details_carttitle\\";s:12:\\"Cart Content\\";s:28:\\"set_account_youraccounttitle\\";s:12:\\"Your Account\\";s:20:\\"set_account_myorders\\";s:9:\\"My Orders\\";s:25:\\"set_account_history_title\\";s:7:\\"History\\";s:28:\\"set_account_history_subtitle\\";s:15:\\"Purchased Items\\";s:25:\\"set_account_profile_title\\";s:12:\\"Shop Profile\\";s:28:\\"set_account_profile_subtitle\\";s:20:\\"Billing and Shipping\\";s:26:\\"set_account_download_title\\";s:8:\\"Download\\";s:29:\\"set_account_download_subtitle\\";s:19:\\"Files you purchased\\";s:21:\\"set_account_orders_pp\\";s:1:\\"3\\";s:20:\\"set_account_download\\";s:1:\\"1\\";s:18:\\"set_download_title\\";s:12:\\"My Downloads\\";s:20:\\"set_download_product\\";s:7:\\"Product\\";s:17:\\"set_download_file\\";s:4:\\"File\\";s:17:\\"set_download_date\\";s:11:\\"Last Update\\";s:19:\\"set_download_button\\";s:8:\\"DOWNLOAD\\";s:15:\\"set_download_pp\\";s:1:\\"6\\";s:23:\\"set_download_date_order\\";s:5:\\"m/d/Y\\";s:22:\\"set_download_date_file\\";s:5:\\"m/d/Y\\";}', 0, 1, 'Global Settings|index.php?mod=oxymall&sub=oxymall.plugin.shop.global&action=details\r\nModule Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.default&module_id=16&action=details\r\nOrders Management|index.php?mod=oxymall&sub=oxymall.plugin.shop.orders', '', 0);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(14, 0, 0, 'Blog', 'blog', 'blog.swf', 'a:22:{s:19:\\"set_categories_type\\";s:1:\\"3\\";s:9:\\"set_items\\";s:2:\\"10\\";s:15:\\"set_date_format\\";s:13:\\"jS \\\\\\\\o\\\\\\\\f F Y\\";s:23:\\"set_date_format_details\\";s:13:\\"jS \\\\\\\\o\\\\\\\\f F Y\\";s:13:\\"set_label_url\\";s:3:\\"all\\";s:15:\\"set_label_title\\";s:9:\\"All Posts\\";s:14:\\"set_fbcomments\\";s:1:\\"1\\";s:18:\\"set_text_list_date\\";s:10:\\"Posted on:\\";s:18:\\"set_text_list_back\\";s:15:\\"Back to listing\\";s:21:\\"set_text_details_back\\";s:4:\\"BACK\\";s:21:\\"set_text_details_next\\";s:4:\\"NEXT\\";s:18:\\"set_text_posted_by\\";s:10:\\"Posted by \\";s:18:\\"set_text_posted_on\\";s:3:\\"on \\";s:18:\\"set_publisher_back\\";s:14:\\"Back to topics\\";s:15:\\"set_filter_sort\\";s:8:\\"Sort by:\\";s:16:\\"set_filter_order\\";s:6:\\"Order:\\";s:15:\\"set_filter_name\\";s:4:\\"Name\\";s:15:\\"set_filter_date\\";s:4:\\"Date\\";s:17:\\"set_filter_author\\";s:6:\\"Author\\";s:14:\\"set_filter_asc\\";s:9:\\"Ascending\\";s:15:\\"set_filter_desc\\";s:10:\\"Descending\\";s:17:\\"set_filter_search\\";s:10:\\"Search ...\\";}', 1, 0, 'Module Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.user&action=details&mod_id={MODULE_ID}\r\nAuthors|index.php?mod=oxymall&sub=oxymall.plugin.blog.authors&module_id={MODULE_ID}\r\nTopics|index.php?mod=oxymall&sub=oxymall.plugin.blog.landing&module_id={MODULE_ID}\r\nCategories|index.php?mod=oxymall&sub=oxymall.plugin.blog.cats&module_id={MODULE_ID}\r\nComments|index.php?mod=oxymall&sub=oxymall.plugin.blog.comments&module_id={MODULE_ID}&action=details', '', 0);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(15, 0, 0, 'Products Catalog', 'products', 'shop.swf', 'a:59:{s:7:\\"set_ipp\\";s:2:\\"12\\";s:16:\\"set_items_column\\";s:9:\\"four-cols\\";s:14:\\"set_fbcomments\\";s:1:\\"0\\";s:19:\\"set_categories_type\\";s:1:\\"2\\";s:11:\\"set_reviews\\";s:1:\\"1\\";s:15:\\"set_askquestion\\";s:1:\\"1\\";s:18:\\"set_mail_ask_admin\\";s:27:\\"products_ask_question_admin\\";s:19:\\"set_mail_ask_client\\";s:28:\\"products_ask_question_client\\";s:21:\\"set_mail_review_admin\\";s:25:\\"products_new_review_admin\\";s:22:\\"set_mail_review_client\\";s:26:\\"products_new_review_client\\";s:15:\\"set_filter_name\\";s:4:\\"Name\\";s:16:\\"set_filter_price\\";s:5:\\"Price\\";s:15:\\"set_filter_date\\";s:4:\\"Date\\";s:16:\\"set_filter_sales\\";s:5:\\"Sales\\";s:14:\\"set_filter_asc\\";s:9:\\"Ascending\\";s:15:\\"set_filter_desc\\";s:10:\\"Descending\\";s:17:\\"set_filter_search\\";s:10:\\"Search ...\\";s:20:\\"set_filter_text_sort\\";s:10:\\"Sort by : \\";s:21:\\"set_filter_text_order\\";s:7:\\"Order :\\";s:13:\\"set_ask_title\\";s:14:\\"Ask a Question\\";s:12:\\"set_ask_name\\";s:15:\\"Your Full Name:\\";s:13:\\"set_ask_phone\\";s:12:\\"Your Phone: \\";s:13:\\"set_ask_email\\";s:12:\\"Your E-Mail:\\";s:15:\\"set_ask_subject\\";s:8:\\"Subject:\\";s:15:\\"set_ask_message\\";s:8:\\"Message:\\";s:16:\\"set_ask_button_1\\";s:13:\\"SEND QUESTION\\";s:16:\\"set_ask_button_2\\";s:5:\\"RESET\\";s:15:\\"set_ask_sending\\";s:14:\\"Please wait...\\";s:17:\\"set_ask_namealert\\";s:24:\\"Please enter your name !\\";s:18:\\"set_ask_phonealert\\";s:32:\\"Please enter your phone number !\\";s:18:\\"set_ask_emailalert\\";s:34:\\"Please enter your e-mail address !\\";s:20:\\"set_ask_subjectalert\\";s:24:\\"Please enter a subject !\\";s:20:\\"set_ask_messagealert\\";s:28:\\"Please enter your question !\\";s:15:\\"set_ask_success\\";s:23:\\"Your message was sent !\\";s:17:\\"set_reviews_title\\";s:7:\\"Reviews\\";s:22:\\"set_reviews_title_post\\";s:17:\\"Post new review :\\";s:16:\\"set_reviews_name\\";s:16:\\"Your full name :\\";s:17:\\"set_reviews_email\\";s:20:\\"Your email address: \\";s:19:\\"set_reviews_message\\";s:13:\\"Your review :\\";s:20:\\"set_reviews_button_1\\";s:11:\\"SEND REVIEW\\";s:20:\\"set_reviews_button_2\\";s:5:\\"RESET\\";s:19:\\"set_reviews_sending\\";s:15:\\"Please wait ...\\";s:21:\\"set_reviews_namealert\\";s:24:\\"Please enter your name !\\";s:22:\\"set_reviews_emailalert\\";s:34:\\"Please enter your e-mail address !\\";s:24:\\"set_reviews_messagealert\\";s:26:\\"Please enter your review !\\";s:19:\\"set_reviews_success\\";s:22:\\"Your review was sent !\\";s:21:\\"set_reviews_load_more\\";s:13:\\"Load More ...\\";s:21:\\"set_reviews_text_said\\";s:6:\\"said :\\";s:24:\\"set_date_format_comments\\";s:20:\\"\\\\\\\\o\\\\\\\\n jS \\\\\\\\o\\\\\\\\f F Y\\";s:16:\\"set_details_back\\";s:4:\\"Back\\";s:17:\\"set_details_price\\";s:6:\\"Price \\";s:23:\\"set_details_description\\";s:11:\\"Description\\";s:17:\\"set_details_specs\\";s:5:\\"Specs\\";s:20:\\"set_details_checkout\\";s:8:\\"Checkout\\";s:15:\\"set_details_add\\";s:11:\\"ADD TO CART\\";s:19:\\"set_prj_middle_text\\";s:26:\\"Product Multimedia Gallery\\";s:14:\\"set_list_price\\";s:8:\\"Price : \\";s:12:\\"set_list_add\\";s:11:\\"ADD TO CART\\";s:16:\\"set_list_details\\";s:7:\\"DETAILS\\";}', 1, 0, 'Module Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.user&action=details&mod_id={MODULE_ID}\r\nCategories|index.php?mod=oxymall&sub=oxymall.plugin.products.landing&module_id={MODULE_ID}\r\nProducts|index.php?mod=oxymall&sub=oxymall.plugin.products.products&module_id={MODULE_ID}\r\nReviews|index.php?mod=oxymall&sub=oxymall.plugin.products.allreviews&module_id={MODULE_ID}\r\nQuestions|index.php?mod=oxymall&sub=oxymall.plugin.products.questions&module_id={MODULE_ID}', '', 0);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(17, 0, 0, 'Social Bookmarking', 'sharing', '', 'a:2:{s:9:\\"set_title\\";s:16:\\"Bookmark & Share\\";s:9:\\"set_close\\";s:5:\\"Close\\";}', 0, 1, 'Module Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.default&action=details&module_id={MODULE_ID}\r\nLinks|index.php?mod=oxymall&sub=oxymall.plugin.sharing.landing&module_id={MODULE_ID}', '', 0);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(106, 0, 0, 'Countdown', 'countdown', 'countdown.swf', 'a:15:{s:14:\\"set_fbcomments\\";s:1:\\"0\\";s:14:\\"set_launchdate\\";i:1359504000;s:14:\\"set_counttitle\\";s:32:\\"Complete Template Launch Timer :\\";s:18:\\"set_topdescription\\";s:1427:\\"<p style=\\\\\\"text-align: justify;\\\\\\">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>\r\n<p style=\\\\\\"text-align: justify;\\\\\\">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>\r\n<p style=\\\\\\"text-align: justify;\\\\\\">Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>\\";s:17:\\"set_link_redirect\\";s:1:\\"/\\";s:14:\\"set_daycaption\\";s:4:\\"DAYS\\";s:15:\\"set_hourcaption\\";s:5:\\"HOURS\\";s:18:\\"set_minutescaption\\";s:7:\\"MINUTES\\";s:18:\\"set_secondscaption\\";s:7:\\"SECONDS\\";s:19:\\"set_launchdate_hour\\";s:2:\\"00\\";s:18:\\"set_launchdate_min\\";s:2:\\"00\\";s:18:\\"set_launchdate_sec\\";s:2:\\"00\\";s:20:\\"set_launchdate_month\\";s:2:\\"01\\";s:18:\\"set_launchdate_day\\";s:2:\\"30\\";s:19:\\"set_launchdate_year\\";s:4:\\"2013\\";}', 1, 0, 'Module Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.user&action=details&mod_id={MODULE_ID}', '', 0);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(108, 0, 0, 'Team Members', 'team', 'services.swf', 'a:6:{s:9:\\"set_items\\";s:1:\\"8\\";s:14:\\"set_fbcomments\\";s:1:\\"0\\";s:19:\\"set_categories_type\\";s:1:\\"3\\";s:14:\\"set_text_email\\";s:7:\\"E-Mail:\\";s:14:\\"set_text_phone\\";s:7:\\"Phone: \\";s:13:\\"set_text_back\\";s:4:\\"Back\\";}', 1, 0, 'Module Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.user&action=details&mod_id={MODULE_ID}\r\nCategories|index.php?mod=oxymall&sub=oxymall.plugin.services.landing&module_id={MODULE_ID}\r\nMembers|index.php?mod=oxymall&sub=oxymall.plugin.services.images&module_id={MODULE_ID}\r\nVideo Tutorial|index.php?mod=oxymall&sub=oxymall.plugin.modules.help&module_id={MODULE_ID}', '', 0);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(109, 0, 0, 'Newsletters', 'newsletters', '', 'a:23:{s:9:\\"set_title\\";s:14:\\"Our Newsletter\\";s:12:\\"set_subtitle\\";s:136:\\"Stay up to date with news, events and important special offers through our monthly newsletter. You can unsubscribe at any time you want.\\";s:10:\\"set_script\\";s:34:\\"../../../newsletters-subscribe.php\\";s:14:\\"set_totalwidth\\";s:3:\\"443\\";s:20:\\"set_opentooltipalert\\";s:27:\\"Subscribe to our Newsletter\\";s:21:\\"set_closetooltipalert\\";s:10:\\"Close this\\";s:22:\\"set_contactnamecaption\\";s:10:\\"Your Name:\\";s:23:\\"set_contactemailcaption\\";s:20:\\"Your E-Mail Address:\\";s:20:\\"set_subscribecaption\\";s:9:\\"Subscribe\\";s:22:\\"set_unsubscribecaption\\";s:11:\\"Unsubscribe\\";s:21:\\"set_sendbuttoncaption\\";s:11:\\"SUBMIT FORM\\";s:17:\\"set_wrongnametext\\";s:20:\\"Name is mandatory...\\";s:18:\\"set_wrongemailtext\\";s:38:\\"Please enter a valid email address ...\\";s:22:\\"set_sendingmessagetext\\";s:31:\\"Sending request, please wait...\\";s:19:\\"set_successubscribe\\";s:53:\\"Thank you, you are now subscribed to our newsletter !\\";s:21:\\"set_succesunsubscribe\\";s:57:\\"Thank you, you are now unsubscribed from our newsletter !\\";s:12:\\"set_failtext\\";s:46:\\"We could not subscribe you to our newsletter !\\";s:26:\\"set_alreadysubscribedalert\\";s:44:\\"You are already subscribed to our newsletter\\";s:28:\\"set_alreadyunsubscribedalert\\";s:42:\\"Your email doesnt exists in our database !\\";s:21:\\"set_showanimationtime\\";s:3:\\"0.5\\";s:21:\\"set_showanimationtype\\";s:12:\\"easeoutquart\\";s:21:\\"set_hideanimationtime\\";s:3:\\"0.5\\";s:21:\\"set_hideanimationtype\\";s:12:\\"easeoutquart\\";}', 0, 1, 'Global Settings|index.php?mod=oxymall&sub=oxymall.plugin.shop.global&action=details\r\nModule Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.default&module_id=16&action=details\r\nOrders Management|index.php?mod=oxymall&sub=oxymall.plugin.shop.orders', '', 0);
INSERT INTO `site_oxymall_core_modules` (`module_id`, `module_seo`, `module_mobile`, `module_name`, `module_code`, `module_file`, `module_settings`, `module_unique`, `module_unique_enabled`, `module_links`, `module_help`, `module_system`) VALUES(110, 0, 0, 'Users Accounts', 'users', '', 'a:98:{s:17:\\"set_register_type\\";s:1:\\"2\\";s:18:\\"set_facebook_scope\\";s:20:\\"email,publish_stream\\";s:17:\\"set_page_facebook\\";s:2:\\"55\\";s:26:\\"set_default_group_facebook\\";s:1:\\"3\\";s:25:\\"set_facebook_login_button\\";s:21:\\"Connect with Facebook\\";s:17:\\"set_summary_login\\";s:7:\\"Sign In\\";s:20:\\"set_summary_register\\";s:8:\\"Register\\";s:17:\\"set_summary_guest\\";s:8:\\"Hi Guest\\";s:19:\\"set_summary_welcome\\";s:7:\\"Welcome\\";s:19:\\"set_summary_account\\";s:10:\\"My Account\\";s:18:\\"set_summary_logout\\";s:6:\\"Logout\\";s:17:\\"set_default_group\\";s:1:\\"1\\";s:18:\\"set_default_status\\";s:1:\\"1\\";s:26:\\"set_default_confirm_status\\";s:1:\\"2\\";s:9:\\"set_login\\";a:1:{i:0;s:1:\\"2\\";}s:18:\\"set_page_confirmed\\";s:2:\\"25\\";s:26:\\"set_page_confirmed_invalid\\";s:2:\\"26\\";s:16:\\"set_page_recover\\";s:2:\\"27\\";s:24:\\"set_page_recover_invalid\\";s:2:\\"28\\";s:14:\\"set_mail_admin\\";s:20:\\"account_notify_admin\\";s:16:\\"set_mail_welcome\\";s:15:\\"account_welcome\\";s:25:\\"set_mail_welcome_facebook\\";s:15:\\"account_welcome\\";s:16:\\"set_mail_confirm\\";s:15:\\"account_confirm\\";s:16:\\"set_mail_pending\\";s:26:\\"account_pending_activation\\";s:20:\\"set_mail_forgot_link\\";s:28:\\"account_forgot_password_link\\";s:19:\\"set_mail_forgot_new\\";s:27:\\"account_forgot_password_new\\";s:18:\\"set_mail_suspended\\";s:17:\\"account_suspended\\";s:28:\\"set_login_loginbuttoncaption\\";s:7:\\"LOG IN \\";s:31:\\"set_login_registerbuttoncaption\\";s:8:\\"REGISTER\\";s:33:\\"set_login_forgotpassbuttoncaption\\";s:17:\\"FORGOT PASSWORD ?\\";s:16:\\"set_login_cookie\\";s:3:\\"300\\";s:18:\\"set_login_toptitle\\";s:13:\\"Please Log in\\";s:20:\\"set_login_descripton\\";s:155:\\"This is a protected area, please log in using the credentials you have been provided. If allowed, public registration with admin approval will be available\\";s:26:\\"set_login_useremailcaption\\";s:12:\\"Your E-Mail:\\";s:25:\\"set_login_passwordcaption\\";s:15:\\"Your Password :\\";s:24:\\"set_login_wronginfoalert\\";s:25:\\"Login failed, wrong info!\\";s:27:\\"set_login_correctloginalert\\";s:24:\\"Login success ! wait... \\";s:28:\\"set_login_usersuspendedalert\\";s:18:\\"Account suspended!\\";s:31:\\"set_login_usernotconfirmedalert\\";s:29:\\"Please confirm your account !\\";s:24:\\"set_login_useremailalert\\";s:21:\\"Please enter email...\\";s:23:\\"set_login_passwordalert\\";s:25:\\"Please enter password... \\";s:24:\\"set_login_sendingcaption\\";s:10:\\"Sending...\\";s:24:\\"set_login_rememberbutton\\";s:18:\\"Keep me logged in \\";s:16:\\"set_login_button\\";s:5:\\"LOGIN\\";s:18:\\"set_login_facebook\\";s:21:\\"Connect with Facebook\\";s:20:\\"set_recover_toptitle\\";s:21:\\"Recover Your Password\\";s:22:\\"set_recover_descripton\\";s:149:\\"To recover your password please fill in the fields below and you will receive your login information in your e-mail inbox within a couple of minutes.\\";s:24:\\"set_recover_emailcaption\\";s:21:\\"Your E-mail Address :\\";s:25:\\"set_recover_usernamealert\\";s:30:\\"Please enter your username ...\\";s:30:\\"set_recover_notvalidemailalert\\";s:17:\\"Email not valid !\\";s:24:\\"set_recover_sendingalert\\";s:10:\\"Sending...\\";s:21:\\"set_recover_failalert\\";s:7:\\"Fail...\\";s:24:\\"set_recover_successalert\\";s:11:\\"Thank you !\\";s:30:\\"set_recover_notindatabasealert\\";s:36:\\"We coudnt find your e-mail address !\\";s:18:\\"set_recover_button\\";s:9:\\"SEND MAIL\\";s:21:\\"set_register_toptitle\\";s:20:\\"Register New Account\\";s:23:\\"set_register_descripton\\";s:146:\\"While registering a new account is public, all accounts will be checked and approved by our administrators which may take up to 1-3 business days.\\";s:24:\\"set_register_namecaption\\";s:16:\\"Your First Name:\\";s:27:\\"set_register_surnamecaption\\";s:15:\\"Your Last Name:\\";s:28:\\"set_register_usernamecaption\\";s:18:\\"Desired Username :\\";s:25:\\"set_register_emailcaption\\";s:21:\\"Your E-mail Address :\\";s:31:\\"set_register_repeatemailcaption\\";s:23:\\"Repeat E-mail Address :\\";s:28:\\"set_register_passwordcaption\\";s:18:\\"Desired Password :\\";s:34:\\"set_register_repeatpasswordcaption\\";s:17:\\"Repeat Password :\\";s:34:\\"set_register_registerbuttoncaption\\";s:8:\\"REGISTER\\";s:32:\\"set_register_gobackbuttoncaption\\";s:7:\\"GO BACK\\";s:22:\\"set_register_namealert\\";s:25:\\"Please enter your name...\\";s:26:\\"set_register_usernamealert\\";s:29:\\"Please enter your username...\\";s:31:\\"set_register_notvalidemailalert\\";s:17:\\"Email not valid !\\";s:24:\\"set_register_emailsalert\\";s:19:\\"Emails do not match\\";s:26:\\"set_register_passwordalert\\";s:21:\\"Please enter password\\";s:32:\\"set_register_wrongpasswordsalert\\";s:24:\\"Passwords do not match !\\";s:25:\\"set_register_sendingalert\\";s:10:\\"Sending...\\";s:22:\\"set_register_failalert\\";s:7:\\"Fail...\\";s:25:\\"set_register_successalert\\";s:42:\\"Check your email to confirm your account !\\";s:24:\\"set_register_existsalert\\";s:38:\\"The email you entered already exists !\\";s:19:\\"set_register_button\\";s:8:\\"REGISTER\\";s:16:\\"set_register_tos\\";s:145:\\"I read the <a href=\\\\\\\\\\\\\\"privacy_policy.html\\\\\\\\\\\\\\">Privacy Policy</a> and I agree with the <a href=\\\\\\\\\\\\\\"terms_of_service.html\\\\\\\\\\\\\\">Terms of Service</a>\\";s:21:\\"set_register_tosalert\\";s:23:\\"You must accept our TOS\\";s:28:\\"set_account_youraccounttitle\\";s:12:\\"Your Account\\";s:28:\\"set_account_basicinfocaption\\";s:4:\\"Info\\";s:29:\\"set_account_basicinfosubtitle\\";s:12:\\"Account Info\\";s:27:\\"set_account_shopinfocaption\\";s:4:\\"Shop\\";s:29:\\"set_account_shopinforsubtitle\\";s:23:\\"Billing & Shipping Info\\";s:23:\\"set_account_namecaption\\";s:11:\\"First Name:\\";s:26:\\"set_account_surnamecaption\\";s:10:\\"Last Name:\\";s:24:\\"set_account_emailcaption\\";s:16:\\"E-mail Address :\\";s:20:\\"set_account_password\\";s:17:\\"Current Password:\\";s:30:\\"set_account_newpasswordcaption\\";s:13:\\"New Password:\\";s:36:\\"set_account_repeatnewpasswordcaption\\";s:16:\\"Repeat password:\\";s:29:\\"set_account_savebuttoncaption\\";s:4:\\"Save\\";s:30:\\"set_account_resetbuttoncaption\\";s:5:\\"Reset\\";s:22:\\"set_account_firstalert\\";s:30:\\"Please enter your first name !\\";s:21:\\"set_account_lastalert\\";s:29:\\"Please enter your last name !\\";s:32:\\"set_account_currentpasswordalert\\";s:38:\\"The current password is not correct...\\";s:33:\\"set_account_wrongnewpasswordalert\\";s:29:\\"Please match the new password\\";s:25:\\"set_account_savingcaption\\";s:9:\\"Saving...\\";s:24:\\"set_account_successalert\\";s:17:\\"Profile Updated !\\";}', 0, 1, 'Module Settings|index.php?mod=oxymall&sub=oxymall.plugin.modules.default&action=details&module_id={MODULE_ID}\r\nLinks|index.php?mod=oxymall&sub=oxymall.plugin.sharing.landing&module_id={MODULE_ID}', '', 0);

DROP TABLE IF EXISTS `site_oxymall_core_modules_user`;
CREATE TABLE IF NOT EXISTS `site_oxymall_core_modules_user` (
  `mod_id` int(11) NOT NULL AUTO_INCREMENT,
  `mod_parent` int(11) NOT NULL,
  `mod_order` int(11) NOT NULL DEFAULT '0',
  `mod_status` int(1) NOT NULL DEFAULT '0',
  `mod_invisible` int(1) NOT NULL,
  `mod_module` int(11) NOT NULL DEFAULT '0',
  `mod_module_code` varchar(255) DEFAULT NULL,
  `mod_name` varchar(255) DEFAULT NULL,
  `mod_long_name` varchar(255) DEFAULT NULL,
  `mod_urltitle` varchar(255) DEFAULT NULL,
  `mod_url` varchar(255) DEFAULT NULL,
  `mod_settings` longtext,
  `mod_shopping` int(1) NOT NULL,
  `mod_protected` int(11) NOT NULL,
  `mod_background` int(1) NOT NULL,
  `mod_background_file` varchar(255) NOT NULL,
  `mod_set_protect_delete` int(1) NOT NULL,
  `mod_set_protect_seo` int(1) NOT NULL,
  `mod_set_protect_m` int(1) NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_desc` text NOT NULL,
  `seo_keys` text NOT NULL,
  PRIMARY KEY (`mod_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=56 ;

INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(54, 0, 50, 1, 0, 2, 'banner', 'Banner Rotator', 'Banner Rotator', 'Banner Rotator', 'banner-rotator', 'a:3:{s:21:\\"set_description_width\\";s:3:\\"300\\";s:8:\\"set_stay\\";s:1:\\"3\\";s:14:\\"set_fbcomments\\";s:1:\\"0\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(51, 0, 48, 1, 0, 103, 'category', 'Client Area', 'Client Area', 'Client Area', 'client-area', 'b:0;', 0, 1, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(52, 51, 52, 1, 0, 1, 'about', 'Sample text page', 'Sample text page', 'Sample text page', 'sample-text-page', 'a:3:{s:15:\\"set_modulewidth\\";s:3:\\"730\\";s:16:\\"set_moduleheight\\";s:3:\\"520\\";s:20:\\"set_moduleremovetime\\";s:3:\\"0.7\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(53, 41, 53, 1, 0, 5, 'gallery', 'Gallery', 'Gallery', 'Gallery', 'gallery', 'a:3:{s:9:\\"set_items\\";s:2:\\"12\\";s:16:\\"set_items_column\\";s:1:\\"4\\";s:14:\\"set_fbcomments\\";s:1:\\"0\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(49, 0, 47, 1, 0, 3, 'clients', 'Clients', 'Clients', 'Clients', 'clients', 'a:2:{s:9:\\"set_items\\";s:2:\\"12\\";s:14:\\"set_fbcomments\\";s:1:\\"0\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(45, 41, 45, 1, 0, 12, 'external-link', 'OXYLUS Templates', 'OXYLUS Flash', 'OXYLUS Flash', 'oxylus-flash', 'a:2:{s:8:\\"set_link\\";s:30:\\"http://www.oxylustemplates.com\\";s:10:\\"set_target\\";s:6:\\"_blank\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(46, 0, 40, 1, 0, 14, 'blog', 'Our Blog', 'Our Blog', 'Our Blog', 'our-blog', 'a:22:{s:19:\\"set_categories_type\\";s:1:\\"2\\";s:9:\\"set_items\\";s:2:\\"10\\";s:15:\\"set_date_format\\";s:13:\\"jS \\\\\\\\o\\\\\\\\f F Y\\";s:23:\\"set_date_format_details\\";s:13:\\"jS \\\\\\\\o\\\\\\\\f F Y\\";s:13:\\"set_label_url\\";s:3:\\"all\\";s:15:\\"set_label_title\\";s:9:\\"All Posts\\";s:14:\\"set_fbcomments\\";s:1:\\"1\\";s:18:\\"set_text_list_date\\";s:10:\\"Posted on:\\";s:18:\\"set_text_list_back\\";s:15:\\"Back to listing\\";s:21:\\"set_text_details_back\\";s:4:\\"BACK\\";s:21:\\"set_text_details_next\\";s:4:\\"NEXT\\";s:18:\\"set_text_posted_by\\";s:10:\\"Posted by \\";s:18:\\"set_text_posted_on\\";s:3:\\"on \\";s:18:\\"set_publisher_back\\";s:14:\\"Back to topics\\";s:16:\\"set_filter_order\\";s:6:\\"Order:\\";s:15:\\"set_filter_sort\\";s:8:\\"Sort by:\\";s:15:\\"set_filter_name\\";s:4:\\"Name\\";s:15:\\"set_filter_date\\";s:4:\\"Date\\";s:17:\\"set_filter_author\\";s:6:\\"Author\\";s:14:\\"set_filter_asc\\";s:9:\\"Ascending\\";s:15:\\"set_filter_desc\\";s:10:\\"Descending\\";s:17:\\"set_filter_search\\";s:10:\\"Search ...\\";}', 0, 0, 0, '', 0, 0, 0, 'Our blog', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(47, 0, 41, 1, 0, 108, 'team', 'Our Team', 'Our Team', 'Our Team', 'our-team', 'a:6:{s:9:\\"set_items\\";s:1:\\"8\\";s:14:\\"set_fbcomments\\";s:1:\\"0\\";s:19:\\"set_categories_type\\";s:1:\\"3\\";s:14:\\"set_text_email\\";s:7:\\"E-Mail:\\";s:14:\\"set_text_phone\\";s:7:\\"Phone: \\";s:13:\\"set_text_back\\";s:4:\\"Back\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(48, 0, 46, 1, 0, 6, 'jobs', 'Careers', 'Careers', 'Careers', 'careers', 'a:23:{s:9:\\"set_items\\";s:1:\\"1\\";s:15:\\"set_date_format\\";s:11:\\"m d Y g:i a\\";s:23:\\"set_date_format_details\\";s:7:\\"jS  F Y\\";s:14:\\"set_fbcomments\\";s:1:\\"0\\";s:23:\\"set_text_details_button\\";s:12:\\"Read Details\\";s:22:\\"set_text_resume_button\\";s:17:\\"Apply to this job\\";s:14:\\"set_text_apply\\";s:18:\\"Apply for this Job\\";s:18:\\"set_text_list_date\\";s:10:\\"Posted on:\\";s:18:\\"set_text_list_back\\";s:15:\\"Back to listing\\";s:21:\\"set_text_details_back\\";s:4:\\"BACK\\";s:21:\\"set_text_details_next\\";s:4:\\"NEXT\\";s:21:\\"set_text_upload_field\\";s:13:\\"Upload Resume\\";s:15:\\"set_text_upload\\";s:6:\\"Upload\\";s:20:\\"set_text_send_button\\";s:9:\\"APPLY NOW\\";s:13:\\"set_text_send\\";s:11:\\"Please wait\\";s:16:\\"set_text_success\\";s:24:\\"Your resume was received\\";s:16:\\"set_post_comment\\";s:1035:\\"Fusce accumsan elementum massa ac tincidunt. Pellentesque faucibus dolor eget est vestibulum eget varius purus faucibus. Aliquam bibendum tortor nec lacus dictum ultricies. Quisque non faucibus justo. Sed commodo faucibus tortor at luctus. Ut ipsum sem, euismod a tristique at, suscipit non quam. In faucibus odio nec eros rhoncus blandit.\r\n\r\nMorbi nec mi turpis. Fusce in turpis sem, at ultricies urna. Nulla nec imperdiet enim. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. In lobortis, mauris id ultrices blandit, erat neque faucibus tellus, vitae venenatis elit neque in odio. Curabitur vehicula aliquam diam ac sodales. \r\n\r\n    Lorem ipsum dolor sit amet, consectetur adipiscing elit.\r\n    Sed vel diam ac velit adipiscing placerat suscipit eu dui.\r\n    Phasellus ut nibh id mauris dignissim dictum et ut urna.\r\n    Praesent ac metus risus, et semper mauris.\r\n    Vivamus luctus risus quis nisl sagittis eget suscipit turpis luctus.\r\n    Nullam suscipit turpis eget orci tincidunt tempor.\r\n\\";s:14:\\"set_mail_admin\\";s:20:\\"careers_resume_admin\\";s:15:\\"set_mail_client\\";s:21:\\"careers_resume_client\\";s:17:\\"set_email_message\\";s:60:\\"Name: {FIRST_NAME} {LAST_NAME}\r\n\r\nPhone: {PHONE}\r\n\r\n{RESUME}\\";s:27:\\"set_verificationcodecaption\\";s:18:\\"Verification Image\\";s:27:\\"set_verificationcoderefresh\\";s:7:\\"Refresh\\";s:25:\\"set_verificationcodeerror\\";s:27:\\"Invalid verification code !\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(34, 0, 0, 1, 0, 10, 'homepage', 'Welcome', 'Home', 'Home', 'home', 'a:1:{s:14:\\"set_fbcomments\\";s:1:\\"0\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(36, 0, 34, 1, 0, 8, 'portfolio', 'Portfolio', 'Portfolio', 'Portfolio', 'portfolio', 'a:5:{s:9:\\"set_items\\";s:1:\\"9\\";s:14:\\"set_fbcomments\\";s:1:\\"0\\";s:16:\\"set_items_column\\";s:1:\\"3\\";s:18:\\"set_text_list_back\\";s:16:\\"Back to category\\";s:13:\\"set_text_link\\";s:21:\\"Visit project\\\\\\''s site\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(37, 0, 23, 1, 0, 15, 'products', 'E-commerce Shop', 'E-commerce Shop', 'E-commerge Shop', 'e-commerce-shop', 'a:60:{s:7:\\"set_ipp\\";s:2:\\"12\\";s:16:\\"set_items_column\\";s:9:\\"four-cols\\";s:14:\\"set_fbcomments\\";s:1:\\"0\\";s:19:\\"set_categories_type\\";s:1:\\"2\\";s:11:\\"set_reviews\\";s:1:\\"1\\";s:15:\\"set_askquestion\\";s:1:\\"1\\";s:18:\\"set_mail_ask_admin\\";s:27:\\"products_ask_question_admin\\";s:19:\\"set_mail_ask_client\\";s:28:\\"products_ask_question_client\\";s:21:\\"set_mail_review_admin\\";s:25:\\"products_new_review_admin\\";s:22:\\"set_mail_review_client\\";s:26:\\"products_new_review_client\\";s:15:\\"set_filter_name\\";s:4:\\"Name\\";s:16:\\"set_filter_price\\";s:5:\\"Price\\";s:15:\\"set_filter_date\\";s:4:\\"Date\\";s:16:\\"set_filter_sales\\";s:5:\\"Sales\\";s:14:\\"set_filter_asc\\";s:9:\\"Ascending\\";s:15:\\"set_filter_desc\\";s:10:\\"Descending\\";s:17:\\"set_filter_search\\";s:10:\\"Search ...\\";s:20:\\"set_filter_text_sort\\";s:10:\\"Sort by : \\";s:21:\\"set_filter_text_order\\";s:7:\\"Order :\\";s:13:\\"set_ask_title\\";s:14:\\"Ask a Question\\";s:12:\\"set_ask_name\\";s:15:\\"Your Full Name:\\";s:13:\\"set_ask_phone\\";s:12:\\"Your Phone: \\";s:13:\\"set_ask_email\\";s:12:\\"Your E-Mail:\\";s:15:\\"set_ask_subject\\";s:8:\\"Subject:\\";s:15:\\"set_ask_message\\";s:8:\\"Message:\\";s:16:\\"set_ask_button_1\\";s:13:\\"SEND QUESTION\\";s:16:\\"set_ask_button_2\\";s:5:\\"RESET\\";s:15:\\"set_ask_sending\\";s:14:\\"Please wait...\\";s:17:\\"set_ask_namealert\\";s:24:\\"Please enter your name !\\";s:18:\\"set_ask_phonealert\\";s:32:\\"Please enter your phone number !\\";s:18:\\"set_ask_emailalert\\";s:34:\\"Please enter your e-mail address !\\";s:20:\\"set_ask_subjectalert\\";s:24:\\"Please enter a subject !\\";s:20:\\"set_ask_messagealert\\";s:28:\\"Please enter your question !\\";s:15:\\"set_ask_success\\";s:23:\\"Your message was sent !\\";s:17:\\"set_reviews_title\\";s:7:\\"Reviews\\";s:22:\\"set_reviews_title_post\\";s:17:\\"Post new review :\\";s:16:\\"set_reviews_name\\";s:16:\\"Your full name :\\";s:17:\\"set_reviews_email\\";s:20:\\"Your email address: \\";s:19:\\"set_reviews_message\\";s:13:\\"Your review :\\";s:20:\\"set_reviews_button_1\\";s:11:\\"SEND REVIEW\\";s:20:\\"set_reviews_button_2\\";s:5:\\"RESET\\";s:19:\\"set_reviews_sending\\";s:15:\\"Please wait ...\\";s:21:\\"set_reviews_namealert\\";s:24:\\"Please enter your name !\\";s:22:\\"set_reviews_emailalert\\";s:34:\\"Please enter your e-mail address !\\";s:24:\\"set_reviews_messagealert\\";s:26:\\"Please enter your review !\\";s:19:\\"set_reviews_success\\";s:22:\\"Your review was sent !\\";s:21:\\"set_reviews_load_more\\";s:13:\\"Load More ...\\";s:21:\\"set_reviews_text_said\\";s:6:\\"said :\\";s:24:\\"set_date_format_comments\\";s:20:\\"\\\\\\\\o\\\\\\\\n jS \\\\\\\\o\\\\\\\\f F Y\\";s:16:\\"set_details_back\\";s:4:\\"Back\\";s:17:\\"set_details_price\\";s:6:\\"Price \\";s:23:\\"set_details_description\\";s:11:\\"Description\\";s:17:\\"set_details_specs\\";s:5:\\"Specs\\";s:20:\\"set_details_checkout\\";s:8:\\"Checkout\\";s:15:\\"set_details_add\\";s:11:\\"ADD TO CART\\";s:19:\\"set_prj_middle_text\\";s:26:\\"Product Multimedia Gallery\\";s:14:\\"set_list_price\\";s:8:\\"Price : \\";s:12:\\"set_list_add\\";s:11:\\"ADD TO CART\\";s:16:\\"set_list_details\\";s:7:\\"DETAILS\\";s:15:\\"set_disable_add\\";s:1:\\"0\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(55, 15, 0, 1, 0, 1, 'about', 'Welcome Facebook User', 'Your account is linked to facebook', 'Welcome Facebook User', 'welcome-facebook-user', 'a:1:{s:14:\\"set_fbcomments\\";s:1:\\"0\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(38, 0, 36, 1, 0, 106, 'countdown', 'Coming Soon', 'Coming Soon', 'Coming Soon', 'coming-soon', 'a:15:{s:14:\\"set_fbcomments\\";s:1:\\"0\\";s:14:\\"set_launchdate\\";i:1359504000;s:14:\\"set_counttitle\\";s:32:\\"Complete Template Launch Timer :\\";s:18:\\"set_topdescription\\";s:1427:\\"<p style=\\\\\\"text-align: justify;\\\\\\">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>\r\n<p style=\\\\\\"text-align: justify;\\\\\\">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>\r\n<p style=\\\\\\"text-align: justify;\\\\\\">Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>\\";s:17:\\"set_link_redirect\\";s:1:\\"/\\";s:14:\\"set_daycaption\\";s:4:\\"DAYS\\";s:15:\\"set_hourcaption\\";s:5:\\"HOURS\\";s:18:\\"set_minutescaption\\";s:7:\\"MINUTES\\";s:18:\\"set_secondscaption\\";s:7:\\"SECONDS\\";s:19:\\"set_launchdate_hour\\";s:2:\\"00\\";s:18:\\"set_launchdate_min\\";s:2:\\"00\\";s:18:\\"set_launchdate_sec\\";s:2:\\"00\\";s:20:\\"set_launchdate_month\\";s:2:\\"01\\";s:18:\\"set_launchdate_day\\";s:2:\\"30\\";s:19:\\"set_launchdate_year\\";s:4:\\"2013\\";}', 0, 0, 0, '', 0, 0, 0, 'CountDown', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(39, 0, 37, 1, 0, 4, 'contact', 'Contact Us', 'Contact Us', 'Contact Us', 'contact-us', 'a:10:{s:14:\\"set_mail_admin\\";s:13:\\"contact_admin\\";s:15:\\"set_mail_client\\";s:14:\\"contact_client\\";s:17:\\"set_email_message\\";s:37:\\"Department: {DEPARTMENT}\r\n\r\n{MESSAGE}\\";s:27:\\"set_verificationcodecaption\\";s:17:\\"Verification Code\\";s:27:\\"set_verificationcoderefresh\\";s:6:\\"RELOAD\\";s:25:\\"set_verificationcodeerror\\";s:25:\\"Invalid verification code\\";s:28:\\"set_contactsendbuttoncaption\\";s:12:\\"SEND MESSAGE\\";s:22:\\"set_resetbuttoncaption\\";s:10:\\"RESET FORM\\";s:22:\\"set_sendingmessagetext\\";s:29:\\"Sending email, please wait...\\";s:14:\\"set_succestext\\";s:11:\\"Thank you !\\";}', 0, 0, 0, '', 0, 0, 0, 'Contact', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(15, 0, 51, 1, 1, 103, 'category', 'System Pages', 'Hidden Links', 'Hidden Links', 'hidden-links', 'b:0;', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(16, 15, 17, 1, 1, 1, 'about', 'Page Not Found', 'Page Not Found', 'Page Not Found', 'page-not-found', 'a:2:{s:15:\\"set_modulewidth\\";s:3:\\"880\\";s:16:\\"set_moduleheight\\";s:3:\\"320\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(17, 15, 16, 1, 1, 1, 'about', 'Terms And Conditions', 'Terms And Conditions', 'Terms And Conditions', 'terms-and-conditions', 'a:3:{s:15:\\"set_modulewidth\\";s:3:\\"880\\";s:16:\\"set_moduleheight\\";s:3:\\"320\\";s:20:\\"set_moduleremovetime\\";s:0:\\"\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(18, 15, 18, 1, 1, 1, 'about', 'Privacy Policy', 'Privacy Policy', 'Privacy Policy', 'privacy-policy', 'a:2:{s:15:\\"set_modulewidth\\";s:3:\\"880\\";s:16:\\"set_moduleheight\\";s:3:\\"320\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(19, 15, 19, 1, 1, 1, 'about', 'Paypal Order Completed', 'Order Completed', 'Order Completed', 'paypal-order-completed', 'a:3:{s:15:\\"set_modulewidth\\";s:3:\\"880\\";s:16:\\"set_moduleheight\\";s:3:\\"320\\";s:20:\\"set_moduleremovetime\\";s:0:\\"\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(41, 0, 38, 1, 0, 103, 'category', 'Dropdown', 'Dropdown', 'Dropdown', 'dropdown', 'b:0;', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(42, 41, 42, 1, 0, 9, 'services', 'Services', 'Services', 'Services', 'services', 'a:3:{s:9:\\"set_items\\";s:1:\\"8\\";s:14:\\"set_fbcomments\\";s:1:\\"0\\";s:19:\\"set_categories_type\\";s:1:\\"3\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(43, 41, 43, 1, 0, 1, 'about', 'About Us', 'About Us', 'About Us', 'about-us', 'a:1:{s:14:\\"set_fbcomments\\";s:1:\\"0\\";}', 0, 0, 0, '', 0, 0, 0, 'Acout Us', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(44, 41, 44, 1, 0, 7, 'news', 'Our latest News', 'Our latest News', 'Our latest News', 'our-latest-news', 'a:8:{s:9:\\"set_items\\";s:1:\\"1\\";s:15:\\"set_date_format\\";s:13:\\"jS \\\\\\\\o\\\\\\\\f F Y\\";s:23:\\"set_date_format_details\\";s:13:\\"jS \\\\\\\\o\\\\\\\\f F Y\\";s:14:\\"set_fbcomments\\";s:1:\\"0\\";s:18:\\"set_text_list_date\\";s:10:\\"Posted on:\\";s:18:\\"set_text_list_back\\";s:15:\\"Back to listing\\";s:21:\\"set_text_details_back\\";s:4:\\"BACK\\";s:21:\\"set_text_details_next\\";s:4:\\"NEXT\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(25, 15, 25, 1, 1, 1, 'about', 'Confirmed Account', 'Confirmed Account', 'Confirmed Account', 'confirmed-account', 'a:3:{s:15:\\"set_modulewidth\\";s:3:\\"730\\";s:16:\\"set_moduleheight\\";s:3:\\"520\\";s:20:\\"set_moduleremovetime\\";s:3:\\"0.7\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(26, 15, 26, 1, 1, 1, 'about', 'Invalid Confirm Link', 'Invalid Confirm Link', 'Invalid Confirm Link', 'invalid-confirm-link', 'a:3:{s:15:\\"set_modulewidth\\";s:3:\\"730\\";s:16:\\"set_moduleheight\\";s:3:\\"520\\";s:20:\\"set_moduleremovetime\\";s:3:\\"0.7\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(27, 15, 27, 1, 1, 1, 'about', 'New password emailed', 'New password emailed', 'New password emailed', 'new-password-emailed', 'a:3:{s:15:\\"set_modulewidth\\";s:3:\\"730\\";s:16:\\"set_moduleheight\\";s:3:\\"520\\";s:20:\\"set_moduleremovetime\\";s:3:\\"0.7\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(28, 15, 28, 1, 1, 1, 'about', 'Invalid recover password link', 'Invalid recover password link', 'Invalid recover password link', 'invalid-recover-password-link', 'a:3:{s:15:\\"set_modulewidth\\";s:3:\\"730\\";s:16:\\"set_moduleheight\\";s:3:\\"520\\";s:20:\\"set_moduleremovetime\\";s:3:\\"0.7\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(29, 15, 29, 1, 1, 1, 'about', 'Offline Order Completed', 'Offline Order Completed', 'Offline Order Completed', 'offline-order-completed', 'a:3:{s:15:\\"set_modulewidth\\";s:3:\\"730\\";s:16:\\"set_moduleheight\\";s:3:\\"520\\";s:20:\\"set_moduleremovetime\\";s:3:\\"0.7\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(30, 15, 30, 1, 1, 1, 'about', 'Canceled Order', 'Canceled Order', 'Canceled Order', 'canceled-order', 'a:3:{s:15:\\"set_modulewidth\\";s:3:\\"730\\";s:16:\\"set_moduleheight\\";s:3:\\"520\\";s:20:\\"set_moduleremovetime\\";s:3:\\"0.7\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(31, 15, 31, 1, 1, 1, 'about', 'Creditcard Order Completed', 'Creditcard Order Completed', 'Creditcard Order Completed', 'creditcard-order-completed', 'a:3:{s:15:\\"set_modulewidth\\";s:3:\\"730\\";s:16:\\"set_moduleheight\\";s:3:\\"520\\";s:20:\\"set_moduleremovetime\\";s:3:\\"0.7\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');
INSERT INTO `site_oxymall_core_modules_user` (`mod_id`, `mod_parent`, `mod_order`, `mod_status`, `mod_invisible`, `mod_module`, `mod_module_code`, `mod_name`, `mod_long_name`, `mod_urltitle`, `mod_url`, `mod_settings`, `mod_shopping`, `mod_protected`, `mod_background`, `mod_background_file`, `mod_set_protect_delete`, `mod_set_protect_seo`, `mod_set_protect_m`, `seo_title`, `seo_desc`, `seo_keys`) VALUES(32, 15, 32, 1, 1, 1, 'about', 'Download Exceeded', 'Download Exceeded', 'Download Exceeded', 'download-exceeded', 'a:3:{s:15:\\"set_modulewidth\\";s:3:\\"730\\";s:16:\\"set_moduleheight\\";s:3:\\"520\\";s:20:\\"set_moduleremovetime\\";s:3:\\"0.7\\";}', 0, 0, 0, '', 0, 0, 0, '', '', '');

DROP TABLE IF EXISTS `site_oxymall_core_vars`;
CREATE TABLE IF NOT EXISTS `site_oxymall_core_vars` (
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM;

INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('forms_core_images_process', '');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_skin', '2');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_logo_type', '1');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_owner_google', '');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_owner_ms', '');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_owner_yahoo', '');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_meta_title', 'Fluxglide Full HTML5 Website Template with Shop and CMS  ');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_meta_keys', '');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_meta_desc', '');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_google_analytics_tracker', '');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_shop_currency', 'usd');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_shop_currency_sign', '$');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_shop_currencyposition', 'before');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_logo_file', 'logo.png');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_logo', '1');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_google_analytics', '0');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('homepage_products_1', 'Sample Products');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_switft_transport', 'php-default');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_send_block', '1');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('about_header_25', '<p>confirmed account</p>');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('about_header_26', '<p>invalid confirm link</p>');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('about_header_27', '<p>the new password was mailed to your account</p>');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('about_header_28', '<p>invalid recover password link</p>');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_shop_shipping_country', 'US');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('about_header_29', '<p>Your order was now completed. You will be contacted by one of our sale representative in the next day to finalize the details.</p>');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('about_header_19', '<p>safasdf</p>');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('about_header_30', '<p>Canceled order</p>');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('about_header_31', '<p>Your order is now completed</p>');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_shop_mail_admin', 'shop_order_admin_notify');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_shop_mail_client_1', 'shop_order_client_pending');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_shop_mail_client_2', 'shop_order_client_completed');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_shop_mail_client_3', 'shop_order_client_refunded');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_tax_domestic', '5');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_tax_international', '0');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('about_header_32', '<p>Download excedded or invalid download link.</p>');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_shop_download_limit', '5');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_shop_download_exceeded', '32');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_shop_mail_admin_1', 'shop_order_admin_pending');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_shop_mail_admin_2', 'shop_order_admin_completed');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_shop_mail_admin_3', 'shop_order_admin_refunded');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_shop_mail_admin_4', 'shop_order_admin_canceled');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_shop_mail_admin_5', 'shop_order_admin_shipped');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('homepage_header_34', '<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('homepage_products_34', 'Some of our latest designs: ');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('contact_title_39', 'Contact Form');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('contact_subtitle_39', 'Please make sure you fill in all the fields correctly and you also enter the image verification code in order toÃ‚  send the message successfully. Thank you !');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('contact_header_39', '<h2>John Smith Inc.</h2>\r\n<p>45 Esquire Drive<br />\r\n90314 California, USA</p>');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('contact_image_link_39', 'http://www.oxylustemplates.com');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('contact_image_link_target_39', '_blank');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('contact_image_39_file', '818.jpg');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('contact_image_39', '1');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('about_header_43', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec dignissim, libero non elementum luctus, quam diam accumsan neque, ut tempus augue metus id orci. Sed et velit dui. Ut fermentum augue tincidunt eros rutrum ullamcorper. Pellentesque lobortis sapien eu augue dignissim cursus. Aliquam vestibulum viverra lorem eu consequat. Mauris dignissim dictum est vel consequat. Vestibulum cursus lacus et ligula gravida sit amet congue ante venenatis. Mauris lorem sem, vestibulum eu cursus at, bibendum eget felis. Suspendisse sed nulla lorem, consequat bibendum nulla. Phasellus eu lectus sed nunc pulvinar tempor eu dictum mi. Fusce at lorem quam. Donec urna quam, vestibulum quis vulputate nec, feugiat eu neque. Quisque sagittis sapien id lorem imperdiet nec varius justo dapibus. Donec vel massa elit, nec dignissim eros. <br />\r\n</p>');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('about_header_52', '<p>Protected page...</p>');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_links_type', '0');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_logo_crop_oxbc', '');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_shop_number_dec_count', '2');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_shop_number_dec', ',');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_shop_number_mul', '.');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_swiftp_smtp_server', '');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_swiftp_smtp_port', '');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_swiftp_smtp_auth_username', '');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_swiftp_smtp_auth_password', '');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_swiftp_smtp_enc', 'none');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_swiftp_sendmail', '');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('test_to', '');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('test_subject', 'Test email sent with swiftmail');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('test_body', 'Test email sent with swiftmail');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_shop_require_users', '1');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_facebook_app', '');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_facebook_admins', '');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_facebook_script', '');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_404', '16');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('about_header_16', '<p>The page you are looking for coudnt be found on server.</p>');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_facebook_secret', '');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('about_header_55', '<p>Your account is now linked to facebook ...</p>');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_logo_temp_file', '');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('show_settings', '0');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_menu_show', '0');
INSERT INTO `site_oxymall_core_vars` (`name`, `value`) VALUES('set_cache', '0');

DROP TABLE IF EXISTS `site_oxymall_plugin_background_items`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_background_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_order` int(11) DEFAULT NULL,
  `item_type` int(11) NOT NULL,
  `item_file` int(11) DEFAULT NULL,
  `item_file_file` varchar(255) DEFAULT NULL,
  `item_title` varchar(255) DEFAULT NULL,
  `item_flv` int(1) NOT NULL,
  `item_flv_file` varchar(255) NOT NULL,
  `item_mp4` int(1) NOT NULL,
  `item_mp4_file` varchar(255) NOT NULL,
  `item_module` int(11) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=5 ;

INSERT INTO `site_oxymall_plugin_background_items` (`item_id`, `item_order`, `item_type`, `item_file`, `item_file_file`, `item_title`, `item_flv`, `item_flv_file`, `item_mp4`, `item_mp4_file`, `item_module`) VALUES(2, 2, 1, 1, '1.jpg', 'Sample', 0, '', 0, '', 0);

DROP TABLE IF EXISTS `site_oxymall_plugin_banner_images`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_banner_images` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_order` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `item_title` text NOT NULL,
  `item_type` int(1) NOT NULL,
  `item_image` int(11) DEFAULT NULL,
  `item_image_file` varchar(255) DEFAULT NULL,
  `item_image_width` int(11) DEFAULT NULL,
  `item_image_height` int(11) DEFAULT NULL,
  `item_video` varchar(255) NOT NULL,
  `item_description` text,
  `item_url` varchar(255) DEFAULT NULL,
  `item_target` varchar(20) DEFAULT NULL,
  `item_stay` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `site_oxymall_plugin_banner_texts`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_banner_texts` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `item_parent` int(11) NOT NULL,
  `item_text` text NOT NULL,
  `item_set_horizontalalign` varchar(20) NOT NULL,
  `item_set_verticalalign` varchar(20) NOT NULL,
  `item_set_description_width` varchar(11) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `site_oxymall_plugin_blog_authors`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_blog_authors` (
  `author_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `author_url` varchar(255) NOT NULL,
  `author_avatar` int(1) NOT NULL,
  `author_avatar_file` varchar(255) NOT NULL,
  `author_bio` text NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_keys` text NOT NULL,
  `seo_desc` text NOT NULL,
  PRIMARY KEY (`author_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=2 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_blog_cats`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_blog_cats` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_order` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `cat_title` varchar(255) NOT NULL,
  `cat_url` varchar(255) NOT NULL,
  `cat_urltitle` varchar(255) NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_keys` text NOT NULL,
  `seo_desc` text NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `site_oxymall_plugin_blog_items`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_blog_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_cat` text NOT NULL,
  `item_date` int(11) DEFAULT NULL,
  `item_order` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `item_title` varchar(255) DEFAULT NULL,
  `item_url` varchar(255) DEFAULT NULL,
  `item_brief` text,
  `item_body` text,
  `item_author` int(11) NOT NULL,
  `item_comments` int(1) NOT NULL,
  `item_tags` text NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_desc` text NOT NULL,
  `seo_keys` text NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `item_author` (`item_author`),
  FULLTEXT KEY `item_tags` (`item_tags`),
  FULLTEXT KEY `item_title` (`item_title`)
) ENGINE=MyISAM  ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `site_oxymall_plugin_clients_cats`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_clients_cats` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_order` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `cat_title` varchar(255) DEFAULT NULL,
  `cat_description` text NOT NULL,
  `cat_url` varchar(255) DEFAULT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_desc` text NOT NULL,
  `seo_keys` text NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `site_oxymall_plugin_clients_images`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_clients_images` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_order` int(11) DEFAULT NULL,
  `item_cat` int(11) NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  `item_title` varchar(255) DEFAULT NULL,
  `item_image` int(11) DEFAULT NULL,
  `item_image_file` varchar(255) DEFAULT NULL,
  `item_image_width` int(11) DEFAULT NULL,
  `item_image_height` int(11) DEFAULT NULL,
  `item_description` text,
  `item_url` varchar(255) DEFAULT NULL,
  `item_target` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  KEY `item_order` (`item_order`),
  KEY `item_cat` (`item_cat`),
  KEY `module_id` (`module_id`)
) ENGINE=MyISAM  ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `site_oxymall_plugin_comments`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_comments` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_url` varchar(500) NOT NULL,
  `item_date` int(11) NOT NULL,
  `item_author` varchar(50) NOT NULL,
  `item_website` varchar(255) NOT NULL,
  `item_email` varchar(50) NOT NULL,
  `item_body` text NOT NULL,
  `item_status` int(1) NOT NULL,
  `item_user` int(11) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `item_url` (`item_url`(255)),
  KEY `item_date` (`item_date`),
  KEY `item_status` (`item_status`)
) ENGINE=MyISAM  AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_contact_fields`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_contact_fields` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `item_order` int(11) NOT NULL,
  `item_field` varchar(255) NOT NULL,
  `item_type` varchar(30) NOT NULL,
  `item_title` varchar(255) NOT NULL,
  `item_error_msg` varchar(255) NOT NULL,
  `item_required` int(1) NOT NULL,
  `item_size` varchar(5) NOT NULL,
  `item_options` text NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=18 ;

INSERT INTO `site_oxymall_plugin_contact_fields` (`item_id`, `module_id`, `item_order`, `item_field`, `item_type`, `item_title`, `item_error_msg`, `item_required`, `item_size`, `item_options`) VALUES(11, 39, 11, 'name', 'usertext', 'Your Full Name:', 'Please enter your name!', 1, 'big', '');
INSERT INTO `site_oxymall_plugin_contact_fields` (`item_id`, `module_id`, `item_order`, `item_field`, `item_type`, `item_title`, `item_error_msg`, `item_required`, `item_size`, `item_options`) VALUES(12, 39, 12, 'email', 'useremail', 'Your E-mail address:', 'Please enter your email !', 1, 'small', '');
INSERT INTO `site_oxymall_plugin_contact_fields` (`item_id`, `module_id`, `item_order`, `item_field`, `item_type`, `item_title`, `item_error_msg`, `item_required`, `item_size`, `item_options`) VALUES(13, 39, 13, 'department', 'userdroplist', 'Regarding (Department)', '', 0, 'small', 'General Question\r\nFeedback\r\nBusiness Proposal\r\nQuote Request\r\nResume Submission');
INSERT INTO `site_oxymall_plugin_contact_fields` (`item_id`, `module_id`, `item_order`, `item_field`, `item_type`, `item_title`, `item_error_msg`, `item_required`, `item_size`, `item_options`) VALUES(14, 39, 14, 'subject', 'usertext', 'Subject', 'Enter the subject for your message !', 1, 'big', '');
INSERT INTO `site_oxymall_plugin_contact_fields` (`item_id`, `module_id`, `item_order`, `item_field`, `item_type`, `item_title`, `item_error_msg`, `item_required`, `item_size`, `item_options`) VALUES(15, 39, 15, 'message', 'usermessage', 'Message:', 'Please enter your message !', 1, 'big', '');

DROP TABLE IF EXISTS `site_oxymall_plugin_contact_links`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_contact_links` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `item_order` int(11) NOT NULL,
  `item_title` varchar(255) NOT NULL,
  `item_value` varchar(255) NOT NULL,
  `item_link` varchar(255) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=5 ;

INSERT INTO `site_oxymall_plugin_contact_links` (`item_id`, `module_id`, `item_order`, `item_title`, `item_value`, `item_link`) VALUES(1, 13, 1, 'Email', 'email@yoursite.web', 'mailto:email@yoursite.web');
INSERT INTO `site_oxymall_plugin_contact_links` (`item_id`, `module_id`, `item_order`, `item_title`, `item_value`, `item_link`) VALUES(2, 39, 2, 'Web:', 'OXYLUS.ro', 'http://www.oxylus.ro');
INSERT INTO `site_oxymall_plugin_contact_links` (`item_id`, `module_id`, `item_order`, `item_title`, `item_value`, `item_link`) VALUES(3, 39, 3, 'Shop:', 'OXYLUS Flash', 'http://www.oxylusflash.com');
INSERT INTO `site_oxymall_plugin_contact_links` (`item_id`, `module_id`, `item_order`, `item_title`, `item_value`, `item_link`) VALUES(4, 39, 4, 'E-Mail:', 'support@oxylusflash.com', 'http://mailto:support@oxylusflash.com');

DROP TABLE IF EXISTS `site_oxymall_plugin_contact_messages`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_contact_messages` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_code` varchar(32) DEFAULT NULL,
  `item_file` int(1) DEFAULT NULL,
  `item_file_file` varchar(255) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `item_new` int(1) DEFAULT NULL,
  `item_date` int(11) DEFAULT NULL,
  `item_email` varchar(255) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `item_subject` varchar(255) DEFAULT NULL,
  `item_message` text,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_galleries_cats`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_galleries_cats` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_order` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `cat_title` varchar(255) DEFAULT NULL,
  `cat_urltitle` varchar(255) DEFAULT NULL,
  `cat_url` varchar(255) DEFAULT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_desc` text NOT NULL,
  `seo_keys` text NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `site_oxymall_plugin_galleries_items`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_galleries_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_order` int(11) DEFAULT NULL,
  `item_cat` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `item_type` int(1) NOT NULL,
  `item_tn` int(1) NOT NULL,
  `item_tn_file` varchar(255) NOT NULL,
  `item_image` int(11) DEFAULT NULL,
  `item_image_file` varchar(255) DEFAULT NULL,
  `item_video` int(1) DEFAULT NULL,
  `item_video_file` varchar(255) DEFAULT NULL,
  `item_audio` int(1) NOT NULL,
  `item_audio_file` varchar(255) NOT NULL,
  `item_audio_image` int(1) NOT NULL,
  `item_audio_image_file` varchar(255) NOT NULL,
  `item_swf` int(1) NOT NULL,
  `item_swf_file` varchar(255) NOT NULL,
  `item_youtube` varchar(255) NOT NULL,
  `item_title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `site_oxymall_plugin_homepage_images`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_homepage_images` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_order` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `item_image` int(11) DEFAULT NULL,
  `item_image_file` varchar(255) DEFAULT NULL,
  `item_image_width` int(11) DEFAULT NULL,
  `item_image_height` int(11) DEFAULT NULL,
  `item_description` text NOT NULL,
  `item_link` varchar(255) NOT NULL,
  `item_target` varchar(20) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_jobs_cats`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_jobs_cats` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_order` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `cat_title` varchar(255) DEFAULT NULL,
  `cat_description` text NOT NULL,
  `cat_url` varchar(255) DEFAULT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_desc` text NOT NULL,
  `seo_keys` text NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_jobs_fields`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_jobs_fields` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `item_order` int(11) NOT NULL,
  `item_field` varchar(255) NOT NULL,
  `item_type` varchar(30) NOT NULL,
  `item_title` varchar(255) NOT NULL,
  `item_error_msg` varchar(255) NOT NULL,
  `item_required` int(1) NOT NULL,
  `item_size` varchar(5) NOT NULL,
  `item_options` text NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=20 ;

INSERT INTO `site_oxymall_plugin_jobs_fields` (`item_id`, `module_id`, `item_order`, `item_field`, `item_type`, `item_title`, `item_error_msg`, `item_required`, `item_size`, `item_options`) VALUES(13, 48, 15, 'first_name', 'usertext', 'First Name', 'Please enter your first name !', 1, 'small', '');
INSERT INTO `site_oxymall_plugin_jobs_fields` (`item_id`, `module_id`, `item_order`, `item_field`, `item_type`, `item_title`, `item_error_msg`, `item_required`, `item_size`, `item_options`) VALUES(14, 48, 16, 'last_name', 'usertext', 'Last Name', 'Please enter your last name !', 1, 'small', '');
INSERT INTO `site_oxymall_plugin_jobs_fields` (`item_id`, `module_id`, `item_order`, `item_field`, `item_type`, `item_title`, `item_error_msg`, `item_required`, `item_size`, `item_options`) VALUES(15, 48, 17, 'email', 'useremail', 'E-Mail', 'Please enter your email !', 1, 'small', '');
INSERT INTO `site_oxymall_plugin_jobs_fields` (`item_id`, `module_id`, `item_order`, `item_field`, `item_type`, `item_title`, `item_error_msg`, `item_required`, `item_size`, `item_options`) VALUES(16, 48, 18, 'phone', 'usertext', 'Phone', '', 0, 'small', '');
INSERT INTO `site_oxymall_plugin_jobs_fields` (`item_id`, `module_id`, `item_order`, `item_field`, `item_type`, `item_title`, `item_error_msg`, `item_required`, `item_size`, `item_options`) VALUES(17, 48, 19, 'resume', 'usermessage', 'Resume', 'Please enter your resume !', 1, 'big', '');

DROP TABLE IF EXISTS `site_oxymall_plugin_jobs_items`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_jobs_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_status` int(1) DEFAULT NULL,
  `item_date` int(11) DEFAULT NULL,
  `item_order` int(11) DEFAULT NULL,
  `item_cat` int(11) NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  `item_title` varchar(255) DEFAULT NULL,
  `item_url` varchar(255) DEFAULT NULL,
  `item_urltitle` varchar(255) DEFAULT NULL,
  `item_location` varchar(255) DEFAULT NULL,
  `item_small_description` text,
  `item_big_description` text,
  `item_main_title` varchar(255) NOT NULL,
  `item_contact_title` varchar(255) NOT NULL,
  `item_upload_title` varchar(255) NOT NULL,
  `item_readmore_title` varchar(255) NOT NULL,
  `seo_title` text NOT NULL,
  `seo_keys` text NOT NULL,
  `seo_desc` text NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `site_oxymall_plugin_jobs_resumes`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_jobs_resumes` (
  `resume_id` int(11) NOT NULL AUTO_INCREMENT,
  `resume_code` varchar(32) DEFAULT NULL,
  `resume_date` int(11) DEFAULT NULL,
  `resume_job` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `resume_first_name` varchar(255) DEFAULT NULL,
  `resume_last_name` varchar(255) NOT NULL,
  `resume_mail` varchar(255) DEFAULT NULL,
  `resume_phone` varchar(255) DEFAULT NULL,
  `resume_note` text,
  `resume_cv` int(11) DEFAULT NULL,
  `resume_cv_file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`resume_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_mail_emails`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_mail_emails` (
  `email_id` int(11) NOT NULL AUTO_INCREMENT,
  `email_code` varchar(50) NOT NULL,
  `email_status` int(11) NOT NULL,
  `email_subject` varchar(255) NOT NULL,
  `email_from` varchar(255) NOT NULL,
  `email_from_name` varchar(255) NOT NULL,
  `email_to` varchar(255) NOT NULL,
  `email_to_name` varchar(255) NOT NULL,
  `email_body` text NOT NULL,
  PRIMARY KEY (`email_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=30 ;

INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(1, 'account_confirm', 1, 'Please confirm your account', 'no-reply@yoursite.web', 'Account', '{USER_EMAIL}', '{USER_FIRST_NAME} {USER_LAST_NAME}', '<p>Dear {USER_FIRST_NAME},</p>\r\n<p>Welcome to our site</p>\r\n<p>user: {USER_EMAIL}<br />\r\npass: {USER_PASSWORD_PLAIN}<br />\r\n<br />\r\nConfirm Link: {SITE:URL}user-confirm.php?key={USER_KEY_CODE}</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(2, 'account_welcome', 1, 'Your account was activated', 'no-reply@yoursite.web', 'Account', '{USER_EMAIL}', '{USER_FIRST_NAME} {USER_LAST_NAME}', '<p>Dear {USER_FIRST_NAME},</p>\r\n<p>Welcome to our site</p>\r\n<p>user: {USER_EMAIL}</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(3, 'account_forgot_password_link', 1, 'Your password recovery link', 'no-reply@yoursite.web', 'Accounts', '{USER_EMAIL}', '{USER_FIRST_NAME} {USER_LAST_EMAIL}', '<p>Link: {SITE:URL}user-reset.php?key={USER_KEY_CODE}</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(4, 'account_forgot_password_new', 1, 'Your new password', 'no-reply@yoursite.web', 'Your site name', '{USER_EMAIL}', '{USER_FIRST_NAME} {USER_LAST_EMAIL}', '<p>{USER_EMAIL}</p>\r\n<p>{USER_PASSWORD}</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(8, 'account_pending_activation', 0, 'Your acocunt is waiting for admin moderation', '', '', '', '', '<p>sasasa</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(9, 'products_ask_question_admin', 1, 'Somebody asked a question about {ITEM_TITLE}', '{EMAIL}', '{NAME}', 'no-reply@yoursite.web', 'Emanuel', '<p>New user asked a question about {ITEM_TITLE} / SKU:{ITEM_SKU}</p>\r\n<p>Name: {NAME}</p>\r\n<p>Email: {EMAIL}</p>\r\n<p>Question: {MESSAGE}</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(10, 'products_ask_question_client', 1, 'Your question about {ITEM_TITLE}-{ITEM_SKU} was received', 'no-reply@yoursite.web', 'Autoresponder', '{EMAIL}', '{NAME}', '<p>Dear{NAME},</p>\r\n<p>We received your inquiry about {ITEM_TITLE}. Somebody from our staff will answer you shortly.</p>\r\n<p>All the best,<br />\r\nACMETeam</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(11, 'products_new_review_admin', 1, 'New review was received for {ITEM_TITLE}', '{EMAIL}', '{NAME}', 'no-reply@yoursite.web', 'Emanuel', '<p>New review was poste for {ITEM_TITLE}</p>\r\n<p>Author: {NAME}<br />\r\nE-Mail:{EMAIL}</p>\r\n<p>Message:</p>\r\n<p>{MESSAGE}</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(12, 'products_new_review_client', 1, 'Your review was received', 'noreply@yoursite.web', 'Autoresponder', '{EMAIL}', '{NAME}', '<p>Your review was received. It will appear after an administrator will moderate it.</>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(13, 'comment_admin', 1, 'New comment was posted', 'no-reply@yoursite.web', 'AutoMailer', 'no-reply@yoursite.web', 'Emanuel', '<p>Hello,</p>\r\n<p>New Comment was posted for <a href=\\"{ITEM_URL}\\">{ITEM_URL}<br />\r\n</a></p>\r\n<p>Name: {ITEM_AUTHOR}</p>\r\n<p>Email:{ITEM_EMAIL}</p>\r\n<p>Website:{ITEM_WEBSITE}</p>\r\n<p>{ITEM_BODY}</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(15, 'careers_resume_admin', 1, 'You received a new resume for {ITEM_TITLE}', '{EMAIL}', '{FIRST_NAME} {LAST_NAME}', 'no-reply@yoursite.web', 'Emanuel', '<p>Hello,</p>\r\n<p>You received a new resume:</p>\r\n<p>Name: {NAME}</p>\r\n<p>Email:{EMAIL}</p>\r\n<p>Phone:{PHONE}</p>\r\n<p>Attachment:{ATTACHMENT_LINK}</p>\r\n<p>Body:</p>\r\n<p>{NOTE}</p>\r\n<p></p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(16, 'careers_resume_client', 1, 'Thank you for applying to one of our jobs', 'no-reply@yoursite.web', 'Autoresponder', '{EMAIL}', '{FIRST_NAME} {LAST_NAME}', '<p>Hello {NAME},</p>\r\n<p>Thank you for contacting us, You will be contacted by one of our representatives asap.</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(17, 'contact_admin', 1, 'You received a new message: {SUBJECT}', '{EMAIL}', '{NAME}', 'no-reply@yoursite.web', 'Emanuel Giurgea', '<p>Hello,</p>\r\n<p>You received a new message:</p>\r\n<p>Name: {NAME}</p>\r\n<p>Email:{EMAIL}</p>\r\n<p>Subject:{SUBJECT}</p>\r\n<p>Body:</p>\r\n<p>{MESSAGE}</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(18, 'contact_client', 1, 'Thank you for contacting us', 'no-reply@yoursite.web', 'Autoresponder', '{EMAIL}', '{NAME}', '<p>Hello {NAME},</p>\r\n<p>Thank you for contacting us, You will be contacted by one of our representatives asap.</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(19, 'account_notify_admin', 1, 'New user registered on your site', '{USER_EMAIL}', '{USER_FIRST_NAME} {USER_LAST_NAME}', 'no-reply@yoursite.web', 'Emanuel', '<p>New user registerd on your site.</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(20, 'shop_order_client_pending', 1, 'Your order was received and its pending payment', 'no-reply@yoursite.web', 'Autoresponder', '{ORDER_BILLING_EMAIL}', '{ORDER_BILLING_FIRST_NAME} {ORDER_BILLING_LAST_NAME}', '<p>Your order was received </p>\r\n<p>{ORDER_DATA}</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(21, 'shop_order_client_completed', 1, 'Your order was finalized', 'no-reply@yoursite.web', 'Autoresponder', '{ORDER_BILLING_EMAIL}', '{ORDER_BILLING_FIRST_NAME} {ORDER_BILLING_LAST_NAME}', '<p>Your order was received </p>\r\n<p>{ORDER_DATA}</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(22, 'shop_order_client_refunded', 1, 'Your order was refunded', 'no-reply@yoursite.web', 'Autoresponder', '{ORDER_BILLING_EMAIL}', '{ORDER_BILLING_FIRST_NAME} {ORDER_BILLING_LAST_NAME}', '<p>Your order was refunded</p>\r\n<p>{ORDER_DATA}</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(23, 'shop_order_admin_notify', 1, 'New order was placed in your site', 'no-reply@yoursite.web', 'Autoresponder', 'no-reply@yoursite.web', 'Emanuel Giurgea', '<p>Your order was refunded</p> <p>{ORDER_DATA}</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(24, 'shop_order_admin_pending', 1, 'Your order was received and its pending payment', 'no-reply@yoursite.web', 'Autoresponder', '{ORDER_BILLING_EMAIL}', '{ORDER_BILLING_FIRST_NAME} {ORDER_BILLING_LAST_NAME}', '<p>Your order was received </p>\r\n<p>{ORDER_DATA}</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(25, 'shop_order_admin_completed', 1, 'Your order was finalized', 'no-reply@yoursite.web', 'Autoresponder', '{ORDER_BILLING_EMAIL}', '{ORDER_BILLING_FIRST_NAME} {ORDER_BILLING_LAST_NAME}', '<p>Your order was received </p>\r\n<p>{ORDER_DATA}</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(26, 'shop_order_admin_refunded', 1, 'Your order was refunded', 'no-reply@yoursite.web', 'Autoresponder', '{ORDER_BILLING_EMAIL}', '{ORDER_BILLING_FIRST_NAME} {ORDER_BILLING_LAST_NAME}', '<p>Your order was refunded</p>\r\n<p>{ORDER_DATA}</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(27, 'shop_order_admin_canceled', 1, 'Your order was canceled', 'no-reply@yoursite.web', 'Autoresponder', '{ORDER_BILLING_EMAIL}', '{ORDER_BILLING_FIRST_NAME} {ORDER_BILLING_LAST_NAME}', '<p>Your order was canceled</p>\r\n<p>{ORDER_DATA}</p>\r\n<p></p>\r\n<p>{ORDER_NOTE}</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(28, 'shop_order_admin_shipped', 1, 'Your order was shipped and you should receive it shortly', 'no-reply@yoursite.web', 'Autoresponder', '{ORDER_BILLING_EMAIL}', '{ORDER_BILLING_FIRST_NAME} {ORDER_BILLING_LAST_NAME}', '<p>Your order was shipped</p>\r\n<p>{ORDER_DATA}</p>');
INSERT INTO `site_oxymall_plugin_mail_emails` (`email_id`, `email_code`, `email_status`, `email_subject`, `email_from`, `email_from_name`, `email_to`, `email_to_name`, `email_body`) VALUES(29, 'account_suspended', 1, 'Your account was suspended', 'no-reply@yoursite.web', 'Account', '{USER_EMAIL}', '{USER_FIRST_NAME} {USER_LAST_NAME}', '<p>Dear {USER_FIRST_NAME},</p>\r\n<p>Your account was suspended please contact us at +01-555-OURSITE</p>\r\n<p>user: {USER_EMAIL}</p>');

DROP TABLE IF EXISTS `site_oxymall_plugin_mail_queue`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_mail_queue` (
  `mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_date` int(11) NOT NULL,
  `mail_date_sent` int(11) NOT NULL,
  `mail_from_name` varchar(255) NOT NULL,
  `mail_from_email` varchar(255) NOT NULL,
  `mail_to_name` varchar(255) NOT NULL,
  `mail_to_email` varchar(255) NOT NULL,
  `mail_subject` varchar(255) NOT NULL,
  `mail_body` text NOT NULL,
  `mail_type` varchar(4) NOT NULL,
  `mail_status` int(1) NOT NULL,
  `mail_priority` int(1) NOT NULL,
  PRIMARY KEY (`mail_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_newsletters_history`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_newsletters_history` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `history_name` varchar(255) NOT NULL,
  `history_email` varchar(255) NOT NULL,
  `history_newsletter` int(11) NOT NULL,
  `history_date` int(11) NOT NULL,
  `history_status` int(1) NOT NULL,
  PRIMARY KEY (`history_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_newsletters_items`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_newsletters_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_date` int(11) NOT NULL,
  `item_status` int(1) NOT NULL,
  `item_title` varchar(255) NOT NULL,
  `item_from_email` varchar(255) NOT NULL,
  `item_from_name` varchar(255) NOT NULL,
  `item_body` text NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_newsletters_subscribers`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_newsletters_subscribers` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `item_email` varchar(255) NOT NULL,
  `item_date` int(11) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_news_items`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_news_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_date` int(11) DEFAULT NULL,
  `item_order` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `item_title` varchar(255) DEFAULT NULL,
  `item_url` varchar(255) DEFAULT NULL,
  `item_urltitle` varchar(255) DEFAULT NULL,
  `item_brief` text NOT NULL,
  `item_body` text,
  `item_main_title` varchar(255) NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_desc` text NOT NULL,
  `seo_keys` text NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `site_oxymall_plugin_portfolio_cats`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_portfolio_cats` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_order` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `cat_title` varchar(255) DEFAULT NULL,
  `cat_subtitle` varchar(255) NOT NULL,
  `cat_url` varchar(255) DEFAULT NULL,
  `cat_urltitle` varchar(255) DEFAULT NULL,
  `cat_content_title` varchar(255) DEFAULT NULL,
  `cat_image` int(11) DEFAULT NULL,
  `cat_image_file` varchar(255) DEFAULT NULL,
  `cat_description` text,
  `seo_title` text NOT NULL,
  `seo_keys` text NOT NULL,
  `seo_desc` text NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `site_oxymall_plugin_portfolio_items`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_portfolio_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_order` int(11) DEFAULT NULL,
  `item_project` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `item_title` varchar(255) NOT NULL,
  `item_url` varchar(255) NOT NULL,
  `item_urltitle` varchar(255) NOT NULL,
  `item_type` int(1) NOT NULL,
  `item_tn` int(1) NOT NULL,
  `item_tn_file` varchar(255) NOT NULL,
  `item_image` int(1) NOT NULL,
  `item_imag_file` varchar(255) NOT NULL,
  `item_popup_title` varchar(255) NOT NULL,
  `item_video` int(1) NOT NULL,
  `item_video_file` varchar(255) NOT NULL,
  `item_audio` int(1) NOT NULL,
  `item_audio_file` varchar(255) NOT NULL,
  `item_audio_image` int(1) NOT NULL,
  `item_audio_image_file` varchar(255) NOT NULL,
  `item_youtube` text NOT NULL,
  `item_description` text NOT NULL,
  `item_link` varchar(255) NOT NULL,
  `item_target` varchar(20) NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_desc` text NOT NULL,
  `seo_keys` text NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_portfolio_projects`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_portfolio_projects` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_order` int(11) DEFAULT NULL,
  `project_date` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `project_cat` int(11) DEFAULT NULL,
  `project_title` varchar(255) DEFAULT NULL,
  `project_subtitle` varchar(255) NOT NULL,
  `project_url` varchar(255) DEFAULT NULL,
  `project_url_title` varchar(255) DEFAULT NULL,
  `project_tooltip` varchar(255) NOT NULL,
  `project_description` text,
  `project_image` int(1) DEFAULT NULL,
  `project_image_file` varchar(255) DEFAULT NULL,
  `project_link` varchar(255) NOT NULL,
  `project_target` varchar(20) NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_desc` varchar(255) NOT NULL,
  `seo_keys` varchar(255) NOT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=MyISAM  ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `site_oxymall_plugin_services_cats`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_services_cats` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_order` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `cat_title` varchar(255) DEFAULT NULL,
  `cat_subtitle` varchar(255) NOT NULL,
  `cat_url` varchar(255) DEFAULT NULL,
  `cat_urltitle` varchar(255) DEFAULT NULL,
  `cat_content_title` varchar(255) DEFAULT NULL,
  `cat_description` text,
  `cat_link` varchar(255) NOT NULL,
  `cat_target` varchar(20) NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_desc` text NOT NULL,
  `seo_keys` text NOT NULL,
  `set_togglethumbviewer` int(1) NOT NULL,
  `set_switchthumbviewerposwithdescription` int(1) NOT NULL,
  `set_thumbwidth` int(11) NOT NULL,
  `set_thumbheight` int(11) NOT NULL,
  `set_horizontalno` int(11) NOT NULL,
  `set_verticalno` int(11) NOT NULL,
  `set_horizontaldistance` int(11) NOT NULL,
  `set_verticaldistance` int(11) NOT NULL,
  `set_maskanimationtime` float NOT NULL,
  `set_maskanimationdelay` float NOT NULL,
  `set_maskanimationtype` varchar(20) NOT NULL,
  `set_navanimationtime` float NOT NULL,
  `set_navanimationdelay` float NOT NULL,
  `set_navanimationtype` varchar(20) NOT NULL,
  `set_navanimationcolumnjumpvalue` float NOT NULL,
  `set_navscrollinganimationtime` float NOT NULL,
  `set_navscrollinganimationtype` varchar(20) NOT NULL,
  `set_toggleproportionalresizeonthumb` int(1) NOT NULL,
  `set_onrolloverresizewithpercent` float NOT NULL,
  `set_descriptionheight` int(11) NOT NULL,
  `set_textscrollingspeed` int(11) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_services_items`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_services_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_order` int(11) DEFAULT NULL,
  `item_cat` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `item_image` int(11) DEFAULT NULL,
  `item_image_file` varchar(255) DEFAULT NULL,
  `item_title` varchar(255) DEFAULT NULL,
  `item_url` varchar(255) DEFAULT NULL,
  `item_target` varchar(20) NOT NULL,
  `item_urltitle` varchar(255) DEFAULT NULL,
  `item_description` text,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `site_oxymall_plugin_sharing`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_sharing` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_order` int(11) NOT NULL,
  `item_title` varchar(255) NOT NULL,
  `item_description` varchar(255) NOT NULL,
  `item_icon` int(11) NOT NULL,
  `item_icon_file` varchar(255) NOT NULL,
  `item_type` int(1) NOT NULL,
  `item_url` varchar(255) NOT NULL,
  `item_target` varchar(20) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=3 ;

INSERT INTO `site_oxymall_plugin_sharing` (`item_id`, `item_order`, `item_title`, `item_description`, `item_icon`, `item_icon_file`, `item_type`, `item_url`, `item_target`) VALUES(1, 1, 'Facebook', 'Facebook', 1, '3.png', 1, 'http://www.facebook.com/oxylusflash', '');
INSERT INTO `site_oxymall_plugin_sharing` (`item_id`, `item_order`, `item_title`, `item_description`, `item_icon`, `item_icon_file`, `item_type`, `item_url`, `item_target`) VALUES(2, 2, 'Follow us on Twitter', 'Follow us on Twitter', 1, '2.png', 1, 'http://www.twitter.com/oxylusflash', '');


DROP TABLE IF EXISTS `site_oxymall_plugin_shop_accounts`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_shop_accounts` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_order` int(11) NOT NULL,
  `item_code` varchar(50) NOT NULL,
  `item_title` varchar(255) NOT NULL,
  `item_order_description` varchar(255) NOT NULL,
  `item_order_preffix` varchar(3) NOT NULL,
  `item_status` int(1) NOT NULL,
  `item_account` varchar(100) NOT NULL,
  `item_password` varchar(100) NOT NULL,
  `item_gatewayid` varchar(100) NOT NULL,
  `item_demo` int(1) NOT NULL,
  `item_description` text NOT NULL,
  `item_redirect` text NOT NULL,
  `item_buttoncaption` varchar(50) NOT NULL,
  `item_script` varchar(255) NOT NULL,
  `item_type` int(1) NOT NULL,
  `item_card` int(1) NOT NULL,
  `item_system` int(1) NOT NULL,
  `item_page_ok` varchar(255) NOT NULL,
  `item_page_error` varchar(255) NOT NULL,
  `item_clear` varchar(5) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=4 ;

INSERT INTO `site_oxymall_plugin_shop_accounts` (`item_id`, `item_order`, `item_code`, `item_title`, `item_order_description`, `item_order_preffix`, `item_status`, `item_account`, `item_password`, `item_gatewayid`, `item_demo`, `item_description`, `item_redirect`, `item_buttoncaption`, `item_script`, `item_type`, `item_card`, `item_system`, `item_page_ok`, `item_page_error`, `item_clear`) VALUES(1, 1, 'paypal', 'Paypal', 'Your order on WebSite', 'PP', 1, 'email@yoursite.web', '', '', 0, 'In order to pay with Paypal please click on the button below and you will be taken to Paypal to complete the transaction.', '<p>You are now beeing redirected to Paypal site to finalize the payment. </p>\r\n<p>Please note: PayPal payments can take a few minutes to an hour to process, if your payment doesn\\''t show up imediately please be patient.</p>\r\n<p>Please take notice if you pay with echeck it takes 3-5 business days until it clears and the products will be delivered to you.</p>', 'Pay Now', 'ajax.checkout-paypal.php', 1, 0, 1, '19', '30', 'true');
INSERT INTO `site_oxymall_plugin_shop_accounts` (`item_id`, `item_order`, `item_code`, `item_title`, `item_order_description`, `item_order_preffix`, `item_status`, `item_account`, `item_password`, `item_gatewayid`, `item_demo`, `item_description`, `item_redirect`, `item_buttoncaption`, `item_script`, `item_type`, `item_card`, `item_system`, `item_page_ok`, `item_page_error`, `item_clear`) VALUES(2, 3, 'offline', 'Offline', '', 'OF', 1, '---', '', '', 1, 'Offline', '', 'Send Cart', 'ajax.checkout-offline.php', 0, 0, 1, '29', '30', 'true');
INSERT INTO `site_oxymall_plugin_shop_accounts` (`item_id`, `item_order`, `item_code`, `item_title`, `item_order_description`, `item_order_preffix`, `item_status`, `item_account`, `item_password`, `item_gatewayid`, `item_demo`, `item_description`, `item_redirect`, `item_buttoncaption`, `item_script`, `item_type`, `item_card`, `item_system`, `item_page_ok`, `item_page_error`, `item_clear`) VALUES(3, 2, 'authorize', 'Authorize.net', 'Your order on WebSite', 'AU', 1, '__your_authorize.net_account__', '', '__your_authorize.net_gatewayID__', 1, 'Credit card', '', 'Finalize Order', 'ajax.checkout-authorize.php', 0, 1, 1, '31', '', 'true');

DROP TABLE IF EXISTS `site_oxymall_plugin_shop_cart`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_shop_cart` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_order` int(11) NOT NULL,
  `item_date` int(11) NOT NULL,
  `item_product` varchar(255) NOT NULL,
  `item_product_sku` varchar(50) NOT NULL,
  `item_product_id` int(11) NOT NULL,
  `item_options` varchar(255) NOT NULL,
  `item_price` float NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `item_total` float NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_shop_cats`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_shop_cats` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_order` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `cat_title` varchar(255) DEFAULT NULL,
  `cat_subtitle` varchar(255) NOT NULL,
  `cat_url` varchar(255) DEFAULT NULL,
  `cat_urltitle` varchar(255) DEFAULT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_desc` text NOT NULL,
  `seo_keys` text NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `site_oxymall_plugin_shop_countries`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_shop_countries` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_title` varchar(255) NOT NULL,
  `item_iso` varchar(3) NOT NULL,
  `item_states` text NOT NULL,
  `item_status` int(11) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=244 ;

INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(1, 'Afghanistan', 'AF', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(2, 'Albania', 'AL', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(3, 'Algeria', 'DZ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(4, 'American Samoa', 'AS', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(5, 'Andorra', 'AD', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(6, 'Angola', 'AO', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(7, 'Antartica', 'AQ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(8, 'Antiqua and Barbuda', 'AG', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(9, 'Armenia', 'AM', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(10, 'Argentina', 'AR', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(11, 'Australia', 'AU', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(12, 'Austria', 'AT', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(13, 'Azerbaijan', 'AZ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(14, 'Bahamas, The', 'BS', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(15, 'Bahrain', 'BH', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(16, 'Bangladesh', 'BD', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(17, 'Barbados', 'BB', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(18, 'Belarus', 'BY', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(19, 'Belgium', 'BE', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(20, 'Belize', 'BZ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(21, 'Benin', 'BJ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(22, 'Bermuda', 'BM', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(23, 'Bhutan', 'BT', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(24, 'Bolivia', 'BO', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(25, 'Botswana', 'BW', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(26, 'Bouvet Island', 'BV', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(27, 'Brazil', 'BR', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(28, 'British Antartic Territory', 'BQ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(29, 'British Indian Ocean Territory', 'IO', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(30, 'British Solomon Islands', 'SB', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(31, 'British Virgin Islands', 'VG', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(32, 'Brunei', 'BN', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(33, 'Bulgaria', 'BG', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(34, 'Myanmar (formerly Burma)', 'MM', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(35, 'Burundi', 'BI', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(36, 'Khmer Republic', 'KH', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(37, 'Cameroon', 'CM', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(38, 'Canada', 'CA', 'Alberta\r\nBritish\r\nManitoba\r\nNew Brunswick\r\nNewfoundland\r\nNorthwest Territories\r\nNova Scotia\r\nNunavut\r\nOntario\r\nPrince Edward Island\r\nQuebec\r\nSaskatchewan\r\nYukon', 1);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(39, 'Canton and Enderbury Islands', 'CT', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(40, 'Cape Verde Islands', 'CV', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(41, 'Cayman Islands', 'KY', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(42, 'Central African Republic', 'CF', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(43, 'Chad', 'TD', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(44, 'Chile', 'CL', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(45, 'China, Peoples Republic of', 'CN', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(46, 'Christmas Island', 'CX', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(47, 'Cocos (Keeling) Islands', 'CC', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(48, 'Colombia', 'CO', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(49, 'Comoro Islands', 'KM', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(50, 'Congo', 'CG', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(51, 'Cook Islands', 'CK', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(52, 'Costa Rica', 'CR', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(53, 'Croatia', 'HR', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(54, 'Cuba', 'CU', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(55, 'Cyprus', 'CY', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(56, 'Czech Republic', 'CZ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(57, 'Dahomey', 'DY', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(58, 'Denmark', 'DK', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(59, 'Djibouti', 'DJ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(60, 'Dominica', 'DM', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(61, 'Dominican Republic', 'DO', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(62, 'Dronning Maud Land', 'NQ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(63, 'Ecuador', 'EC', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(64, 'Egypt', 'EG', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(65, 'El Salvador', 'SV', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(66, 'Equitorial Guinea', 'GQ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(67, 'Eritrea', 'ER', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(68, 'Estonia', 'EE', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(69, 'Ethiopia', 'ET', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(70, 'Faeroe Islands', 'FO', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(71, 'Falkland Islands (Malvinas)', 'FK', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(72, 'Fiji', 'FJ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(73, 'Finland', 'FI', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(74, 'France', 'FR', '', 1);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(75, 'French Guiana', 'GF', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(76, 'French Polynesia', 'PF', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(77, 'French South and Antartic Territory', 'FQ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(78, 'French Afars and Issas', 'AI', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(79, 'Gabon', 'GA', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(80, 'Gambia', 'GM', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(81, 'Georgia', 'GE', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(82, 'Germany', 'DE', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(83, 'Ghana', 'GH', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(84, 'Gibraltar', 'GI', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(85, 'Greece', 'GR', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(86, 'Greenland', 'GL', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(87, 'Grenada', 'GD', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(88, 'Guadeloupe', 'GP', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(89, 'Guam', 'GU', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(90, 'Guatemala', 'GT', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(91, 'Guinea', 'GN', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(92, 'Guinea Bissaw', 'GW', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(93, 'Guyana', 'GY', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(94, 'Haiti', 'HT', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(95, 'Heard and McDonald Islands', 'HM', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(96, 'Honduras', 'HN', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(97, 'Hong Kong', 'HK', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(98, 'Hungary', 'HU', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(99, 'Iceland', 'IS', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(100, 'India', 'IN', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(101, 'Indonesia', 'ID', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(102, 'Iran', 'IR', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(103, 'Iraq', 'IQ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(104, 'Ireland', 'IE', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(105, 'Israel', 'IL', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(106, 'Italy', 'IT', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(107, 'Ivory Coast', 'CI', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(108, 'Jamaica', 'JM', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(109, 'Japan', 'JP', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(110, 'Johnston Island', 'JT', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(111, 'Jordan', 'JO', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(112, 'Kazakhstan', 'KZ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(113, 'Kenya', 'KE', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(114, 'Korea, Democratic Peoples Republic of', 'KP', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(115, 'Korea, Republic of', 'KR', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(116, 'Kuwait', 'KW', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(117, 'Kyrgystan', 'KG', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(118, 'Laos', 'LA', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(119, 'Latvia', 'LV', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(120, 'Lebanon', 'LB', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(121, 'Lesotho', 'LS', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(122, 'Liberia', 'LR', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(123, 'Libya', 'LY', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(124, 'Liechtenstein', 'LI', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(125, 'Lithuania', 'LT', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(126, 'Luxembourg', 'LU', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(127, 'Macao', 'MO', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(128, 'Madagascar', 'MG', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(129, 'Malawi', 'MW', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(130, 'Malaysia', 'MY', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(131, 'Maldives', 'MV', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(132, 'Mali', 'ML', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(133, 'Malta', 'MT', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(134, 'Marshall Islands', 'MH', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(135, 'Martinique', 'MQ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(136, 'Mauritania', 'MR', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(137, 'Mauritius', 'MU', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(138, 'Mexico', 'MX', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(139, 'Micronesia', 'FM', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(140, 'Midway Islands', 'MI', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(141, 'Moldova', 'MD', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(142, 'Monaco', 'MC', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(143, 'Mongolia', 'MN', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(144, 'Montserrat', 'MS', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(145, 'Morocco', 'MA', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(146, 'Mozambique', 'MZ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(147, 'Namibia', 'NA', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(148, 'Nauru', 'NR', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(149, 'Nepal', 'NP', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(150, 'Netherlands', 'NL', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(151, 'Netherlands Antilles', 'AN', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(152, 'Neutral Zone', 'NT', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(153, 'New Caledonia', 'NC', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(154, 'New Hebrides', 'NH', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(155, 'New Zealand', 'NZ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(156, 'Nicaragua', 'NI', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(157, 'Niger', 'NE', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(158, 'Nigeria', 'NG', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(159, 'Niue Island', 'NU', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(160, 'Norfolk Island', 'NF', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(161, 'Norway', 'NO', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(162, 'Oman', 'OM', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(163, 'Pacific Island Trust Territory', 'PC', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(164, 'Pakistan', 'PK', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(165, 'Palau', 'PW', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(166, 'Panama', 'PA', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(167, 'Panama Canal Zone', 'PZ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(168, 'Papua New Guinea', 'PG', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(169, 'Paraguay', 'PY', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(170, 'Peru', 'PE', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(171, 'Philippines', 'PH', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(172, 'Pitcairn Islands', 'PN', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(173, 'Poland', 'PL', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(174, 'Portugal', 'PT', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(175, 'Portuguese Timor', 'TP', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(176, 'Puerto Rico', 'PR', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(177, 'Qatar', 'QA', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(178, 'Reunion Island', 'RE', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(179, 'Romania', 'RO', 'Alba\r\nArad\r\nArges\r\nBacau\r\nBihor\r\nBistrita-Nasaud\r\nBotosani\r\nBraila\r\nBrasov\r\nBucuresti\r\nBuzau\r\nCalarasi\r\nCaras Severin\r\nCluj\r\nConstanta\r\nCovasna\r\nDambovita\r\nDolj\r\nGalati\r\nGiurgiu\r\nGorj\r\nHarghita\r\nHunedoara\r\nIalomita\r\nIasi\r\nIlfov\r\nMaramures\r\nMehedinti\r\nMures\r\nNeamt\r\nOlt\r\nPrahova\r\nSalaj\r\nSatu Mare\r\nSibiu\r\nSuceava\r\nTeleorman\r\nTimis\r\nTulcea\r\nValcea\r\nVaslui\r\nVrancea', 1);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(180, 'Russia', 'RU', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(181, 'Rwanda', 'RW', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(182, 'St. Helena', 'SH', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(183, 'St. Kitts-Nevis-Anguilla', 'KN', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(184, 'St. Lucia', 'LC', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(185, 'St. Pierre and Miquelon', 'PM', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(186, 'St. Vincent', 'VC', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(187, 'San Marino', 'SM', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(188, 'Sao Tome and Principe', 'ST', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(189, 'Saudi Arabia', 'SA', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(190, 'Senegal', 'SN', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(191, 'Seychelles', 'SC', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(192, 'Sierra Leone', 'SL', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(193, 'Singapore', 'SG', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(194, 'Slovakia', 'SK', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(195, 'Slovenia', 'SI', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(196, 'Somalia', 'SO', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(197, 'South Africa, Republic of', 'ZA', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(198, 'Spain', 'ES', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(199, 'Spanish Sahara', 'EH', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(200, 'Sri Lanka', 'LK', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(201, 'Sudan', 'SD', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(202, 'Suriname', 'SR', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(203, 'Svalbard and Jan Mayen Islands', 'SJ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(204, 'Swaziland', 'SZ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(205, 'Sweden', 'SE', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(206, 'Switzerland', 'CH', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(207, 'Syria', 'SY', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(208, 'Taiwan', 'TW', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(209, 'Tajikistan', 'TJ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(210, 'Tanzania', 'TZ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(211, 'Thailand', 'TH', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(212, 'Togo', 'TG', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(213, 'Tokelau Island', 'TK', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(214, 'Tonga', 'TO', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(215, 'Trinidad and Tobago', 'TT', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(216, 'Tunisia', 'TN', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(217, 'Turkey', 'TR', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(218, 'Turkmenistan', 'TM', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(219, 'Turks and Caicos Islands', 'TC', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(220, 'Tuvalu', 'TV', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(221, 'Uganda', 'UG', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(222, 'Ukraine', 'UA', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(223, 'United Arab Emirates', 'AE', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(224, 'United Kingdom', 'GB', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(225, 'United States', 'US', 'Alabama\r\nAlaska\r\nArizona\r\nArkansas\r\nCalifornia\r\nColorado\r\nConnecticut\r\nDelaware\r\nDist. of Columbia\r\nFlorida\r\nGeorgia\r\nHawaii\r\nIdaho\r\nIllinois\r\nIndiana\r\nIowa\r\nKansas\r\nKentucky\r\nLouisiana\r\nMaine\r\nMaryland\r\nMassachusetts\r\nMichigan\r\nMinnesota\r\nMississippi\r\nMissouri\r\nMontana\r\nNebraska\r\nNevada\r\nNew Hampshire\r\nNew Jersey\r\nNew Mexico\r\nNew York\r\nNorth Carolina\r\nNorth Dakota\r\nOhio\r\nOklahoma\r\nOregon\r\nPennsylvania\r\nPuerto Rico\r\nRhode Island\r\nSouth Carolina\r\nSouth Dakota\r\nTennessee\r\nTexas\r\nUtah\r\nVermont\r\nVirginia\r\nWashington\r\nWest Virginia\r\nWisconsin\r\nWyoming', 1);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(226, 'U.S. Miscellaneous Pacific Islands', 'PU', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(227, 'U.S. Virgin Islands', 'VI', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(228, 'Upper Volta', 'HV', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(229, 'Uruguay', 'UY', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(230, 'Uzbekistan', 'UZ', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(231, 'Vanuatu', 'VU', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(232, 'Vatican City State (The Holy See)', 'VA', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(233, 'Venezuela', 'VE', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(234, 'Vietnam', 'VN', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(235, 'Wake Island', 'WK', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(236, 'Wallis and Futuna Islands', 'WF', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(237, 'Western Samoa', 'WS', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(238, 'Yemen', 'YE', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(239, 'Yemen, Democratic', 'YD', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(240, 'Yugoslavia', 'YU', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(241, 'Zaire', 'ZR', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(242, 'Zambia', 'ZM', '', 0);
INSERT INTO `site_oxymall_plugin_shop_countries` (`item_id`, `item_title`, `item_iso`, `item_states`, `item_status`) VALUES(243, 'Zimbabwe', 'ZW', '', 0);

DROP TABLE IF EXISTS `site_oxymall_plugin_shop_files`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_shop_files` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `item_parent` int(11) NOT NULL,
  `item_title` varchar(255) NOT NULL,
  `item_file` int(1) NOT NULL,
  `item_file_file` varchar(255) NOT NULL,
  `item_last_update` int(11) NOT NULL,
  `item_description` text NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_shop_files_history`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_shop_files_history` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_dl` int(3) NOT NULL,
  `file_order` varchar(32) NOT NULL,
  `file_file` int(11) NOT NULL,
  `file_date` int(11) NOT NULL,
  `file_ip` varchar(50) NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_shop_images`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_shop_images` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_order` int(11) DEFAULT NULL,
  `item_parent` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `item_title` varchar(255) NOT NULL,
  `item_url` varchar(255) NOT NULL,
  `item_urltitle` varchar(255) NOT NULL,
  `item_type` int(1) NOT NULL,
  `item_tn` int(1) NOT NULL,
  `item_tn_file` varchar(255) NOT NULL,
  `item_image` int(1) NOT NULL,
  `item_image_file` varchar(255) NOT NULL,
  `item_image_pan` int(1) NOT NULL,
  `item_popup_title` varchar(255) NOT NULL,
  `item_video` int(1) NOT NULL,
  `item_video_file` varchar(255) NOT NULL,
  `item_audio` int(1) NOT NULL,
  `item_audio_file` varchar(255) NOT NULL,
  `item_audio_image` int(1) NOT NULL,
  `item_audio_image_file` varchar(255) NOT NULL,
  `item_youtube` text NOT NULL,
  `item_description` text NOT NULL,
  `item_link` varchar(255) NOT NULL,
  `item_target` varchar(20) NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_desc` text NOT NULL,
  `seo_keys` text NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_shop_items`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_shop_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_date` int(11) NOT NULL,
  `item_order` int(11) DEFAULT NULL,
  `item_cat` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `item_status` int(1) NOT NULL,
  `item_sku` varchar(255) NOT NULL,
  `item_image` int(11) DEFAULT NULL,
  `item_image_file` varchar(255) DEFAULT NULL,
  `item_image_large` int(1) NOT NULL,
  `item_image_large_file` varchar(250) NOT NULL,
  `item_title` varchar(255) DEFAULT NULL,
  `item_url` varchar(255) DEFAULT NULL,
  `item_urltitle` varchar(255) DEFAULT NULL,
  `item_description` text,
  `item_details` text NOT NULL,
  `item_specs` text NOT NULL,
  `item_price` float NOT NULL,
  `item_new` int(1) NOT NULL,
  `item_sales` int(11) NOT NULL,
  `item_set_cart` int(1) NOT NULL,
  `item_tags` varchar(255) NOT NULL,
  `item_shipping` int(1) NOT NULL,
  `item_set_details` int(1) NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_desc` text NOT NULL,
  `seo_keys` text NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `site_oxymall_plugin_shop_log_paypal`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_shop_log_paypal` (
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_date` int(11) NOT NULL,
  `mc_gross` int(11) NOT NULL,
  `protection_eligibility` int(11) NOT NULL,
  `address_name` varchar(255) NOT NULL,
  `address_status` varchar(50) NOT NULL,
  `address_street` varchar(200) NOT NULL,
  `address_country` varchar(200) NOT NULL,
  `address_country_code` varchar(5) NOT NULL,
  `address_state` varchar(255) NOT NULL,
  `address_city` varchar(200) NOT NULL,
  `payer_id` varchar(32) NOT NULL,
  `tax` float NOT NULL,
  `payment_date` varchar(50) NOT NULL,
  `payment_status` varchar(30) NOT NULL,
  `charset` varchar(20) NOT NULL,
  `address_zip` varchar(255) NOT NULL,
  `mc_shipping` float NOT NULL,
  `mc_handling` float NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `mc_fee` float NOT NULL,
  `notify_version` varchar(10) NOT NULL,
  `custom` varchar(32) NOT NULL,
  `payer_status` varchar(30) NOT NULL,
  `business` varchar(255) NOT NULL,
  `verify_sign` varchar(255) NOT NULL,
  `payer_email` varchar(255) NOT NULL,
  `txn_id` varchar(32) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `payer_business_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `receiver_email` varchar(255) NOT NULL,
  `item_number` varchar(10) NOT NULL,
  `payment_fee` float NOT NULL,
  `quantity` int(1) NOT NULL,
  `receiver_id` varchar(32) NOT NULL,
  `txn_type` varchar(10) NOT NULL,
  `mc_currency` varchar(3) NOT NULL,
  `residence_country` varchar(5) NOT NULL,
  `transaction_subject` varchar(200) NOT NULL,
  `payment_gross` float NOT NULL,
  `ipn_track_id` varchar(50) NOT NULL,
  `handling_amount` float NOT NULL,
  `shipping` float NOT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_shop_orders`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_shop_orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_status` int(1) NOT NULL,
  `order_date` int(11) NOT NULL,
  `order_user` int(11) NOT NULL,
  `order_price_subtotal` float NOT NULL,
  `order_price_discount` float NOT NULL,
  `order_price_shipping` float NOT NULL,
  `order_price_tax` float NOT NULL,
  `order_price_total` float NOT NULL,
  `order_products` int(4) NOT NULL,
  `order_code` varchar(35) NOT NULL,
  `order_price_currency` varchar(3) NOT NULL,
  `order_shipping_method` int(3) NOT NULL,
  `order_shipping_method_name` varchar(255) NOT NULL,
  `order_payment_method` int(3) NOT NULL,
  `order_payment_method_name` varchar(255) NOT NULL,
  `order_billing_first_name` varchar(100) NOT NULL,
  `order_billing_last_name` varchar(100) NOT NULL,
  `order_billing_address_1` varchar(100) NOT NULL,
  `order_billing_address_2` varchar(100) NOT NULL,
  `order_billing_city` varchar(100) NOT NULL,
  `order_billing_state` varchar(100) NOT NULL,
  `order_billing_zip` varchar(100) NOT NULL,
  `order_billing_country` varchar(100) NOT NULL,
  `order_billing_phone` varchar(100) NOT NULL,
  `order_billing_email` varchar(100) NOT NULL,
  `order_shipping_first_name` varchar(100) NOT NULL,
  `order_shipping_last_name` varchar(100) NOT NULL,
  `order_shipping_address_1` varchar(100) NOT NULL,
  `order_shipping_address_2` varchar(100) NOT NULL,
  `order_shipping_city` varchar(100) NOT NULL,
  `order_shipping_state` varchar(100) NOT NULL,
  `order_shipping_zip` varchar(100) NOT NULL,
  `order_shipping_country` varchar(100) NOT NULL,
  `order_shipping_phone` varchar(100) NOT NULL,
  `order_trans_id` varchar(255) NOT NULL,
  `order_payment_date` int(11) NOT NULL,
  `order_note` text NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_shop_questions`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_shop_questions` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_parent` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `item_date` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_phone` varchar(50) NOT NULL,
  `item_email` varchar(255) NOT NULL,
  `item_subject` varchar(255) NOT NULL,
  `item_question` text NOT NULL,
  `item_answer` text NOT NULL,
  `item_status` int(1) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `item_parent` (`item_parent`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_shop_reviews`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_shop_reviews` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `item_parent` int(11) NOT NULL,
  `item_date` int(11) NOT NULL,
  `item_status` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_email` varchar(255) NOT NULL,
  `item_text` text NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_shop_shipping`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_shop_shipping` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_title` varchar(255) NOT NULL,
  `item_duration` varchar(50) NOT NULL,
  `item_price` float NOT NULL,
  `item_status` int(1) NOT NULL,
  `item_intl` int(1) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=3 ;

INSERT INTO `site_oxymall_plugin_shop_shipping` (`item_id`, `item_title`, `item_duration`, `item_price`, `item_status`, `item_intl`) VALUES(1, 'Domestic Shipping', '5 days', 0, 1, 0);
INSERT INTO `site_oxymall_plugin_shop_shipping` (`item_id`, `item_title`, `item_duration`, `item_price`, `item_status`, `item_intl`) VALUES(2, 'International Shipping', '14 days', 0, 1, 1);

DROP TABLE IF EXISTS `site_oxymall_plugin_shop_variations`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_shop_variations` (
  `module_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_order` int(11) NOT NULL,
  `item_parent` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_options` text NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `site_oxymall_plugin_team_cats`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_team_cats` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_order` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `cat_title` varchar(255) DEFAULT NULL,
  `cat_subtitle` varchar(255) NOT NULL,
  `cat_url` varchar(255) DEFAULT NULL,
  `cat_content_title` varchar(255) DEFAULT NULL,
  `cat_description` text,
  `seo_title` varchar(255) NOT NULL,
  `seo_desc` text NOT NULL,
  `seo_keys` text NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `site_oxymall_plugin_team_items`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_team_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_order` int(11) DEFAULT NULL,
  `item_cat` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `item_image` int(11) DEFAULT NULL,
  `item_image_file` varchar(255) DEFAULT NULL,
  `item_large` int(1) NOT NULL,
  `item_large_file` varchar(255) NOT NULL,
  `item_title` varchar(255) DEFAULT NULL,
  `item_subtitle` varchar(255) NOT NULL,
  `item_url` varchar(255) DEFAULT NULL,
  `item_target` varchar(20) NOT NULL,
  `item_urltitle` varchar(255) DEFAULT NULL,
  `item_description` text,
  `item_email` varchar(255) NOT NULL,
  `item_phone` varchar(50) NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_desc` varchar(255) NOT NULL,
  `seo_keys` varchar(255) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `site_oxymall_plugin_users`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_fbid` int(11) NOT NULL,
  `user_date` int(11) NOT NULL,
  `user_key` varchar(32) NOT NULL,
  `user_reserved` int(1) NOT NULL,
  `user_key_code` varchar(32) NOT NULL,
  `user_key_date` varchar(32) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_login` varchar(50) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_email_original` varchar(255) NOT NULL,
  `user_status` int(1) NOT NULL,
  `user_first_name` varchar(100) NOT NULL,
  `user_last_name` varchar(100) NOT NULL,
  `user_groups` text NOT NULL,
  `user_register_ip` varchar(50) NOT NULL,
  `user_last_login` int(11) NOT NULL,
  `user_last_login_ip` varchar(50) NOT NULL,
  `user_shipping_first_name` varchar(50) NOT NULL,
  `user_shipping_last_name` varchar(50) NOT NULL,
  `user_shipping_address_1` varchar(200) NOT NULL,
  `user_shipping_address_2` varchar(200) NOT NULL,
  `user_shipping_city` varchar(50) NOT NULL,
  `user_shipping_state` varchar(50) NOT NULL,
  `user_shipping_zip` varchar(50) NOT NULL,
  `user_shipping_country` varchar(50) NOT NULL,
  `user_shipping_phone` varchar(50) NOT NULL,
  `user_shipping_email` varchar(50) NOT NULL,
  `user_billing_first_name` varchar(50) NOT NULL,
  `user_billing_last_name` varchar(50) NOT NULL,
  `user_billing_address_1` varchar(200) NOT NULL,
  `user_billing_address_2` varchar(200) NOT NULL,
  `user_billing_city` varchar(50) NOT NULL,
  `user_billing_state` varchar(50) NOT NULL,
  `user_billing_zip` varchar(50) NOT NULL,
  `user_billing_country` varchar(50) NOT NULL,
  `user_billing_phone` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=7 ;


DROP TABLE IF EXISTS `site_oxymall_plugin_users_access`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_users_access` (
  `access_id` int(11) NOT NULL AUTO_INCREMENT,
  `access_user` int(11) NOT NULL,
  `access_ip` varchar(50) NOT NULL,
  `access_last` int(11) NOT NULL,
  `access_times` int(11) NOT NULL,
  PRIMARY KEY (`access_id`),
  KEY `access_user` (`access_user`)
) ENGINE=MyISAM  AUTO_INCREMENT=7 ;

DROP TABLE IF EXISTS `site_oxymall_plugin_users_groups`;
CREATE TABLE IF NOT EXISTS `site_oxymall_plugin_users_groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL,
  `group_code` varchar(50) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=4 ;

INSERT INTO `site_oxymall_plugin_users_groups` (`group_id`, `group_name`, `group_code`) VALUES(1, 'Users', 'users');
INSERT INTO `site_oxymall_plugin_users_groups` (`group_id`, `group_name`, `group_code`) VALUES(3, 'Facebook', 'facebook');

DROP TABLE IF EXISTS `site_users`;
CREATE TABLE IF NOT EXISTS `site_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_key` varchar(32) DEFAULT NULL,
  `user_first_name` varchar(200) DEFAULT NULL,
  `user_last_name` varchar(200) DEFAULT NULL,
  `user_login` varchar(200) NOT NULL,
  `user_password` varchar(200) DEFAULT NULL,
  `user_email` varchar(200) DEFAULT NULL,
  `user_level` int(1) NOT NULL DEFAULT '1',
  `user_protect_delete` int(1) NOT NULL DEFAULT '0',
  `user_protect_edit` int(1) NOT NULL DEFAULT '0',
  `user_log_last_login` int(11) NOT NULL DEFAULT '0',
  `user_log_last_ip` varchar(200) DEFAULT NULL,
  `user_log_create` int(11) NOT NULL DEFAULT '0',
  `user_log_tries` int(2) NOT NULL DEFAULT '0',
  `user_log_image_text` varchar(50) DEFAULT NULL,
  `user_log_status` int(1) NOT NULL DEFAULT '0',
  `user_contact_phone` varchar(20) DEFAULT NULL,
  `user_contact_phone2` varchar(20) DEFAULT NULL,
  `user_contact_phone3` varchar(20) DEFAULT NULL,
  `user_contact_addr` text,
  `user_contact_city` varchar(50) DEFAULT NULL,
  `user_contact_state` varchar(100) DEFAULT NULL,
  `user_contact_zip` varchar(20) DEFAULT NULL,
  `user_contact_country` char(3) DEFAULT NULL,
  `user_perm` text NOT NULL,
  PRIMARY KEY (`user_id`),
  FULLTEXT KEY `user_login` (`user_login`)
) ENGINE=MyISAM  AUTO_INCREMENT=16 ;
