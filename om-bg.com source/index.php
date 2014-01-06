<?php
	define('MAX_PARAM', 20); /* sets maximum value of each of $_GET params to reasonable border */
	define('IMG_FOLDER', 'images/'); /* relative path for "IMAGES" folder */
	function checkparam($param) /*retrieves passed parameters via GET if any */
	{
		$result = intval((isset($_GET[$param]))?$_GET[$param]:'0');
		$result = (($result > 0) && ($result < MAX_PARAM)) ? $result : 0;
		return ($result) ;
	}
	function code_number($numb)
	{
		$salt = 'This+string+is+intended+to+carry+number+information';
		$media = md5($salt.ceil(time()/200));
		// $media is valid for at least 99 seconds
		$numbstr = strval($numb); // converts number to string
		$numint = floor(strlen($media)/strlen($numbstr)); // length of each piece for coding
		for ($i=0;$i<strlen($numbstr);$i++)
		{
			$pos = rand(0,$numint-1); // random place to put digit
			// 1 digit hex sum of original media digit and code digit at given position
			$val = hexdec($media[$i*$numint+$pos])+intval($numbstr[$i])+1; //add code to media digit
			// +1 resolves the problem with code digit 0 (media at this index must be different
			$val = dechex($val);
			$media[$i*$numint+$pos] = $val[strlen($val)-1]; //takes only last digit
		}
		return $media; 
	}
	function create_link($p,$s,$i,$l)
	/* each variable can be (-1)-> use default or (value)-> change */
	/* NOTE: if (value) is 0 it can be omited */
	{
		global $page, $subpage, $item, $lang;
		
		$lnk = '';
		if (($p==-1) && ($page)) $lnk .= "p=$page";
		elseif ($p>0) $lnk .= "p=$p";	
		
		if (($s==-1) && ($subpage)) $lnk .= (strlen($lnk)?"&":"")."s=$subpage";
		elseif ($s>0) $lnk .= (strlen($lnk)?"&":"")."s=$s";
		
		if (($i==-1) && ($item)) $lnk .= (strlen($lnk)?"&":"")."i=$item";
		elseif ($i>0) $lnk .= (strlen($lnk)?"&":"")."i=$i";
		
		if (($l==-1) && ($lang)) $lnk .= (strlen($lnk)?"&":"")."l=$lang";
		elseif ($l>0) $lnk .= (strlen($lnk)?"&":"")."l=$l";
		
		if (($p == 8) && ($s == 3) && ($page != 8)) // offer inquiry - add refferrer
			$lnk .= (strlen($lnk)?"&":"").sprintf ('ref=%02d%02d%02d', $page, $subpage, $item);
		
		$lnk = $_SERVER['SCRIPT_NAME'].(strlen($lnk)?"?":"").$lnk;
		print $lnk;
	}
	/* checking and setting Cookies */
	/* getting reasonable screen resolution of client's browser */
	$width = intval((isset($_COOKIE['wWidth']))?$_COOKIE['wWidth']:'1024');
	$width = ($width>479 && $width<4000)?$width:800;
	
