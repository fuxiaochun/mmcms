// JavaScript Document
//@author Fu Xiaochun

$(function() {
	//导航选中效果
	$(".nav li,.left li").click(function(){
		$(this).addClass("on").siblings('li').removeClass('on');
	});
});
