// JavaScript Document for all pages of the web-site
var img_container = new Array();
var anim_buttons = new Array();
var sel_container = new Array();

function preloadimages() // fills image container with images as arguments
{
	for (i=0;i<preloadimages.arguments.length;i++)
		if (img_container[i]=new Image())
			img_container[i].src=preloadimages.arguments[i];
}

function openimage(url) // opens pop-up window with selected image
{
	if (url)
		window.open(url,"_blank","toolbar=no, location=no, directories=no, status=no, \
					menubar=no, scrollbars=no, resizable=no");
}

function getCookie(name)
{
	if (!document.cookie.length) return null; // returns empty if no cookies
	var begin=document.cookie.indexOf(name + "=");
	if (begin==-1) return null; //cookie not found
	begin += name.length+1; //goes to value (after == sign)
	var end=document.cookie.indexOf(";",begin+1);
	if (end==-1) end=document.cookie.length; //this is last cookie
	return unescape(document.cookie.substring(begin,end)); //returns only value
}

function setCookie(name,value,exp_days)
{
	var c = name + "=" +escape(value); //builds cookie
	if (exp_days) // if zero is temporary cookie
	{
		var exdate=new Date();
		exdate.setDate(exdate.getDate()+exp_days);
		c += "; expires="+exdate.toUTCString(); //attaches expires parameters
	}
	document.cookie=c;
	if (!getCookie(name)) return false; // returns error if no such cookie
	return true;
}

function SwapImage(id, idx)
{
   var elem=FindObject(id);
    if (elem && idx<=nav_buttons.length)
      		elem.src=img_container[idx].src;
}

function FindObject(id, doc) // finding element with specified reference 
{
   var child, elem;
   if(!doc)
      doc=document;
   if(doc.getElementById) // DOM compliant browser
      elem=doc.getElementById(id);
   else
   if(doc.layers) // Netscape Navigator
      child=doc.layers;
   else
   if(doc.all) // Internet Explorer
      elem=doc.all[id];
   if(elem)
      return elem;
   if(doc.id==id || doc.name==id) //Check if ID exists in document root or is current child
      return doc;
   if(doc.childNodes) // Iterate in child nodes of document tree 
      child=doc.childNodes;
   if(child)
   {
      for(var i=0; i<child.length; i++)
      {
         elem=FindObject(id,child[i]);
         if(elem)
            return elem;
      }
   }
   var frm=doc.forms; // search in forms if exist such ID
   if(frm)
   {
      for(var i=0; i<frm.length; i++)
      {
         var elems=frm[i].elements;
         for(var j=0; j<elems.length; j++)
         {
            elem=FindObject(id,elems[j]);
            if(elem) return elem;
         }
      }
   }
   return null;
}

function OnGoMenuFormLink(GoList) // opens page related to selected choise
{
   var url = GoList.options[GoList.selectedIndex].value;
   var target = GoList.options[GoList.selectedIndex].className;
   GoList.selectedIndex=0;
   GoList.blur();
   if (url) window.location.replace(url);
}

function animate_menu() //moving all buttons down one by one to their target possition as per "anim_buttons" array
{
	var idx=anim_buttons[1]*2;
	if (!idx) // there is nothing to move - stop
	{
		clearInterval(anim_buttons[0]);
		return; 
	}
	anim_buttons[idx] += 10; //counterdown first		
	if (anim_buttons[idx]>0) anim_buttons[idx]=0; //adjust to land in right position	
	anim_buttons[idx+1].style.top = anim_buttons[idx]+"px"; // move to new position
	if (!anim_buttons[idx]) anim_buttons[1]--; // top image is on place - go with next image
}

function setSize() {
  	var wWidth = 0, oldWidth = 0;
  	if (typeof(window.innerWidth)=='number')
		//Non-IE
    	wWidth = window.innerWidth;
  	else if (document.documentElement && document.documentElement.clientWidth)
			//IE 6+ in 'standards compliant mode'
    		wWidth = document.documentElement.clientWidth;
  		 else if (document.body && document.body.clientWidth)
				//IE 4 compatible
    			wWidth = document.body.clientWidth;
	if (wWidth<600) wWidth=600;
	// total width must be not less than 600px for proper rendering
	var minWidth = Math.ceil(wWidth/100*8)*10;
	//using minimum 80% of total screen width and rounds up to nearest 10-th's
	var update = false;
	if (!(oldWidth=getCookie("wWidth")) || (oldWidth<minWidth) || (oldWidth>wWidth))
		update = setCookie("wWidth", minWidth, 30);
	// current total width must be within interval minWidth-wWidth
	if (update) window.location.reload(true);
	// reload page with new data from server if needed
	return update;
}

