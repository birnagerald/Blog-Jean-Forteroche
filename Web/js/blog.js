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


	$(".add-comment").click((e) => {

		e.preventDefault()

		let id = $(e.currentTarget).data("id");
		let author = $("input").val();
		let content = $("textarea").val();
		$.ajax({
			url: '/commenter-' + id + '.html', // La ressource ciblée
			type: 'POST', // Le type de la requête HTTP.
			dataType: 'text',
			data: {
				auteur: author,
				contenu: content,
				id: id
			},
			success: function (data, textStatus, xhr) {
				let bodyPart = data.split('<body>')
				let bodyPart2 = bodyPart[1].split('</body>')
				console.log(bodyPart2[0])

				if (xhr.status == 200) {
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
					Command: toastr["success"]("Commentaire posté !", "Succès")
					$("body").html(bodyPart2[0])

				}

			},
			complete: function (xhr, textStatus) {
				if (xhr.status == 400) {
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