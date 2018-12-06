document.addEventListener('DOMContentLoaded', () => {
	tinymce.init({
		selector: '#TintMCE',
		branding: false,
	});

	$(document).on('focusin', function (e) {
		if ($(e.target).closest(".mce-window").length) {
			e.stopImmediatePropagation();
		}
	});
})