/* SITE MAP START */
/* $sitemap [language] [menu level] [submenu level] [item level] */
	$sitemap[0] = array('Начало',
						array('За фирмата',
							/*submenu*/'ОМ',
							/*submenu*/array('Сервиз',
								/*items*/'Гаранционен','Извънгаранционен')),
						'Промоции',
						array('Продукти OM',
							/*submenu*/array('Електрокари',
								/*items*/'E8-10N','XE13-20/3ac','XE15-20ac','XE22-30ac','XE35-50','XE60-80'),
							/*submenu*/array('Мотокари',
								/*items*/'XD15-20','XD25-30','XD40-50','XD60-100'),
							/*submenu*/array('Газокари',
								/*items*/'XG15-20','XG25-30'),
							/*submenu*/array('Нископовдигачи',
								/*items*/'LC-T','TL16-20ac','TN22-30','TLX20','TSX20-30','TLR20','TSR20ac'),
							/*submenu*/array('Стакери',
								/*items*/'LC-S','CL10,5-12ac','CN14-20','CNS14-20','CTX14-20','IDEA','CLD20','CLR12','CSR12-16ac'),
							/*submenu*/array('Ричтраци',
								/*items*/'XR12-25ac','XRS14-20ac','XNA'),
							/*submenu*/array('Комисионери',
								/*items*/'XLOGO1-2ac','XOP07ac','XOP1','XOP2-3ac'),
							/*submenu*/array('Влекачи',
								/*items*/'CTR15-25','CTR60','CTR250','CPF200')),
						array ('Други продукти',
							/*submenu*/'Палетни колички','Ръчни повдигачи','Взривозащитени','Транспортьори','Втора употреба'),
						array ('Резервни части',
							/*submenu*/'Гуми','Рогове','Батерии','Зарядни устройства'),
						array ('Приспособления',
							/*submenu*/'Изравнители','Позиционери','Ротатори','Кламери', 'Ротиращи кламери','Кламери за роли'),
				  		array('За контакти',
							/*submenu*/'Местоположение','Обратна връзка',
							/*submenu*/array('Запитване оферта',
								/*items*/'Продукти','Приспособления'),
							/*submenu*/'Карта на сайта'),
						'Отмора');
	$sitemap[1] = array('Home',
						'Company',
						'News',
						array('Products ОМ',
							/*submenu*/array('Electric',
								/*items*/'E8-10N','XE13-20/3ac','XE15-20ac','XE22-30ac','XE35-50','XE60-80'),
							/*submenu*/array('Diesel',
								/*items*/'XD15-20','XD25-30','XD40-50','XD60-100'),
							/*submenu*/array('LPG',
								/*items*/'XG15-20','XG25-30'),
							/*submenu*/array('Pallet trucks',
								/*items*/'LC-T','TL16-20ac','TN22-30','TLX20','TSX20-30','TLR20','TSR20ac'),
							/*submenu*/array('Stackers',
								/*items*/'LC-S','CL10,5-12ac','CN14-20','CNS14-20','CTX14-20','IDEA','CLD20','CLR12','CSR12-16ac'),
							/*submenu*/array('Reach trucks',
								/*items*/'XR12-25ac','XRS14-20ac','XNA'),
							/*submenu*/array('Order pickers',
								/*items*/'XLOGO1-2ac','XOP07ac','XOP1','XOP2-3ac'),
							/*submenu*/array('Tractors',
								/*items*/'CTR15-25','CTR60','CTR250','CPF200')),
						array ('Other products',
							/*submenu*/'Handpallets','Manual stackers','Explosion-proof','Conveyors','Second hand trucks'),
						'Spare parts',
						'Attachments',
				  		array('Contacts',
							/*submenu*/'Location','Feed-back',array('Offer inquiry',
								/*items*/'Products','Attachments'),
							/*submenu*/'Sitemap'));
/* SITE MAP END, PRICES BEGIN */
	$price = array(0, 0, 0,
						array(0 /*'Продукти OM'*/,
							/*submenu*/array(0 /*'Електрокари'*/,
								/*items* E8-10N=*/0,/*XE13-20/3ac=*/0,/*XE15-20ac=*/0,
										/*XE22-30ac=*/0,/*XE35-50=*/0,/*XE60-80=*/80),
							/*submenu*/array(0 /*'Мотокари'*/,
								/*items XD15-20=*/0,/*XD25-30=*/0,/*XD40-50=*/0,
										/*XD60-100=*/0),
							/*submenu*/array(0 /*'Газокари'*/,
								/*items XG15-20=*/0,/*XG25-30=*/0),
							/*submenu*/array(0 /*'Нископовдигачи'*/,
								/*items LC-T=*/0,/*TL16-20ac=*/0,/*TN22-30=*/0,/*TLX20=*/0,
										/*TSX20-30=*/0,/*TLR20=*/0,/*TSR20ac=*/0),
							/*submenu*/array(0 /*'Стакери'*/,
								/*items LC-S=*/0,/*CL10,5-12ac=*/0,/*CN14-20=*/0,
										/*CNS14-20=*/0,/*CTX14-20=*/0,/*IDEA=*/0,
										/*CLD20=*/0,/*CLR12=*/0,/*CSR12-16ac=*/0),
							/*submenu*/array(0 /*'Ричтраци'*/,
								/*items XR12-25ac=*/0,/*XRS14-20ac=*/0,/*XNA=*/0),
							/*submenu*/array(0 /*'Комисионери'*/,
								/*items XLOGO1-2ac=*/0,/*XOP07ac=*/0,/*XOP1=*/0,/*XOP2-3ac=*/0),
							/*submenu*/array(0 /*'Влекачи'*/,
								/*items CTR15=*/0,/*CTR60=*/0,/*CTR250=*/0,/*CPF200=*/0)),
						array (0 /*'Други продукти'*/,
							/*submenu Палетни колички=*/380,/*Ръчни повдигачи=*/2440,
									/*Взривозащитени=*/0,/*Транспортьори=*/0,/*Втора употреба=*/0));

