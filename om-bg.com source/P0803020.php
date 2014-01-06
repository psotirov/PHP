<?PHP 
	$title = "Модул ";
	if (is_array($sitemap[$lang][$page-1][$subpage])) $title .= $sitemap[$lang][$page-1][$subpage][0];
		else $title .= $sitemap[$lang][$page-1][$subpage];
	if ($item) $title .= ' - '.$sitemap[$lang][$page-1][$subpage][$item];
	print '<h4>'.$title.'</h4><br />';
	
	$salt = "A_VERY_VERY_SECRET_STRING_FROM_PAVEL";
	$num = rand(10000, 99999); // creates verification number 
	$request_id = md5($salt.ceil(time()/2000).$num.$salt); // valid for at least 999 seconds 
	$formOK = FALSE;
	if (isset($_POST['bt_submitf']))
	{
		$message = "Message sent from www.dimexlift.net\n\n";
		$message .= strftime ("on %d - %B - %Y at %T ( %z )\n\n",time());
		$message .= $title."\n\n";
		$formdata[0] = array('','','','','',
							'','','','','',
							'',
							'','','','','',
							'','','','','');
		$formdata[1] = array('pr_range','pr_item','pr_model','truck_type','load_cap_val',
							'freelift','addon_hydr','load_kg_val','load_l_val','load_w_val',
							'load_h_val',
							'com_name','pers_family','pers_phone','pers_fax','pers_mobile',
							'pers_mail1','com_web','contact','advert','add_reqir');
		$formdata[2] = array('val','str','str','str','val',
							'str','str','val','val','val',
							'val',
							'str','str','num','num','num',
							'mail','str','str','str','str');
		for ($i=0;$i<count($formdata[1]);$i++)
		{
			$formfield = isset($_POST[$formdata[1][$i]]) ? substr($_POST[$formdata[1][$i]],0,511):'';
			if (strlen($formfield))
			{
				$formfield = preg_replace('/\s+$/m','',$formfield);
				$formfield = isset($formfield)?preg_replace('/^\s+/m','',$formfield):'';
				$formfield = isset($formfield)?preg_replace('/\s\s+/',' ',$formfield):'';
				switch ($formdata[2][$i]) {
					case 'str':
						$formfield = isset($formfield) ? 
							preg_replace('/[^\w.,А-Яа-я\-\s]/i','',$formfield):'';
						break;
					case 'mail':
						$formfield = isset($formfield) ? 
							preg_replace('/[^\w.@\-]/i','',$formfield):'';							
						break;
					case 'num':
						$formfield = isset($formfield) ? 
							preg_replace('/[^\d\s()+]/','',$formfield):'';							
						break;
					case 'val':
						$formfield = isset($formfield) ? 
							preg_replace('/\D/','',$formfield):'';							
						break;
				}
				if (isset($formfield) && strlen($formfield)) $formdata[0][$i] = $formfield;
			}
			if ($i==0)
			{
				 $i1 = floor($formdata[0][0]/100);
				 $i2 = $formdata[0][0]-$i1*100;
				 $formdata[0][0] .= ' = '.$sitemap[0][$i1-1][0].' - '.$sitemap[0][$i1-1][$i2];
			}
			$message .= $formdata[1][$i].': '
						.(($i==count($formdata[1])-1)?"\n":'')
						.$formdata[0][$i]."\n";
		}
		$message = wordwrap(htmlspecialchars($message), 70);
		$subject = "Module ";
		if (is_array($sitemap[1][$page-1][$subpage]))
			 $subject .= $sitemap[1][$page-1][$subpage][0];
		else $subject .= $sitemap[1][$page-1][$subpage];
		if ($item) $subject .= '-'.$sitemap[1][$page-1][$subpage][$item];
		$headers="From: ".$formdata[0][16]."\n" /* e-mail1 field */
			. "Content-Type: text/plain; charset=windows-1251; format=flowed\n"
			. "MIME-Version: 1.0\n"
			. "Content-Transfer-Encoding: 8bit\n"
			. "X-Mailer: PHP\n";
		$to="sales@om-bg.com";

		// Check security code
		$num1 = isset($_POST['SecCode']) ? intval($_POST['SecCode']):0;
		$num1 = ($num1 < 10000 || $num1 > 99999) ? '1':md5($salt.ceil(time()/2000).$num1.$salt);
		$request_id1 = isset($_POST['RequestId']) ? $_POST['RequestId']:'0';
		if (strlen($request_id1) == 32 && $num1 == $request_id1)
		{
			if (mail($to, $subject, $message, $headers))
			{
				print "<BR /><h5>ФОРМАТА БЕШЕ УСПЕШНО ПРИЕТА</h5><BR />";
				print "<BR /><h5>БЛАГОДАРИМ ВИ ЗА ОТДЕЛЕНОТО ВРЕМЕ</h5><BR />";
				$formOK = TRUE;
			} else print "<BR /><h5>НЕУСПЕШНО ПРИЕМАНЕ</h5><BR />".
				"<h5>Моля опитайте отново изпращането</h5><BR /><BR /><HR><BR />";
		} else print "<BR /><h5>НЕВАЛИДЕН КОД ЗА ДОСТЪП</h5><BR />".
				"<h5>Моля въведете новия код и опитайте отново изпращането</h5><BR /><BR /><HR><BR />";
	}
	if ($formOK)
	{
		print '<h5><form action="" method="post"><input type="submit" id="back" name="back"';
		print ' value="НАЗАД"></form></h5>';
	} else {
		$prodrange=0;
		for ($i=0;$i<count($sitemap[$lang]);$i++)
		{
			$prodtext = (is_array($sitemap[$lang][$i]))? $sitemap[$lang][$i][0]:$sitemap[$lang][$i];
			if (preg_match('/риспособ/i',$prodtext))
				$prodrange = $i+1;
		}
		
		$prodgroups[0]=' Всички';
		if ($prodrange)
		{
			if (is_array($sitemap[$lang][$prodrange-1]))
			{
				for ($i=1;$i<count($sitemap[$lang][$prodrange-1]);$i++)
					$prodgroups[$prodrange*100+$i] = $sitemap[$lang][$prodrange-1][$i];
				asort($prodgroups);				
			} else $prodgroups[0] = $sitemap[$lang][$prodrange-1];
		}
	
		if ($formdata[0][0])
		{
			$prodgroup = $formdata[0][0];
		} else {
			$proditem = intval((isset($_GET['ref']))?$_GET['ref']:'0');
			$prodgroup = floor($proditem/100);
		}
	
?>
		<h5>Моля разгледайте внимателно и попълнете необходимите полета</h5>
		<form id="offer" class="big" action="" method="post" enctype="multipart/form-data">
		<fieldset><legend>Избор на продукт</legend>
			<label class="label">Продуктова група:</label>
			<select class="text" id="pr_range" name="pr_range">
			<?PHP
				while(list($idx, $val) = each($prodgroups))
				{
					print '<option value="'.$idx.'"';
					if ($prodgroup==$idx) print ' selected="selected"';
					print '>'.$val.'</option>';
				}
			?>
			</select><br/>
			
			<label class="label" for="pr_item">Модел:</label>
			<input class="text" id="pr_item" name="pr_item" type="text" size="10" 
				value="<?PHP print $formdata[0][1]; ?>"/>
			<label class="info" for="pr_item" id="info_pr_item">напр. 675</label><br/>
			
			<label class="label" for="pr_model">Каталожен номер:</label>
			<input class="text" id="pr_model" name="pr_model" type="text" size="20" 
				value="<?PHP print $formdata[0][2]; ?>"/>
			<label class="info" for="pr_model" id="info_pr_model">напр. 17SLL3C0001</label><br/>
			<div class="clear"></div>
		</fieldset>
		
		<fieldset><legend>Работни параметри</legend>
			<label class="label" for="truck_type">Тип и модел на кара:</label>
			<input class="text" id="truck_type" name="truck_type" type="text" size="30" 
				value="<?PHP print $formdata[0][3]; ?>"/>
			<label class="info" for="truck_type" id="info_truck_type">напр. DIMEX E16</label><br/>
			
			<label class="label" for="load_cap_val">
				<span class="mand">* </span>Номинална товароподемност:</label>
			<input class="text mand" id="load_cap_val" name="load_cap_val" type="text" size="10" 
				value="<?PHP print $formdata[0][4]; ?>"/>
			<label class="text" for="load_cap_val">&nbsp;кг.</label>
			<label class="info" for="load_cap_val" id="info_load_cap_val">напр. 3500</label><br/>
			
			<input class="check" type="checkbox" id="freelift" name="freelift" value="freelift"
			<?PHP if ($formdata[0][5]) print 'checked="checked"'; ?>/>
			<label class="text" for="freelift">Повдигателната уредба на кара е със свободен 
				ход (повдигане на товара без разгъване на уредбата)</label><br/>
			
			<input class="check" type="checkbox" id="addon_hydr" name="addon_hydr" value="addon_hydr"
			<?PHP if ($formdata[0][6]) print 'checked="checked"'; ?>/>
			<label class="text" for="sideshift">Карът, на който ще се монтира приспособлението 
				има изведени необходимите допълнителни хидравлични функции до 
				бързосменни съединители на вертикалната количка</label><br/>
			
			<label class="label" for="load_kg_val">
				<span class="mand">* </span>Максимално тегло на товара:</label>
			<input class="text mand" id="load_kg_val" name="load_kg_val" type="text" size="10"								
				value="<?PHP print $formdata[0][7]; ?>"/>
			<label class="text" for="load_kg_val">&nbsp;кг.</label>
			<label class="info" for="load_kg_val" id="info_load_kg_val">напр. 2600</label><br/>
			
			<label class="label" for="load_l_val">Размери на товара (LxWxH):</label>
			<input class="text" id="load_l_val" name="load_l_val" type="text" size="5"								
				value="<?PHP print $formdata[0][8]?>"/>
			<label class="text" for="load_l_val">&nbsp;см.&nbsp;&nbsp;x&nbsp;</label>
			<input class="text" id="load_w_val" name="load_w_val" type="text" size="5"								
				value="<?PHP print $formdata[0][9]; ?>"/>
			<label class="text" for="load_w_val">&nbsp;см.&nbsp;&nbsp;x&nbsp;</label>
			<input class="text" id="load_h_val" name="load_h_val" type="text" size="5"								
				value="<?PHP print $formdata[0][10]; ?>"/>
			<label class="text" for="load_h_val">&nbsp;см.</label>
			<label class="info" for="load_l_val">напр. 
				<span id="info_load_l_val">120</span> x
				<span id="info_load_w_val">100</span> x
				<span id="info_load_h_val">60</span></label><br/>
			<label class="info">ако товара е кръгъл (рула, варели) посочете диаметъра в първото поле 
				и запишете&nbsp;00 като стойност във второто поле</label><br />
			
			<label class="label" for="add_reqir">Допълнителни изисквания:</label>
			<textarea class="text" id="add_reqir" name="add_reqir" cols="30" rows="2"><?PHP
				print $formdata[0][20]; ?></textarea>
			<label class="info" id="info_add_reqir">свободен текст</label><br/>
		</fieldset>
		
		<fieldset><legend>Обратна връзка</legend>
			<label class="label" for="com_name">Име на фирма:</label>
			<input class="text" id="com_name" name="com_name" type="text" size="30"								
				value="<?PHP print $formdata[0][11]; ?>"/>
			<label class="info" for="com_name" id="info_com_name">напр. Димекс ООД</label><br/>
			
			<label class="label" for="pers_family">
				<span class="mand">* </span>Фамилия:</label>
			<input class="text mand" id="pers_family" name="pers_family" type="text" size="30"								
				value="<?PHP print $formdata[0][12]; ?>"/>
			<label class="info" for="pers_family" id="info_pers_family">напр. Петров</label><br/>
			
			<label class="label" for="pers_phone">
				<span id="lab_pers_phone" class="mand">* </span>Телефон:</label>
			<input class="text mand" id="pers_phone" name="pers_phone" type="text" size="15"								
				value="<?PHP print $formdata[0][13]; ?>"/>
			<label class="info" for="pers_phone" id="info_pers_phone">напр. (02) 978 44 06</label><br/>
			
			<label class="label" for="pers_fax">Факс:</label>
			<input class="text" id="pers_fax" name="pers_fax" type="text" size="15"								
				value="<?PHP print $formdata[0][14]; ?>"/>
			<label class="info" for="pers_fax" id="info_pers_fax">напр. (02) 978 70 85</label><br/>
			
			<label class="label" for="pers_mobile">Мобилен телефон:</label>
			<input class="text" id="pers_mobile" name="pers_mobile" type="text" size="15"								
				value="<?PHP print $formdata[0][15]; ?>"/>
			<label class="info" for="pers_mobile" id="info_pers_mobile">напр. (0888) xxx xxx</label><br/>
			
			<label class="label" for="pers_mail1">
				<span class="mand">* </span>Е-поща :</label>
			<input class="text mand" id="pers_mail1" name="pers_mail1" type="text" size="30"								
				value="<?PHP print $formdata[0][16]; ?>"/>
			<label class="info" for="pers_mail1" id="info_pers_mail1">напр. name@domain.com</label><br/>
			
			<label class="label" for="com_web">Интернет (WEB сайт):</label>
			<input class="text" id="com_web" name="com_web" type="text" size="30"								
				value="<?PHP print $formdata[0][17]; ?>"/>
			<label class="info" for="com_web" id="info_com_web">напр. www.domain.com</label><br/>
		</fieldset>
		
		<fieldset><legend>Изпращане</legend>
			<input type="hidden" id="RequestId" name="RequestId" value="<?php print $request_id; ?>" > 
			<label class="label" for="SecCode">Код за изпращане:</label>
			<img class="text" src="image.php?rid=<?php print code_number($num); ?>" width=160 height=50 /><br/>
			<label class="label" for="SecCode"><span class="mand">* </span>Въведете кода:</label>
			<input class="text mand" type="text" id="SecCode" name="SecCode" size=15 value=""/><br/>  
			<input class="check" type="checkbox" id="advert" name="advert" value="advert" checked="checked"/>
			<label class="text" for="advert">Съгласен съм да получавам информация за нови продукти и промоции</label><br/>
			<input class="check" type="checkbox" id="contact" name="contact" value="contact" onClick="request_phone(this)"/>
			<label class="text" for="contact">Желая служител на фирмата да се свърже с мен за допълнителна информация</label><br/>
			<input class="check" type="checkbox" id="agree" name="agree" value="agree"  checked="checked"onClick="enable_submit(this)"/>
			<label class="text" for="agree">Съгласен съм с посочените по-долу условия</label><br/>
			
			<label class="label" for="bt_submitf"></label>
			<input class="text" type="submit" id="bt_submitf" name="bt_submitf" value="Изпрати" />
			<input class="text" type="reset" id="bt_reset" name="bt_reset" value="Изчисти" />
			<div class="clear"></div><hr/>
			<p class="form_info">  * Маркираните полета са задължителни</p>
			<p class="form_info"> ** Предоставените данни ще бъдат третирани като конфиденциална информация</p>
			<p class="form_info"> Собственикът на сайта се задължава да пази тайната на кореспонденцията, както и да не разгласява създадените потребителски имена и пароли или друга персонална информация предоставена от Вас, без Ваше предварително съгласие, освен ако това не следва по силата на действащата нормативна уредба. Собственикът на сайта се задължава да не следи, редактира или разкрива никаква лична информация за потребителите и да не предоставя събраната информация на трети лица. Собственикът на сайта може да използва Вашите данни за статистически анализи, рекламни кампании и директ маркетинг за представените в сайта продукти. Типа информация, която собственикът на сайта може да събира, включва име, служебен адрес, телефонни и факс номера, адрес за електронна поща и всякаква друга свързана информация, която сте предоставили по каквито и да било начини, включително по електронна поща или през сайта. Също така е възможно да събираме информация за ползването на нашите продукти и услуги или информация, която ни е предоставена доброволно. Лична информация се събира в момента, в който потребители се регистрират, изискват информация, публикуват мнения чрез дискусионни форуми или онлайн проучвания. Информация може да бъде получена индиректно чрез логове за идентификация пред уеб-сайта, кукита (cookies), скриптове (scripts). Примери за такава информация са Вашият IP адрес, вътрешните страници и реда, в който ги посещавате и статус на кукита (cookies), които са поставени на Вашия компютър от уеб-сайта автоматично в момента, в който посетите началната страница. Тази информация се използва за подобряване работата на уеб-сайта и по никакъв начин не Ви идентифицира лично, както и не събираме каквато и да била чувствителна информация.</p>
		</fieldset>
		</form>	
<?PHP } ?>