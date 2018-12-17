document.addEventListener('DOMContentLoaded', () => {
	tinymce.init({
		selector: '#TintMCE',
		formats: {
			bold: {
				inline: 'b',
				'classes': 'bold'
			},
			italic: {
				inline: 'i',
				'classes': 'italic'
			}

		}
	});

	$(document).on('focusin', function (e) {
		if ($(e.target).closest(".mce-window").length) {
			e.stopImmediatePropagation();
		}
	});

	$(".report-button").click((e) => {

		e.preventDefault()

		let id = $(e.currentTarget).data("id");

		$.ajax({
			url: '/comment-report-' + id + '.html', // La ressource ciblée
			type: 'PUT', // Le type de la requête HTTP.
			success: function (data, textStatus, xhr) {
				if (xhr.status == 201) {
					toastr.options = {
						"closeButton": false,
						"debug": false,
						"newestOnTop": false,
						"progressBar": false,
						"positionClass": "toast-bottom-right",
						"preventDuplicates": true,
						"onclick": null,
						"showDuration": "100",
						"hideDuration": "100",
						"timeOut": "2900",
						"extendedTimeOut": "1000",
						"showEasing": "linear",
						"hideEasing": "linear",
						"showMethod": "fadeIn",
						"hideMethod": "fadeOut"
					}
					Command: toastr["success"]("Commentaire signalé !", "Succès")
				}

			},
			complete: function (xhr, textStatus) {
				if (xhr.status == 429) {
					toastr.options = {
						"closeButton": false,
						"debug": false,
						"newestOnTop": false,
						"progressBar": false,
						"positionClass": "toast-bottom-right",
						"preventDuplicates": true,
						"onclick": null,
						"showDuration": "100",
						"hideDuration": "100",
						"timeOut": "2900",
						"extendedTimeOut": "1000",
						"showEasing": "linear",
						"hideEasing": "linear",
						"showMethod": "fadeIn",
						"hideMethod": "fadeOut"
					}
					Command: toastr["warning"]("Ce commentaire a déjà été signalé !", "Attention")
				} else if (xhr.status == 400) {
					toastr.options = {
						"closeButton": false,
						"debug": false,
						"newestOnTop": false,
						"progressBar": false,
						"positionClass": "toast-bottom-right",
						"preventDuplicates": true,
						"onclick": null,
						"showDuration": "100",
						"hideDuration": "100",
						"timeOut": "2900",
						"extendedTimeOut": "1000",
						"showEasing": "linear",
						"hideEasing": "linear",
						"showMethod": "fadeIn",
						"hideMethod": "fadeOut"
					}
					Command: toastr["error"]("Le commentaire n'est pas valide ou n'existe pas !", "Erreur")
				} else if (xhr.status == 503) {
					toastr.options = {
						"closeButton": false,
						"debug": false,
						"newestOnTop": false,
						"progressBar": false,
						"positionClass": "toast-bottom-right",
						"preventDuplicates": true,
						"onclick": null,
						"showDuration": "100",
						"hideDuration": "100",
						"timeOut": "2900",
						"extendedTimeOut": "1000",
						"showEasing": "linear",
						"hideEasing": "linear",
						"showMethod": "fadeIn",
						"hideMethod": "fadeOut"
					}
					Command: toastr["error"]("Le service est indisponible", "Erreur")
				}
			}

		});


	})


})