/* ALL GLOBAL TEXTS DEPENDING ON LANGUAGE */
/* $items [language] [text] */
	$items[0] = array('мотокари, електрокари, подемно-транспортна и складова техника',
						'Най-продавани продукти','&quot;Карли&quot; ЕООД', 
						'Всички права запазени','връзка с нас','Вход','Име:','Парола:',
						'Влез','Нов потребител','Страницата, която търсите не съществува!',
						'Вие се намирате тук', 'Изберете подкатегория:','Карта на сайта');
	$items[1] = array('forklift trucks and warehouse equipment','Best sell products',
						'CARLI Ltd.','All Rights reserved','Contact us','Logon','User:',
						'Pass:','Send','New User','Attempt to browse an unexisting page!',
						'You are here', 'Choose subcategory:','Sitemap');
/* ALL GLOBAL TEXTS END */

/* BEST SELL DROP-DOWN MENU DEPENDING ON LANGUAGE AND LINKS */
/* $bestsell [language] [item (text)] */
/* $bestsell_idx [item (index in $bestsell)] [item sitemap (p,s,i)] */
	$bestsell[0] = array('Транспалетни колички','Стакер &quot;OM&quot; LC-S',
							'Електрокар &quot;OM&quot; XE15/3ac');
	$bestsell[1] = array('Handpallet trucks','Stacker &quot;OM&quot; LC-S',
							'Electric truck &quot;OM&quot; XE15/3ac');
	$bestsell_idx = array(array('5','1','0'),array('4','5','1'),array('4','1','2'));
/* BEST SELL DROP-DOWN MENU END */

	/* check of $_GET variables */
	$page = checkparam("p");
	$subpage = checkparam("s");
	$item = checkparam("i");
	$lang = checkparam("l");
	if ($lang >= count($sitemap)) $lang=0; 
	/* if there is no such language - set default */
	if ($page > count($sitemap[$lang])) $page=0;
	/* if there is no such menu in selected language - set default */
	if (!$page || ($subpage >= count($sitemap[$lang][$page-1]))) $subpage=0;
	/* if there is no such submenu in selected language and menu - set default */
	if (!$page || !$subpage || ($item >= count($sitemap[$lang][$page-1][$subpage]))) $item=0;
	/* if there is no such item in selected language, menu and submenu - set default */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?PHP /* TITLE in different languages */
	if ($page <= 1) print '<title>ОМ '.$items[$lang][0].'</title>';
	else {
		print '<title>'.
			((is_array($sitemap[$lang][$page-1]))?$sitemap[$lang][$page-1][0]:$sitemap[$lang][$page-1]);
		if ($subpage) print ' - '.
			((is_array($sitemap[$lang][$page-1][$subpage])) ? 
				$sitemap[$lang][$page-1][$subpage][0] : 
				$sitemap[$lang][$page-1][$subpage]);
		if ($item) print ' - '.$sitemap[$lang][$page-1][$subpage][$item];
		print '</title>'; 
	}