function request_phone(thiscontrol)
{
	var textelem = FindObject("pers_phone");
	var labelelem = FindObject("lab_pers_phone");
	
	if (thiscontrol.checked)
	{
		if (textelem) textelem.className += " mand"; // makes text box mandatory
		if (labelelem) labelelem.style.visibility = "visible"; // adds red *
	} else {
			if (textelem) {
				var idx = textelem.className.indexOf(" mand");
				// makes text box not mandatory
				if (idx != -1) textelem.className = textelem.className.substring(0,idx);
			}
			if (labelelem) labelelem.style.visibility = "hidden"; // removes red *			
		}
}

function reset_form()
{
	for(idx=0;idx<this.form.length;idx++) // for each element in form 	
	{
		var elem = this.form.elements[idx];
		if (elem.id=="contact") // prepares mandatory of phone number 
		{
			elem.checked = false;
			request_phone(elem);
		}
		if (elem.type == "text" || elem.type == "password" || elem.type == "textarea")
		// for each text field attaches background change events
			elem.value = "";
	}
	return false;
}

function prepare_forms()
{
	for ( i=0;i<document.forms.length;i++) // for each form
		for(idx=0;idx<document.forms[i].length;idx++) // and for each element in form
		{
			var elem = document.forms[i].elements[idx];
			if (elem.type == "submit") // if the form has submit button
				document.forms[i].onsubmit = validate_form; //attaches validation event
			if (elem.type == "reset") // if the form has reset button
				elem.onclick = reset_form; // attaches clearing event
			if (elem.type == "text" || elem.type =="password" || elem.type == "textarea")
			{ // for each text field attaches background change events
				elem.onfocus = focus_text;
				elem.onblur = blur_text;
			}
			if (elem.type == "select-one")
			{ // take initial options list from some select drop-down elements
				if (elem.id == "pr_range" || elem.id == "pr_group" || elem.id == "pr_item")
				{
					elem.onchange = change_selections; //attaches handler
					var indx = sel_container.length;
					// copy selection object
					sel_container[indx] = new Array();
					sel_container[indx][0] = elem.id;
					for (j=0;j<elem.length;j++)
					{
						sel_container[indx][j*2+1] = elem.options[j].text;
						sel_container[indx][(j+1)*2] = elem.options[j].value;
					}
				}
			}
			if (elem.id == "contact") request_phone(elem); // prepares mandatory of phone number 
		}
}

function prepare_view() 
{
	if (!setSize())
	{
		var lVisit = getCookie("lVisit"); //checks for last visit
		date = new Date();
		if (!setCookie("lVisit",date.toUTCString(),1)) lVisit = 1;
		prepare_forms();
		if (!lVisit) //starts animation only at first visit
		{
			var elem;
			var i=1;
			while ((elem=FindObject("nav_button"+i)) && (elem.style))
			{
				var pos=-i*30-40; //calculate starting position outside visible area (container <div>)
				elem.style.top = pos+"px";
				anim_buttons[i*2] = pos; //puts button in stack for later access
				anim_buttons[i*2+1] = elem; //puts starting position of the button
				i++; // loss of that line will produce endless loop ( as I tried first :)
			}
			anim_buttons[1]=i-1; // transfer number of images for moving
			anim_buttons[0]=setInterval ("animate_menu()", 10); // transfer timer ID for stoping
		}
	}
}

