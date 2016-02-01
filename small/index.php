<style>
body{margin:0;background-color:#ececec;}
#main{position:relative;top:150px;}

#log_bg{width:750px; height:256px; margin:0 auto; background: url(bg.jpg) no-repeat center top;}
#login_form{width: 180px;margin:0 auto; height:155px; top:44px; position:relative;}
#login_form form{margin:0; padding:0;}

#login_form input{margin:0; padding:0; text-align:center;}
#login_form input{ width:144px; border:0;font-family:Verdana,Tahoma,Arial,sans-serif;font-size:12px; margin-top:14px; background-color:#ececec}
#auth_form{ text-align:center;position:absolute;left:303px;}

#ent_button{left:285px;top:59px;position:absolute; height:28px; width:180px; margin: 9px 0 0 0; display:block;}
#ent_button:hover{background: url(ent_but.jpg) no-repeat 0 0;}

#forg_button{left:285px;top:59px;position:absolute; height:15px; width:102px; margin: 46px 0 0 39px; display:block;}
#forg_button:hover{background: url(forg_but.jpg) no-repeat 0 0;}

#reg_button{left:285px;top:59px;position:absolute; height:26px; width:142px; margin: 82px 0 0 19px; display:block;}
#reg_button:hover{background: url(reg_but.jpg) no-repeat 0 0;}

</style>
<body>
<table id="main" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
	<td>
		<div id="log_bg">
			<div id="login_form">
				<form method="post" id="auth_form" action="../enter.php">
					<input type="submit" style="height:0; width:0; overflow:hidden; position:absolute;">
					<input onfocus="if(this.value == 'Логин') this.value  = '';" onblur="if(this.value == '') this.value = 'Логин';" type="text" name="logins" value="Логин"  maxlength=30 >
					<input id="temp" onfocus="this.style.display = 'none'; getElementById('real').style.display = 'inline'; getElementById('real').focus();" type="text" name="" value="Пароль">
					<input style="display:none" id="real" onblur="if(this.value == '') {getElementById('temp').style.display = 'inline'; this.style.display = 'none';}" type="password" name="psw" value="">
				</form>
				<a id="ent_button"  href="javascript:document.getElementById('auth_form').submit();"></a>
				<a id="forg_button" href="../remind.php" onclick="window.open(this.href, 'remind', 'width=500, height=230');return false;"></a>
				<a id="reg_button"  href="../reg.php"></a>
			</div>
		</div>
	</td>
</tr>
</table>