?> 
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<meta name="description" content="CARLI SOFIA - <?PHP /* META DESCRIPTION in different languages */
	if ($page)
	{
		print ((is_array($sitemap[$lang][$page-1]))?$sitemap[$lang][$page-1][0]:$sitemap[$lang][$page-1]);
		if ($subpage) print ' '.
			((is_array($sitemap[$lang][$page-1][$subpage])) ? 
				$sitemap[$lang][$page-1][$subpage][0] : 
				$sitemap[$lang][$page-1][$subpage]);
		if ($item) print ' '.$sitemap[$lang][$page-1][$subpage][$item];
		print ', '.$items[$lang][0];
	} else if ($lang)
		print 'Selling and servicing of forklift trucks, warehouse equipment, spare parts';
		else print 'Търговия с мотокари, електрокари, подемно-транспортна и складова техника, резервни части, сервиз';	
?>" />
<meta name="keywords" content="мотокар, мотокари, електрокар, електрокари, газокар, газокари, повдигач, повдигачи, транспалетна, палетна, количка, резервни, части, кари, стакер, ричтрак, ретрак, високоповдигач, нископовдигач, ръчноводим, кар, forklift, fork, lift, truck, diesel, electric, hand, pallet, OM, spare, part, машини, подемник, производство, детайли" />
<meta name="robots" content="all" />
<meta name="revisit-after" content="7 days" />
<!-- <meta http-equiv="cache-control" content="no-cache" /> 
<meta http-equiv="Pragma" content="no-cache" /> -->
<meta http-equiv="content-language" content="en-us, bg" />
<meta name="author" content="Pavel Sotirov" />
<meta name="reply-to" content="info@om-bg.com" /> 
<meta name="Copyright" content="Carli EOOD © 2009 All rights reserved" />
<meta name="distribution" content="global" />
<meta name="googlebot" content="index, follow" />
<meta name="resource-type" content="document" />
<meta name="rating" content="general" />

<link rel="shortcut icon" href="paltruck.ico" />
<link rel="stylesheet" href="global.css" type="text/css" />
<style type="text/css">
<!--
div#container {	
	width: <?PHP print $width; ?>px; /* total width of the page */
}

div.page {
	width: <?PHP print $width-215; ?>px;
	/* width of the working field (page - 170px menu - 45px margins and paddings */ 
}
img#logo { /* left position of main logo */
<?PHP	
	/* calculating proper position of the main logo based on screen width */
	// 130/800 = 0.1625 - scale factor	- width of clickable area
	$logoW = 117; // total width of logo
	$logoH = 88; // total height of logo
	$areaW = ceil($width*0.1625);
	if ($areaW < $logoW) // if area is smaller that logo - resize logo
	{
		$logoH = ceil($logoH/$logoW*$areaW);
		$logoW = $areaW;
	}
	$logoL = ceil(($areaW-$logoW)/2+ $width*.00875); // half of rest area plus offset
	// 7/800 = 0.00875 - scale factor of left margin of the clickable area
	print 'left: '.$logoL.'px;';
?> 
}
img#trucks { /* left position of trucks picture */
<?PHP	
	$logoL = ($width > 700)?ceil(($width-320)/2):$areaW+10; // just after the main logo
	print 'left: '.$logoL.'px;';
?> 
}
-->
</style>
<script type="text/javascript" src="scripts.js"></script>
<script type="text/javascript" src="flowplayer-3.0.3.min.js"></script>
<!--<script type="text/javascript">-->
<!--
// -->
<!--</script>-->
</head>
<body onLoad="prepare_view()" onResize="setSize()" bgcolor="#FFFFFF" text="#000000">
<div id="container">
	<!-- HEADER SECTION - LOGO PLUS BEST SELL PRODUCTS -->
	<div id="header">
		<img src="images/img_ban_top.jpg" width="<?PHP print $width; ?>" height="99" usemap="#home_index">
  		<map name="home_index">
<?PHP /* setting clickable area in header */
	print '<area shape=rect coords="';
	// 7/800 = 0.00875 - scale factor
	print ceil($width*0.00875); //adjust left coord of the clickable area based on total width
	print ',5,';
	// 137/800 = 0.17125 - scale factor
	print ceil($width*0.17125);//adjusting right coordinate of the clickable area based on total width
	print ',95" href="';
	create_link(0,0,0,-1);
	print '"></map>';
	print '<a href="';
	create_link(0,0,0,-1);
	print '"><img id="logo" src="images/img_om_logo.gif" width="'.$logoW.'" height="'.$logoH.'"></a>';   
