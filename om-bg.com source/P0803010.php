<?PHP 
	$title = "����� ";
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
		$formdata[0] = array('','','','',
							'','','','','',
							'','','','','',
							'','','','','',
							'','','','','');
		$formdata[1] = array('pr_range','pr_group','pr_item','truck_type',
							'load_kg_val','load_l_val','load_w_val','load_h_val','lift_h_val',
							'loadmax_kg_val','ast_val','truck_h_val','freelift','sideshift',
							'com_name','pers_family','pers_phone','pers_fax','pers_mobile',
							'pers_mail1','com_web','contact','advert','add_reqir');
		$formdata[2] = array('val','val','val','str',
							'val','val','val','val','val',
							'val','val','val','str','str',
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
							preg_replace('/[^\w.,�-��-�\-\s]/i','',$formfield):'';
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
			if ($i==2)
			{
				 $i1 = floor($formdata[0][2]/10000);
				 $i2 = floor(($formdata[0][2]-$i1*10000)/100);
				 $i3 = $formdata[0][2]-$i1*10000-$i2*100;
				 $formdata[0][2] .= ' = '.$sitemap[1][$i1-1][0].' - ';
				 if ($i3>0)
				 	$formdata[0][2] .= $sitemap[1][$i1-1][$i2][0].' - '.$sitemap[1][$i1-1][$i2][$i3];
				 else $formdata[0][2] .= $sitemap[1][$i1-1][$i2];
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
		$headers="From: ".$formdata[0][19]."\n" /* e-mail1 field */
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
				print "<BR /><h5>������� ���� ������� ������</h5><BR />";
				print "<BR /><h5>���������� �� �� ���������� �����</h5><BR />";
				$formOK = TRUE;
			} else print "<BR /><h5>��������� ��������</h5><BR />".
				"<h5>���� �������� ������ �����������</h5><BR /><BR /><HR><BR />";
		} else print "<BR /><h5>��������� ��� �� ������</h5><BR />".
				"<h5>���� �������� ����� ��� � �������� ������ �����������</h5><BR /><BR /><HR><BR />";
	}
	if ($formOK)
	{
		print '<h5><form action="" method="post"><input type="submit" id="back" name="back"';
		print ' value="�����"></form></h5>';
	} else {
		$prodrange[0]=' ������';
		for ($i=0;$i<count($sitemap[$lang]);$i++)
		{
			$prodtext = (is_array($sitemap[$lang][$i]))? $sitemap[$lang][$i][0]:$sitemap[$lang][$i];
			if (preg_match('/�������/i',$prodtext))
			{
				$prodtext = trim(preg_replace('/��������/i','',$prodtext));
				$prodrange[$i+1] = trim(preg_replace('/��������/i','',$prodtext));
			}
		}
		asort($prodrange);
		
		$prodgroups[0]=' ������';
		$proditems[0]=' ������';
		while (list($idx, $val) = each($prodrange))
		{
			if ($idx) {
				for ($i=1;$i<count($sitemap[$lang][$idx-1]);$i++)
				{
					if (is_array($sitemap[$lang][$idx-1][$i]))
					{			
						$prodgroups[$idx*100+$i] = $sitemap[$lang][$idx-1][$i][0].' '.$val;
						for ($j=1;$j<count($sitemap[$lang][$idx-1][$i]);$j++)
						{
							$proditems[$idx*10000+$i*100+$j] = $sitemap[$lang][$idx-1][$i][0]
												.' '.$val.' '.$sitemap[$lang][$idx-1][$i][$j];	
						}
					} else {
							$prodgroups[$idx*100+$i] = $sitemap[$lang][$idx-1][$i].' '.$val;	
							$proditems[$idx*10000+$i*100] = $sitemap[$lang][$idx-1][$i].' '.$val;	
						}
				}
			}
		}
		reset($prodrange);
		asort($prodgroups);
		asort($proditems);
					
		if ($formdata[0][2])
		{
			$proditem = $formdata[0][2];
			$prodgroup = $formdata[0][1];
			$prodref = $formdata[0][0];
		} else {
			$proditem = intval((isset($_GET['ref']))?$_GET['ref']:'0');
			$prodgroup = floor($proditem/100);
			$prodref = floor($proditem/10000);
		}
	
?>
		<h5>���� ����������� ���������� � ��������� ������������ ������</h5>
		<form id="offer" class="big" action="" method="post" enctype="multipart/form-data">
		<fieldset><legend>����� �� �������</legend>
			<label class="label">�����:</label>
			<select class="text" id="pr_range" name="pr_range">
			<?PHP
				while(list($idx, $val) = each($prodrange))
				{
					print '<option value="'.$idx.'"';
					if ($prodref==$idx) print ' selected="selected"';
					print '>'.$val.'</option>';
				}
			?>
			</select><br/>
			
			<label class="label">���������� �����:</label>
			<select class="text" id="pr_group" name="pr_group">
			<?PHP
				while(list($idx, $val) = each($prodgroups))
				{
					print '<option value="'.$idx.'"';
					if ($prodgroup==$idx) print ' selected="selected"';
					print '>'.$val.'</option>';
				}
			?>
			</select><br/>
			
			<label class="label">�����:</label>
			<select class="text" id="pr_item" name="pr_item">
			<?PHP
				while(list($idx, $val) = each($proditems))
				{
					print '<option value="'.$idx.'"';
					if ($proditem==$idx) print ' selected="selected"';
					print '>'.$val.'</option>';
				}
			?>
			</select><br/>
			<div class="clear"></div>
		</fieldset>
		
		<fieldset><legend>������� ���������</legend>
			<label class="label">����� �� ������:</label>
			<select class="text" id="truck_type" name="truck_type">
				<option value="all"
					<?PHP if ($formdata[0][3]=="all") print ' selected="selected"'; ?>
					>��� ��������</option>
				<option value="warehouse"
					<?PHP if ($formdata[0][3]=="warehouse") print ' selected="selected"'; ?>
					>������� � �����</option>
				<option value="outdoors"
					<?PHP if ($formdata[0][3]=="outdoors") print ' selected="selected"'; ?>
					>������� �� �������</option>
				<option value="mixed"
					<?PHP if ($formdata[0][3]=="mixed") print ' selected="selected"'; ?>
					>������ �����</option>
			</select><br/>
			
			<label class="label" for="load_kg_val">
				<span class="mand">* </span>���������� ����� �� ������:</label>
			<input class="text mand" id="load_kg_val" name="load_kg_val" type="text" size="10"								
				value="<?PHP print $formdata[0][4]; ?>"/>
			<label class="text" for="load_kg_val">&nbsp;��.</label>
			<label class="info" for="load_kg_val" id="info_load_kg_val">����. 2600</label><br/>
			
			<label class="label" for="load_l_val">������� �� ������ (LxWxH):</label>
			<input class="text" id="load_l_val" name="load_l_val" type="text" size="5"								
				value="<?PHP print $formdata[0][5]?>"/>
			<label class="text" for="load_l_val">&nbsp;��.&nbsp;&nbsp;x&nbsp;</label>
			<input class="text" id="load_w_val" name="load_w_val" type="text" size="5"								
				value="<?PHP print $formdata[0][6]; ?>"/>
			<label class="text" for="load_w_val">&nbsp;��.&nbsp;&nbsp;x&nbsp;</label>
			<input class="text" id="load_h_val" name="load_h_val" type="text" size="5"								
				value="<?PHP print $formdata[0][7]; ?>"/>
			<label class="text" for="load_h_val">&nbsp;��.</label>
			<label class="info" for="load_l_val">����. 
				<span id="info_load_l_val">120</span> x
				<span id="info_load_w_val">100</span> x
				<span id="info_load_h_val">60</span></label><br/>
			<label class="label" for="lift_h_val">�������� �� ���������:</label>
			<input class="text" id="lift_h_val" name="lift_h_val" type="text" size="10"								
				value="<?PHP print $formdata[0][8]; ?>"/>
			<label class="text" for="lift_h_val">&nbsp;��.</label>
			<label class="info" for="lift_h_val" id="info_lift_h_val">����. 330</label><br/>
			
			<label class="label" for="loadmax_kg_val">���������� ����� �� ������ ��� ���������� �������� �� ��������� (��&nbsp;H&nbsp;>&nbsp;400&nbsp;��):</label>
			<input class="text" id="loadmax_kg_val" name="loadmax_kg_val" type="text" size="10"								
				value="<?PHP print $formdata[0][9]; ?>"/>
			<label class="text" for="loadmax_kg_val">&nbsp;��.</label>
			<label class="info" for="loadmax_kg_val" id="info_loadmax_kg_val">����. 2500</label><br/><br/>
			
			<label class="label" for="ast_val">������ �� ������� �������:</label>
			<input class="text" id="ast_val" name="ast_val" type="text" size="10"								
				value="<?PHP print $formdata[0][10]; ?>"/>
			<label class="text" for="ast_val">&nbsp;��.</label>
			<label class="info" for="ast_val" id="info_ast_val">����. 330</label><br/>
			
			<label class="label" for="truck_h_val">���������a ���������� �������� �� ��������:</label>
			<input class="text" id="truck_h_val" name="truck_h_val" type="text" size="10"								
				value="<?PHP print $formdata[0][11]; ?>"/>
			<label class="text" for="truck_h_val">&nbsp;��.</label>
			<label class="info" for="truck_h_val" id="info_truck_h_val">����. 210</label><br/>
			
			<input class="check" type="checkbox" id="freelift" name="freelift" value="freelift" 								
				<?PHP if ($formdata[0][12]) print 'checked="checked"'; ?>/>
			<label class="text" for="freelift">������������ ������ ��� �������� ��� (��������� �� ������ �� 120&divide;220 �� ��� ��������� �� ��������)</label><br/>
			
			<input class="check" type="checkbox" id="sideshift" name="sideshift" value="sideshift" 								
				<?PHP if ($formdata[0][13]) print 'checked="checked"'; ?>/>
			<label class="text" for="sideshift">���������� ������� ���������� (���������� �� ����������� ����� &plusmn;10 ��. ������� �� ��-������ ���������)</label><br/>
			
			<label class="label" for="add_reqir">������������ ����������:</label>
			<textarea class="text" id="add_reqir" name="add_reqir" cols="30" rows="2"><?PHP
				print $formdata[0][23]; ?></textarea>
			<label class="info" id="info_add_reqir">�������� �����</label><br/>
		</fieldset>
		
		<fieldset><legend>������� ������</legend>
			<label class="label" for="com_name">��� �� �����:</label>
			<input class="text" id="com_name" name="com_name" type="text" size="30"								
				value="<?PHP print $formdata[0][14]; ?>"/>
			<label class="info" for="com_name" id="info_com_name">����. ������ ���</label><br/>
			
			<label class="label" for="pers_family">
				<span class="mand">* </span>�������:</label>
			<input class="text mand" id="pers_family" name="pers_family" type="text" size="30"								
				value="<?PHP print $formdata[0][15]; ?>"/>
			<label class="info" for="pers_family" id="info_pers_family">����. ������</label><br/>
			
			<label class="label" for="pers_phone">
				<span id="lab_pers_phone" class="mand">* </span>�������:</label>
			<input class="text mand" id="pers_phone" name="pers_phone" type="text" size="15"								
				value="<?PHP print $formdata[0][16]; ?>"/>
			<label class="info" for="pers_phone" id="info_pers_phone">����. (02) 978 44 06</label><br/>
			
			<label class="label" for="pers_fax">����:</label>
			<input class="text" id="pers_fax" name="pers_fax" type="text" size="15"								
				value="<?PHP print $formdata[0][17]; ?>"/>
			<label class="info" for="pers_fax" id="info_pers_fax">����. (02) 978 70 85</label><br/>
			
			<label class="label" for="pers_mobile">������� �������:</label>
			<input class="text" id="pers_mobile" name="pers_mobile" type="text" size="15"								
				value="<?PHP print $formdata[0][18]; ?>"/>
			<label class="info" for="pers_mobile" id="info_pers_mobile">����. (0888) xxx xxx</label><br/>
			
			<label class="label" for="pers_mail1">
				<span class="mand">* </span>�-���� :</label>
			<input class="text mand" id="pers_mail1" name="pers_mail1" type="text" size="30"								
				value="<?PHP print $formdata[0][19]; ?>"/>
			<label class="info" for="pers_mail1" id="info_pers_mail1">����. name@domain.com</label><br/>
			
			<label class="label" for="com_web">�������� (WEB ����):</label>
			<input class="text" id="com_web" name="com_web" type="text" size="30"								
				value="<?PHP print $formdata[0][20]; ?>"/>
			<label class="info" for="com_web" id="info_com_web">����. www.domain.com</label><br/>
		</fieldset>
		
		<fieldset><legend>���������</legend>
			<input type="hidden" id="RequestId" name="RequestId" value="<?php print $request_id; ?>" > 
			<label class="label" for="SecCode">��� �� ���������:</label>
			<img class="text" src="image.php?rid=<?php print code_number($num); ?>" width=160 height=50 /><br/>
			<label class="label" for="SecCode"><span class="mand">* </span>�������� ����:</label>
			<input class="text mand" type="text" id="SecCode" name="SecCode" size=15 value=""/><br/>  
			<input class="check" type="checkbox" id="advert" name="advert" value="advert" checked="checked"/>
			<label class="text" for="advert">�������� ��� �� ��������� ���������� �� ���� �������� � ��������</label><br/>
			<input class="check" type="checkbox" id="contact" name="contact" value="contact" onClick="request_phone(this)"/>
			<label class="text" for="contact">����� �������� �� ������� �� �� ������ � ��� �� ������������ ����������</label><br/>
			<input class="check" type="checkbox" id="agree" name="agree" value="agree"  checked="checked"onClick="enable_submit(this)"/>
			<label class="text" for="agree">�������� ��� � ���������� ��-���� �������</label><br/>
			
			<label class="label" for="bt_submitf"></label>
			<input class="text" type="submit" id="bt_submitf" name="bt_submitf" value="�������" />
			<input class="text" type="reset" id="bt_reset" name="bt_reset" value="�������" />
			<div class="clear"></div><hr/>
			<p class="form_info">  * ����������� ������ �� ������������</p>
			<p class="form_info"> ** �������������� ����� �� ����� ��������� ���� �������������� ����������</p>
			<p class="form_info"> ������������ �� ����� �� ��������� �� ���� ������� �� ����������������, ����� � �� �� ���������� ����������� ������������� ����� � ������ ��� ����� ���������� ���������� ������������ �� ���, ��� ���� ������������� ��������, ����� ��� ���� �� ������ �� ������ �� ����������� ���������� ������. ������������ �� ����� �� ��������� �� �� �����, ��������� ��� �������� ������� ����� ���������� �� ������������� � �� �� ���������� ��������� ���������� �� ����� ����. ������������ �� ����� ���� �� �������� ������ ����� �� ������������� �������, �������� �������� � ������ ��������� �� ������������� � ����� ��������. ���� ����������, ����� ������������ �� ����� ���� �� ������, ������� ���, �������� �����, ��������� � ���� ������, ����� �� ���������� ���� � �������� ����� �������� ����������, ����� ��� ������������ �� ������� � �� ���� ������, ����������� �� ���������� ���� ��� ���� �����. ���� ���� � �������� �� �������� ���������� �� ���������� �� ������ �������� � ������ ��� ����������, ����� �� � ������������ ����������. ����� ���������� �� ������ � �������, � ����� ����������� �� �����������, �������� ����������, ���������� ������ ���� ����������� ������ ��� ������ ����������. ���������� ���� �� ���� �������� ���������� ���� ������ �� ������������� ���� ���-�����, ������ (cookies), ��������� (scripts). ������� �� ������ ���������� �� ������ IP �����, ���������� �������� � ����, � ����� �� ���������� � ������ �� ������ (cookies), ����� �� ��������� �� ����� �������� �� ���-����� ����������� � �������, � ����� �������� ��������� ��������. ���� ���������� �� �������� �� ����������� �������� �� ���-����� � �� ������� ����� �� �� ������������ �����, ����� � �� �������� ������� � �� ���� ������������ ����������.</p>
		</fieldset>
		</form>	
<?PHP } ?>