function validate_field(field)
{
	if (field.type == "hidden") return true;
	if (!field.value) return (field.className.indexOf("mand")==-1);
	// if field is empty -> return false if is mandatory, otherwise true 
	
	var val = field.value;
	
	// validating each type of fields separately
	if (field.id) // only if the field has ID set
	{
		if ((field.id.indexOf("username")!=-1) ||
			(field.id.indexOf("password")!=-1))
			{
				val = val.replace(/\W/gi,''); // only A-Z,a-z,0-9,_
				if (val.length < 6) val=''; // not less that 6 chars
			}
		else if ((field.id.indexOf("com_name")!=-1) ||
				(field.id.indexOf("model")!=-1))				   
				{
					val = val.replace(/[^\wà-ÿ\-\s]/gi,''); // only A-Z,a-z,0-9,_,À-ß,à-ÿ,-,' '
					if (val.length < 3) val=''; // not less that 3 chars
				} else if ((field.id.indexOf("name")!=-1) ||
						(field.id.indexOf("family")!=-1))
						{
							val = val.replace(/[^\a-zà-ÿ\-]/gi,''); // only A-Z,a-z,À-ß,à-ÿ,-
							if (val.length < 3) val=''; // not less that 3 chars							
						}
						
		if (field.id.indexOf("adr")!=-1)
		{
			val = val.replace(/[^\wà-ÿ\-\s,.]/gi,''); // only A-Z,a-z,0-9,_,À-ß,à-ÿ,-,' ', ',','.'
			if (val.length < 5) val=''; // not less that 5 chars				
		}
		
		if ((field.id.indexOf("phone")!=-1) ||
			(field.id.indexOf("fax")!=-1) ||
			(field.id.indexOf("mobil")!=-1))
		{
			val = val.replace(/[^\d\s()+]/gi,''); // only 0-9," ",(,),+
			if (val.length < 5) val=''; // not less that 5 digits				
		}
		
		if (field.id.indexOf("Code")!=-1)
		{
			val = val.replace(/\D/gi,''); // only 0-9
			if (val.length < 5) val=''; // not less that 5 digits				
		}
		
		if (field.id.indexOf("val")!=-1)
		{
			val = val.replace(/\D/gi,''); // only 0-9
			if (val.length < 1) val=''; // not less that 1 digit				
		}
			
		if (field.id.indexOf("vat")!=-1) // checking for valid vat number
		{
			val = val.replace(/\W/gi,''); // only A-Z,a-z,0-9,_
			var vat = val.match(/^[a-z]{2}?|\d{8,12}/gi); // first 2 letters(if any) after 8-12 digits
			if (vat == null) val=''; //fails to match pattern
			else {
				if (isNaN(vat[0])) // if found 2 letters at the begining
					val = (vat.length>1)?(vat[0]+vat[1]):'';
					// only valid is 2 letters + digits 
				else val = vat[0]; // otherwise only first block of digits
				if (val.length < 8) val=''; // not less that 8 digits	
			}
		}
		
		if (field.id.indexOf("web")!=-1) // simply checking for valid web address
			val = val.replace(/[^\w.\-]/gi,''); // only A-Z,a-z,0-9, _.-/:
			
		if (field.id.indexOf("mail")!=-1) // strong checking for valid e-mail address
		{
			val = val.replace(/[^\w.@\-]/gi,''); // only A-Z,a-z,0-9,_,".",@,-
			var email = val.split("@"); // splits address at @ point (we will use only [0] and [1])
			val = ''; // prepare for not valid e-mail
			var atom = /^\w+/i; // must start with at least one letter or digit
			if ((email.length>1) && atom.test(email[0])) // it is almost e-mail address
			{
				var domain = email[1].split("."); // resolving domain field
				if (domain.length>1) //must have at least user@name.ext
				{
					for (var idx=domain.length-1;idx>=0;idx--)
						if ((domain[idx].length>0) && atom.test(domain[idx]))
						//each field must start with letter and be at least 1 char length, BUT 
						{
							if (val) val = domain[idx]+'.'+val;
							// if we have domain extension just add other subdomains
							// initialy val variable is empty, SO
							else if ((domain[idx].length>1) && (domain[idx].length<5))
								//first we have to put first possible extension (2,3,4 chars length)
								val = domain[idx]; 
						}
					if (val) val =(val.indexOf(".")!=-1)?email[0]+"@"+val:'';
					// finally if we have valid domain just extend it to valid e-mail
				}
			} 
			if (val.length < 7) val=''; // not less that 9 symbols (for example i@ab.bg)		
		} else val = val.replace(/@/g,''); // if not mail @ is forbidden --- end of mail check
	}
	
	if (field.value==val) return true; //validation is OK
	
	field.value=val; //propose valid value
	return false; // but at least there is mistake
}

function validate_form()
{
	var pwd=0,repwd=0;
	
	if (!this.length) return false; //cannot submit form without elements
	for (var i=0;i<this.length;i++) //iterate all form fields
  	{
  		var elem=this.elements[i];
		var valid = validate_field(elem); 
		if (elem.id.indexOf("password")==0) pwd=elem;			
		if (elem.id.indexOf("re_password")==0) repwd=elem;  	
		if (pwd && repwd && (pwd.value!==repwd.value)) //if re-password is not equal to password 
		{	
			pwd.value="";
			repwd.value="";
			valid = false;
			elem=pwd; // clear passwords and focus them
		}
		if (!valid)
		{
			var next = FindObject("info_"+elem.id); // locates corresponding label element
			// If the next element is a label and has a class of info
			if (next) next.style.color = "red";
			elem.focus();
			return false; // focus wrong field
		}
	}
	return true; // form is validated succesfully
}