?>
		<img id="trucks" src="images/img_ban_top.gif" width="316" height="45">
		<ul class="lang_sel">
			<li><a class="sysfont" href="<?PHP create_link(-1,-1,-1,0);?>">
				<img src="images/img_flag_bg.gif" width="20" height="15">български</a></li>
			<li><a class="sysfont" href="<?PHP create_link(-1,-1,-1,1);?>">
				<img src="images/img_flag_en.gif" width="20" height="15">english</a></li>
		</ul>
		<form class="sysfont" id="best_sell" action="">
		<select name="GoMenu" onChange="OnGoMenuFormLink(this)">
<?PHP /* Building Best Sells drop-down menu */
	print '<option>'.$items[$lang][1].'</option>';
	for($idx=0;$idx<count($bestsell[$lang]);$idx++)
	{
		print '<option value="';
		create_link($bestsell_idx[$idx][0],$bestsell_idx[$idx][1],$bestsell_idx[$idx][2],-1);
		print '">'.$bestsell[$lang][$idx].'</option>';
	}
?>
		</select></form>
  </div>
	<!-- MAIN SECTION -->
	<div id="main">
		<!-- NAVIGATION BAR SECTION - BACKGROUNDS PLUS MENU BUTTONS -->
		<div id="menubar">
          <ul class="navigation" id="nav_bar">
<?PHP /* build menu navigation buttons */
	for($idx=1;$idx<(count($sitemap[$lang])+1);$idx++)
	{	
		$is_pidx = ($page===$idx);
		/* if index of the button is equal to currently selected page the following will happen:
			1. Button will have marking for position
			In that way this button will be only information for current browsing position */
		 
		print '<li '.(($is_pidx)?'class="curr_pos" ':'').'id="nav_button'.$idx.'"><a href="';
		create_link($idx,0,0,-1);
		print '">';
		if (is_array($sitemap[$lang][$idx-1])) print $sitemap[$lang][$idx-1][0];
		else print $sitemap[$lang][$idx-1];
		print '</a></li>';
		/* Puts each of menu texts, corresponding to language and position */
		/* creating subpages navigation menu */
		if ($is_pidx && (($splen=count($sitemap[$lang][$page-1]))>1))
		{
			print '<ul class="submenu">';
			for ($iidx=1;$iidx<$splen;$iidx++)
			{
				print '<li id="sub_button'.$iidx.'"><a href="';
				create_link(-1,$iidx, 0, -1);
				print '">'.(($iidx==$subpage)?'&loz; ':'');
				if (is_array($sitemap[$lang][$page-1][$iidx])) print $sitemap[$lang][$page-1][$iidx][0];
				else print $sitemap[$lang][$page-1][$iidx];
				print '</a></li>';
			}
			print '</ul>';
		}
	}				
?>
          </ul>
		<div class="sysfont" id="copyright">
			<?PHP print '<br />'.$items[$lang][2].'<br />Copyright &copy; 2009<br />'.$items[$lang][3].'<br /><br />'; ?>
		    <img src="images/envelope.gif"><a href="mailto:info@om-bg.com">
			<?PHP print $items[$lang][4].'</a><br /><br /><br /><img src="images/sitemap.gif"><a href="';
			create_link(8,4,0,-1);
			print '">'.$items[$lang][13].'</a>';
			?>
		</div>
		<?PHP /*<form class="sysfont" id="userid" action="" method="post" enctype="multipart/form-data">
		<fieldset><legend><?PHP print $items[$lang][5]; ?></legend>
			<label class="label" for="username"><?PHP print $items[$lang][6]; ?></label>
			<input class="mand" id="username" name="username" type="text" size="10" value=""/><br />
			<label class="label" for="password"><?PHP print $items[$lang][7]; ?></label>
			<input class="mand" id="password" name="password" type="password" size="10" value=""/><br />
			<label class="label" for="bt_submit">&nbsp;</label>
			<input type="submit" id="bt_submit" name="bt_submit" value="<?PHP print $items[$lang][8]; ?>" />
			<div class="clear"></div>
		</fieldset>
		<a href="<?PHP create_link(9,4,0,-1); print '">'.$items[$lang][9]; ?></a></form> */ ?>	
	 </div>
	 <div class="page">
