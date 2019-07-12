$(document).ready(function(){
	var calcText = "";
	$('button').click(function(){
		if($(this).val() == '='){
			if(calcText != 0){
				var total = result(calcText);
				calcText = total;
				$(".box").html(total);
			}
		}else if($(this).val() == 'del'){
			del();
		}else{
			calcText += $(this).val();
			$(".box").html(calcText);
		}
	})

	function result(x){
		return eval(x);
	}
	function del(){
		if(calcText.length > 0){
			x = calcText.substring(0,calcText.length - 1);
			calcText = x;
			$(".box").html(calcText);
		}else{
			calcText = '';
			$(".box").html('0');
		}
	}
})