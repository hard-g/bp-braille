( function( window, $, app ) {
	var cache = {
		'messages': {},
		'groups': {}
	};

	// Constructor
	app.init = function() {
		app.bindEvents();
	};

	// Combine all events
	app.bindEvents = function() {
		$('#message-thread').on('click', '.message-braille-actions a', app.messagesHandler );
		$('.bbp-admin-links').on('click', '.braille-action', app.groupsHandler )
	};

	app.messagesHandler = function(event) {
		var $link    = $(this);
			$content = $link.parent().parent().siblings('.message-content');
			id       = $link.data('message-id');

		if ( cache['messages'][ id ] !== undefined ) {
			app.toggleText( cache['messages'][ id ], $link, $content );

			return false;
		}

		$content.addClass('braille-loading');

		$.post( ajaxurl, {
			action: 'bp_messages_braille',
			'message_id': id,
			'content': $content.html().trim(),
			'nonce': $link.data('braille-nonce')
		}, function(response) {
			if ( true === response.success ) {
				$content.removeClass('braille-loading');

				app.toggleText( response.data, $link, $content );

				// Cache results
				cache['messages'][ id ] = response.data;
			}
		});

		return false;
	};

	app.groupsHandler = function(event) {
		var $link = $(this),
			reply_id = $link.data('reply-id'),
			group_id = $link.data('group-id'),
			$content = $( '.post-' + reply_id ).find('.bbp-reply-content');

		if ( cache['groups'][ reply_id ] !== undefined ) {
			app.toggleText( cache['groups'][ reply_id ], $link, $content );

			return false;
		}

		$content.addClass('braille-loading');

		$.post( ajaxurl, {
			action: 'bp_groups_braille',
			'reply_id': reply_id,
			'group_id': group_id,
			'content': $content.html().trim(),
			'nonce': $link.data('braille-nonce')
		}, function(response) {
			if ( true === response.success ) {
				$content.removeClass('braille-loading');

				app.toggleText( response.data, $link, $content );

				// Cache results
				cache['groups'][ reply_id ] = response.data;
			}
		});

		return false;
	}

	app.toggleText = function(text, link, content) {
		if ( link.hasClass('braille-on' ) ) {
			link.removeClass('braille-on').addClass('braille-off');
			link.text( bpBraille.strings.off );

			content.html( text.braille );
		} else {
			link.removeClass('braille-off').addClass('braille-on');
			link.text( bpBraille.strings.on );

			content.html( text.original );
		}
	};

	// Engage
	$( app.init );

} ( window, jQuery, {} ) );
