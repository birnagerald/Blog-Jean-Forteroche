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
			type: 'PUT', // Le type de la requête HTTP.
			success: function (data, textStatus, xhr) {
				if (xhr.status == 201) {
					$("#" + id).append('<p style="color: #ff0000"><strong>Commentaire signalé avec succès !<strong></p>');
				}

			}, // données renvoyées
			complete: function (xhr, textStatus) {
				if (xhr.status == 429) {
					$("#" + id).append('<p style="color: #ff0000"><strong>Ce commentaire a déjà été signalé !<strong></p>');
				} else if (xhr.status == 400) {
					$("#" + id).append('<p style="color: #ff0000"><strong>Erreur lors de l\'éxécution de la requête<strong></p>');
				} else if (xhr.status == 503) {
					$("#" + id).append('<p style="color: #ff0000"><strong>Service indisponible<strong></p>');
				}
			}

		});


	})


})