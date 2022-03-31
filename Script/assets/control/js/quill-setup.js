$(function()
{
	var toolbarOptions = [
	    ['bold', 'italic', 'underline', 'strike'],
	    ['blockquote', 'code-block'],
	    ['link', 'image', 'video'],
	    [{'list': 'ordered'}, {'list': 'bullet'}],
	    [{'script': 'sub'}, {'script': 'super'}],
	    [{'indent': '-1'}, {'indent': '+1'}],
	    [{'direction': 'rtl'}],
	    [{'size': ['small', false, 'large', 'huge']}],
	    [{'header': [1, 2, 3, 4, 5, 6, false]}],
	    [{'color': []}, {'background': []}],
	    [{'font': []}, {'align': []}],
	    ['clean'],
	    ['fullscreen']/*,
	    ['source']*/
	];


	var quillIcons = Quill.import('ui/icons');
	quillIcons['fullscreen'] = '<strong><i class="expand icon m-0"></i></strong>';


	window.quill = new Quill('#quill_editor', {
		modules: {
			toolbar: toolbarOptions,
			imageResize: {}
		},
		theme: 'snow'
	});


	quill.on('text-change', function() 
	{
	  	$('#quill_editor iframe.ql-video').popup({
			popup: $('#vid-resize.ui.popup'),
		    inline     : true,
		    hoverable  : true,
		    position   : 'bottom left',
		    delay: {
		      show: 200,
		      hide: 200
		    }
		});
	});


	$(document)
	.on('change', '#vid-resize input:not("#vid-index")', function() 
	{
		let h = parseInt($('#vid-h').val())>0 ? `${$('#vid-h').val()}px` : '';
		let w = parseInt($('#vid-w').val())>0 ? `${$('#vid-w').val()}px` : '';
		let a = $('#align').val();
		var m = 'auto';

		switch(a)
		{
			case 'left':
				m = '0 auto 0 0';
				break;
			case 'right':
				m = '0 0 0 auto';
				break;
			case 'center':
			case 'justify':
				m = '0 auto';
				break;
		}

		$($('#quill_editor iframe.ql-video').get($('#vid-index').val())).css({
			width: w,
			height: h,
			display: 'block',
			'max-width': '100%',
			'margin': m
		});

		quill.updateContents();

		$('#item_body').val(quill.root.innerHTML);
	})



	$('form.post').on('submit', function(event)
	{
		if(quill.root.innerHTML.trim().length)
		{
			$('#item_body')
			.val(b64EncodeUnicode(Html5Entities.decode(quill.root.innerHTML)));
		}
	})
	

	$(document)
	.on('click', '#quill_editor_wrapper .ql-toolbar .expand.icon', 
	function() 
	{
		$('#quill_editor_wrapper').toggleClass('fullscreen');
	})

})