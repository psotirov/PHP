<?PHP 
	$title = "����� ";
	if (is_array($sitemap[$lang][$page-1][$subpage])) $title .= $sitemap[$lang][$page-1][$subpage][0];
		else $title .= $sitemap[$lang][$page-1][$subpage];
	if ($item) $title .= ' - '.$sitemap[$lang][$page-1][$subpage][$item];
	print '<h4>'.$title.'</h4><br />';
	
	$salt = "A_VERY_VERY_SECRET_STRING_FROM_PAVEL";
	$num = rand(10000, 99999); // creates verification number 
	$request_id = md5($salt.ceil(time()/2000).$num.$salt); // valid for at least 999 seconds 
	if (isset($_POST['bt_submitf']))
	{
		$message = "Message sent from www.dimexlift.net\n\n";
		$message .= strftime ("on %d - %B - %Y at %T ( %z )\n\n",time());
		$message .= $title."\n\n";
		$formdata[0] = array('','','','','','');
		$formdata[1] = array('com_name','pers_family','pers_phone','pers_mail1','advert','message');
		$formdata[2] = array('str','str','num','mail','str','str');
		// Check security code
		$num = isset($_POST['SecCode']) ? intval($_POST['SecCode']):0;
		$num = ($num < 10000 || $num > 99999) ? '1':md5($salt.ceil(time()/2000).$num.$salt);
		$request_id = isset($_POST['RequestId']) ? $_POST['RequestId']:'0';
		if (strlen($request_id) == 32 && $num == $request_id)
		{
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
								preg_replace('/[^\w�-��-�\-\s]/i','',$formfield):'';
							break;
						case 'mail':
							$formfield = isset($formfield) ? 
								preg_replace('/[^\w.@\-]/i','',$formfield):'';							
							break;
						case 'num':
							$formfield = isset($formfield) ? 
								preg_replace('//[^\d\s()+]/','',$formfield):'';							
							break;
					}
					if (isset($formfield) && strlen($formfield)) $formdata[0][$i] = $formfield;
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
			$headers="From: ".$formdata[0][3]."\n" /* e-mail1 field */
				. "Content-Type: text/plain; charset=windows-1251; format=flowed\n"
				. "MIME-Version: 1.0\n"
				. "Content-Transfer-Encoding: 8bit\n"
				. "X-Mailer: PHP\n";
			$to="sales@om-bg.com";

			if (mail($to, $subject, $message, $headers))
			{
				print "<BR /><h5>������� ���� ������� ������</h5><BR />";
				print "<BR /><h5>���������� �� �� ���������� �����</h5><BR />";
			} else print "<BR /><h5>��������� ��������</h5><BR />";
		} else print "<BR /><h5>��������� ��� �� ������</h5><BR />";
		// Check company name
		print '<h5><form action="" method="post"><input type="submit" id="back" name="back"';
		print ' value="�����"></form></h5>';
	}
	else {
?>
		<form id="feedback" class="big" action="" method="post" enctype="multipart/form-data">
		<fieldset><legend>����� �� ��������</legend>
			<label class="label" for="com_name">��� �� �����:</label>
			<input class="text" id="com_name" name="com_name" type="text" size="30" value=""/>
			<label class="info" for="com_name" id="info_com_name">����. ������ ����</label><br/>
			
			<label class="label" for="pers_family">
				<span class="mand">* </span>�������:</label>
			<input class="text mand" id="pers_family" name="pers_family" type="text" size="30" value=""/>
			<label class="info" for="pers_family" id="info_pers_family">����. ������</label><br/>
			
			<label class="label" for="pers_phone">�������:</label>
			<input class="text" id="pers_phone" name="pers_phone" type="text" size="15" value=""/>
			<label class="info" for="pers_phone" id="info_pers_phone">����. (02) 978 44 06</label><br/>
			
			<label class="label" for="pers_mail1">
				<span class="mand">* </span>�-����:</label>
			<input class="text mand" id="pers_mail1" name="pers_mail1" type="text" size="30" value=""/>
			<label class="info" for="pers_mail1" id="info_pers_mail1">����. name@domain.com</label><br/>
			<div class="clear"></div>
		</fieldset>
		
		<fieldset><legend>������ ���������</legend>
			<label class="label" for="message">
				<span class="mand">* </span>���������:</label>
			<textarea class="text mand" id="message" name="message" cols="30" rows="7"></textarea>
			<label class="info" for="message" id="info_message">�������� �����</label><br/>
			<div class="clear"></div>
		</fieldset>
		
		<fieldset><legend>��������� �� �����������</legend>
			<input type="hidden" id="RequestId" name="RequestId" value="<?php print $request_id;?>" > 
			<label class="label" for="SecCode">��� �� ������:</label>
			<img  class="text" src="image.php?rid=<?php print code_number($num); ?>" width=160 height=50 /><br />
			<label class="label" for="SecCode"><span class="mand">* </span>�������� ����:</label>
			<input class="text mand" type="text" id="SecCode" name="SecCode" size=15><br/>  
			<input class="check" type="checkbox" id="advert" name="advert" value="advert" checked="checked"/>
			<label class="text" for="advert">�������� ��� �� ��������� ���������� �� ���� �������� � ��������</label><br/>
			<input class="check" type="checkbox" id="agree" name="agree" value="agree" onClick="enable_submit(this)"/>
			<label class="text" for="agree">�������� ��� � ���������� ��-���� �������</label><br/>
			
			<label class="label" for="bt_submitf"></label>
			<input class="text" type="submit" id="bt_submitf" name="bt_submitf" value="�������" />
			<input class="text" type="reset" id="bt_reset" name="bt_reset" value="�������" />
			<div class="clear"></div><hr/>
			<p class="form_info">  * ����������� ������ �� ������������</p>
			<p class="form_info"> ** �������������� ����� �� ����� ��������� ���� �������������� ����������</p>
			<p class="form_info"> ������������ �� ����� �� ��������� �� ���� ������� �� ����������������, ����� � �� �� ���������� ����������� ������������� ����� � ������ ��� ����� ���������� ���������� ������������ �� ���, ��� ���� ������������� ��������, ����� ��� ���� �� ������ �� ������ �� ����������� ���������� ������. ������������ �� ����� �� ��������� �� �� �����, ��������� ��� �������� ������� ����� ���������� �� ������������� � �� �� ���������� ��������� ���������� �� ����� ����. ������������ �� ����� ���� �� �������� ������ ����� �� ������������� �������, �������� �������� � ������ ��������� �� ������������� � ����� ��������. ���� ����������, ����� ������������ �� ����� ���� �� ������, ������� ���, �������� �����, ��������� � ���� ������, ����� �� ���������� ���� � �������� ����� �������� ����������, ����� ��� ������������ �� ������� � �� ���� ������, ����������� �� ���������� ���� ��� ���� �����. ���� ���� � �������� �� �������� ���������� �� ���������� �� ������ �������� � ������ ��� ����������, ����� �� � ������������ ����������. ����� ���������� �� ������ � �������, � ����� ����������� �� �����������, �������� ����������, ���������� ������ ���� ����������� ������ ��� ������ ����������. ���������� ���� �� ���� �������� ���������� ���� ������ �� ������������� ���� ���-�����, ������ (cookies), ��������� (scripts). ������� �� ������ ���������� �� ������ IP �����, ���������� �������� � ����, � ����� �� ���������� � ������ �� ������ (cookies), ����� �� ��������� �� ����� �������� �� ���-����� ����������� � �������, � ����� �������� ��������� ��������. ���� ���������� �� �������� �� ����������� �������� �� ���-����� � �� ������� ����� �� �� ������������ �����, ����� � �� �������� ������� � �� ���� ������������ ����������.</p>
			<div class="clear"></div>
		</fieldset>
		</form>	
<?PHP } ?>