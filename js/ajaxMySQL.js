function AjaxCall(page, values, label)
{
 if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  } 
  xmlhttp.onreadystatechange=
	function()
	{
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	  {
		 document.getElementById(label).innerHTML=xmlhttp.responseText;
	  }
	}
    alert(values)
  xmlhttp.open("GET",page+".php?"+values,true);
  xmlhttp.send();
}







