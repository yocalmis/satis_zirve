$(function(){
	$(".chosen-select:not(.isChosened),.chosen-multiple-select:not(.isChosened)").chosen({allow_single_deselect:true}).addClass('isChosened');
	$(".chosen-select,.chosen-multiple-select").addClass('isChosened');
});