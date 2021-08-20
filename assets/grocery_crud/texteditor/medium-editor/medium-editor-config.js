function initMediumEditor() {
	var elements = document.querySelectorAll('textarea.texteditor');
	function init(){
		var editor = new MediumEditor(elements);
		elements.forEach(function(elem) {
			elem.style.display = 'none';
			elem.style.visibility = 'hidden';
			elem.setAttribute('tab-index', -1);

		});
	}
	(typeof MediumEditor !== 'undefined') && init();
}
initMediumEditor()
window.addEventListener('DOMContentLoaded', function(event) {
	initMediumEditor()
});