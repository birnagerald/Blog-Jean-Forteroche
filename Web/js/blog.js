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

	$(".report-button").click((e) => {

		event.preventDefault()

		let id = $(e.currentTarget).data("id");
		$.ajax({
			url: '/comment-report-' + id + '.html', // La ressource ciblée
			type: 'GET', // Le type de la requête HTTP.
			success: function () {
				$("#"+id).append( '<p style="color: #ff0000"><strong>Commentaire signalé avec succès !<strong></p>' );
				
			} // données renvoyées
		});


	})
})