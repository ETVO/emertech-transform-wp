jQuery(function($){

	var wp = window.wp;
    const { __ } = wp.i18n;

	var imageContainer = $('.emertech-image-preview');
	var imageInput = $('.emertech-image-input');
	var imageUpload = $('.emertech-image-upload');
	var imageRemove = $('.emertech-image-remove');

	// on upload button click
	$('body').on( 'click', '.emertech-image-upload', function(e){

		e.preventDefault();

		var button = $(this),
		custom_uploader = wp.media({
			title: __('Inserir imagem'),
			library : {
				// uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
				type : 'image'
			},
			button: {
				text: __('Selecionar imagem') // button label text
			},
			multiple: false
		}).on('select', function() { // it also has "open" and "close" events
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			imageContainer.html('<img src="' + attachment.url + '">');
			imageInput.val(attachment.id);
			imageRemove.show();
		}).open();
	
	});

	// on remove button click
	$('body').on('click', '.emertech-image-remove', function(e){

		e.preventDefault();

		var button = $(this);
		imageContainer.html('');
		imageInput.val('');
		imageRemove.hide();
	});

});