<?PHP 
	if ($page>1)
	{
		print '<p>'.$items[$lang][11].': ';
		print '<a href="';
		create_link(0,0,0,-1);
		print '">'.$sitemap[$lang][0].'</a> >> <a href="';
		create_link($page,0,0,-1);
		print '">'.
			((is_array($sitemap[$lang][$page-1]))?$sitemap[$lang][$page-1][0]:$sitemap[$lang][$page-1]).
			'</a>';
		if ($subpage)
		{
			print ' >> <a href="';
			create_link($page,$subpage,0,-1);
			print '">'.
			((is_array($sitemap[$lang][$page-1][$subpage])) ? 
				$sitemap[$lang][$page-1][$subpage][0] : 
				$sitemap[$lang][$page-1][$subpage]).'</a>';
		}
		if ($item)
		{
			print ' >> <a href="';
			create_link($page,$subpage,$item,-1);
			print '">'.$sitemap[$lang][$page-1][$subpage][$item].'</a>';
		}
		print '</p><br/>';

		/* creating items navigation menu */
		if (($ilen=count($sitemap[$lang][$page-1][$subpage]))>1)
		{
			print '<p>'.$items[$lang][12].'</p>';				
			print '<ul class="items">';
			for ($idx=1;$idx<$ilen;$idx++)
			{
            	print '<li'.(($idx==$item)?' class="curr_pos"':'').' id="sub_button'.$idx.'"><a href="';
				create_link(-1,-1, $idx, -1);
				print '">';
				if (is_array($sitemap[$lang][$page-1][$subpage][$idx]))
		 			print $sitemap[$lang][$page-1][$subpage][$idx][0];
				else print $sitemap[$lang][$page-1][$subpage][$idx];
				print '</a></li>';
			}			
			print '</ul>';
		}
		print '</div><div class="page">';
	}
	
/* <!--.......PLACE FOR PAGES...................................................................--> */
	/* page name format is: Pppssiil.php,
		where pp - page index, ss - subpage index, ii - item index, l - language index
		for example P0001001.php is page 0, subpage 1, item 0, language 1 */
	$loadpage = sprintf ('P%02d%02d%02d%01d.php', (($page==1)?0:$page), $subpage, $item, $lang);
	/* select page to load (page0=page1) */
	if (!@include $loadpage) /* if is not exsist put note */
		print '<p id="error"><br/>'.$items[$lang][10].'</p>';
	print '<div class="clear"></div>';
	if ($page && !$lang && isset($price[$page-1][$subpage]))
	{
		if ($item && isset($price[$page-1][$subpage][$item]))
			$leva = $price[$page-1][$subpage][$item];
		elseif (is_array($price[$page-1][$subpage]))
			$leva = $price[$page-1][$subpage][1];
		else $leva = $price[$page-1][$subpage];
		if ($leva)
			print '<br/><hr><br/><h5>Цени от: '.$leva.' лева без ДДС</h5>';
	}
?>
	  <br/></div>
	<div class="clear"></div>
  </div>
	<!-- FOOTER SECTION - BOTTOM BANNER PLUS COUNTER -->
	<div id="footer">
		<img src="images/img_ban_bottom.jpg" width="<?PHP print $width; ?>" height="50">
		<div id="footer_cntr">
			<script type="text/javascript">
			<!-- BEGIN OF TYXO.BG COUNTER
			d=document;
			d.write('<a href="http://www.tyxo.bg/?83979" title="Tyxo.bg counter" target=" blank"><img width="88" height="31"');
			d.write(' src="http://cnt.tyxo.bg/83979?rnd='+Math.round(Math.random()*2147483647));
			d.write('&sp='+screen.width+'x'+screen.height+'&r='+escape(d.referrer)+'" /><\/a>');
			//-->
			</script>
			<noscript><a href="http://www.tyxo.bg/?83979" title="Tyxo.bg counter" target=" blank"><img src="http://cnt.tyxo.bg/83979" width="88" height="31" alt="Tyxo.bg counter"></a></noscript>
			<!-- END OF TYXO.BG COUNTER -->
		</div>
  </div>
</div>
</body></html>