function enable_submit(thiscontrol)
{
	var formelem = thiscontrol.form;
	if (!formelem) return; // if control is not in form
	var idx=formelem.length;
	while ((idx>0) && (formelem.elements[idx-1].type != "submit")) idx--; // finds submit button
	if (!idx) return; // if the form has not submit button
	formelem.elements[idx-1].disabled = !(thiscontrol.checked);
	// enable submit button if agreement is checked	
}

function skip_validation(thiscontrol)
{
	var formelem = thiscontrol.form;
	if (!formelem) return; // if control is not in form
	formelem.onsubmit = "return true";
	formelem.submit();
}

function focus_text()
{
	var next = FindObject("info_"+this.id); // locates corresponding label element
	// If the next element is a label and has a class of info
	if (next)
	{
		// "bolds" info text but if the element is not valid preserves red color
		if (next.style.color != "red") next.style.color = "black";
		next.style.textTransform="uppercase";
	}
}

function blur_text()
{
	var next = FindObject("info_"+this.id); // locates corresponding label element
	// If the next element is a label and has a class of info
	if (next)
	{
		// "restores" info text
		next.style.color = "#999";
		next.style.textTransform="none";
	}
}


function update_selections(elem, index, valind) // updates selection unly in defined range
{
	while (elem.length) // deletes old option elements
		elem.remove(0); // here can come only DOM browser
	var itemslen = (sel_container[index].length-1)/2; // calculates number of stored options
	var j=0;
	for (i=0;i<itemslen;i++) //from all initial values of the field
		if (valind == "0" || !sel_container[index][(i+1)*2].indexOf(valind))
		//selects only items that are in range or all (value=0)
			elem.options[j++] = new Option(sel_container[index][i*2+1],sel_container[index][(i+1)*2]);
}

function mark_selections(elem, index, valind) // updates selection unly in defined range
{
  for (i=0;i<elem.length;i++) // from all possible options of the range field
	if (!elem.options[i].value.indexOf(valind)) // selects first element that match value
		{
			elem.selectedIndex = i;
			break;
		}
}

function change_selections()
{
	if (!this.form.elements) return; // this control is not in form
	if (sel_container.length != 3) return; // there is some error
	// resolves each of 3 saved option values of needed drop-down menus
	for (i=0;i<3;i++)
		switch (sel_container[i][0]) {
			case "pr_range":
				var indrange = i;
				break;
			case "pr_group":
				var indgroup = i;
				break;
			case "pr_item":
				var inditem = i;
		}
	// finds each of 3 needed drop-down menus
	var elemrange = FindObject("pr_range");
	var elemgroup = FindObject("pr_group");
	var elemitem = FindObject("pr_item");
	// takes action depending on type of changed field
	switch (this.id) {
		case "pr_range":
			// update group field only with options in selected range
			update_selections(elemgroup, indgroup, this.options[this.selectedIndex].value);
			// update item field only with options in selected range
			update_selections(elemitem, inditem, this.options[this.selectedIndex].value);
			break;
		case "pr_group":
			var rangevalue = this.options[this.selectedIndex].value; // length 3 or 4
			// update range field only with options in selected range
			if (rangevalue != "0")
				rangevalue = rangevalue.substr(0,rangevalue.length-2); // extracts range (1 or 2 digits)
			mark_selections(elemrange, indrange, rangevalue);
			// update item field only with options in selected range
			update_selections(elemitem, inditem, this.options[this.selectedIndex].value);			
			break;
		case "pr_item":
			var rangevalue = this.options[this.selectedIndex].value; // length 5 or 6
			// update group field only with selected option
			if (rangevalue != "0")
				rangevalue = rangevalue.substr(0,rangevalue.length-2); // extracts group (3 or 4 digits)
			mark_selections(elemgroup, indgroup, rangevalue);
			// update range field only with selected option
			if (rangevalue != "0")
				rangevalue = rangevalue.substr(0,rangevalue.length-2); // extracts group (1 or 2 digits)
			mark_selections(elemrange, indrange, rangevalue);
	}
}