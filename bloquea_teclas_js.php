<script> 
function checkShortcut() 
{ 
if(event.keyCode==8 || event.keyCode==13) 
{ 
return false;
}
/*if(history.go(-1) != null){
	history.go(1);
}*/
 
} 
</script>
<body onload="checkShortcut();">
<input type="text" onFocus="x=true" onBlur="x=false">
</body>
