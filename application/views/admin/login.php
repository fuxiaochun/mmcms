<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台登录</title>
	<style type="text/css">
		*{margin:0;padding:0;}
		body{background-color: #eee;font-family: 'Microsoft YaHei';font-size: 14px;}
		.wrap{width: 300px;margin: 50px auto;}
		.logo{height: 50px;line-height: 50px;text-align: center;font-size: 18px;}
		.form > input{width:100%;padding: 4px 10px;height:40px;line-height:30px;border: 1px solid #CCC;background-color: #fff;box-sizing: border-box;margin-bottom: 5px;border-radius: 3px;}
		.form > button{width:100%;height: 40px;line-height: 40px;color: #FFF;background: #00f;border: 1px solid #11f;box-sizing: border-box;border-radius: 3px;cursor: pointer;font-size: 14px;}
	</style>
</head>
<body>
	<div class="wrap">
		<div class="logo">管理后台登录</div>
		<div class="form">
			<input placeholder="用户名" type="text" name="user">
			<input placeholder="密码" type="password" name="pwd">
			<input placeholder="认证码" type="password" name="captcha">
			<button class="submit">登 录</button>
		</div>
	</div>
<script type="text/javascript">
	var submitBtn = document.querySelector('button');
	var user = document.querySelector('input[name=user]');
	var pwd = document.querySelector('input[name=pwd]');
	var captcha = document.querySelector('input[name=captcha]');

	var isSubmit = false;
	var xhr = new XMLHttpRequest();

	function getData(){
		return {
			user: user.value.trim(),
			pwd:pwd.value.trim(),
			captcha:captcha.value.trim()
		}
	}

	function getFormData(data){
		var str = '';
		for(var k in data){
			str += '&' + k + '=' + data[k];
		}
		return str.substr(1);
	}

	function checkIsEmpty(data){
		for(var k in data){
			if (data[k] == '') {
				return true;
			}
		}
		return false;
	}

	function submitForm(){
		if (isSubmit) {
			return false;
		}
		isSubmit = true;

		var postData = getData();

		if (checkIsEmpty(postData)) {
			alert('用户名/密码/认证码缺一不可！');
			isSubmit = false;
			return false;
		}

		xhr.open('post', '/admin/login/check');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onreadystatechange = function(){
			var data = null;
			if(xhr.readyState == 4 && xhr.status == 200){
				if (xhr.responseText == '1') {
					window.location.href = '/admin/home';
				}else{
					isSubmit = false;
					alert('信息有误，请重登录！');
				}
			}
		}
		xhr.send(getFormData(postData));
	}

	document.body.onkeydown = function(event){
		var e = window.event || event;
		if (e.keyCode == 13) {
			submitForm();
		}
	}

	submitBtn.onclick = submitForm;
</script>
</body>
</html>