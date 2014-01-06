<?PHP 
	$title = "Модул ";
	if (is_array($sitemap[$lang][$page-1][$subpage])) $title .= $sitemap[$lang][$page-1][$subpage][0];
		else $title .= $sitemap[$lang][$page-1][$subpage];
	if ($item) $title .= ' - '.$sitemap[$lang][$page-1][$subpage][$item];
	print '<h4>'.$title.'</h4><br />';
?>
<h5>Моля изберете категорията продукти, от които се интересувате</h5><br />
<div style="width:100%;text-align:center">
<?PHP 
	$imgprod = array('img_omsm_XE13.jpg','img_omsm_XE15.jpg','img_omsm_XD18.jpg','img_omsm_XD100.jpg',
						'img_omsm_TL.jpg','img_omsm_CTX.jpg','img_omsm_XRS.jpg','img_omsm_CTR60.jpg');
	$imgwidth = ceil(($width-250)/count($imgprod));
	if ($imgwidth > 58) $imgwidth=58;
	for ($i=0;$i<count($imgprod);$i++)
	{
		print '<img style="display:inline" src="'.IMG_FOLDER.$imgprod[$i];
		print '" width="'.$imgwidth.'" />';
	}
?>
<div class="clear"></div></div><br />
<h5 style="border-style:outset;font-size:larger" >
<a style="width:100%" href="<?PHP create_link(8,3,1,-1);?>">Подемно-транспортна техника</a></h5><br />
<div style="width:100%;text-align:center">
<?PHP 
	$imgprod = array('img_atsm_ssh.jpg','img_atsm_rot.jpg','img_atsm_cla.jpg','img_atsm_pos.jpg',
						'img_atsm_rcl.jpg','img_atsm_rol.jpg');
	$imgwidth = ceil(($width-250)/count($imgprod));
	if ($imgwidth > 80) $imgwidth=80;
	for ($i=0;$i<count($imgprod);$i++)
	{
		print '<img style="display:inline" src="'.IMG_FOLDER.$imgprod[$i];
		print '" width="'.$imgwidth.'" />';
	}
?>
<div class="clear"></div></div><br />
<h5 style="border-style:outset;font-size:larger" >
<a style="width:100%" href="<?PHP create_link(8,3,2,-1);?>">Сменни приспособления</a></h5><br />
