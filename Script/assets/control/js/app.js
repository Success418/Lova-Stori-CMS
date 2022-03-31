$(function() {

    $('.ui.dropdown').dropdown();

    $('.sidebar').sidebar('setting', 'transition', 'push', 'scrollLock');

    $('#mobile-menu-toggler').on('click', function()
    {
    	$('.sidebar').sidebar('toggle');
    })

    $('.modal .close').on('click', function()
    {
    	$('.modal').modal('hide');
    })


    $('.message .close').on('click', function()
    {
        $(this).closest('.message')
               .transition('fade');
    });
        
    $('#left-menu .dropdown').dropdown({
        on: 'hover',
        action: 'select'
    })

    $(document).on('click', '.item.disabled', function(e)
    {
        e.preventDefault();
        return false;
    })
    
    $('#mobile-menu .circular.label').on('click', function()
    {
        let subcategories      = JSON.parse(b64DecodeUnicode($(this).data('subcategories')));
        let subcategories_html = '';

        for(subcategory of subcategories)
        {
            var _url = base_url(`posts/subcategory/${url_title(subcategory)}`);

            subcategories_html += `<a href="${_url}" class="item"><i class="right angle icon"></i>${subcategory}</a>`;
        }

        $('#mobile-menu .subcategories').html(subcategories_html);
        $('#mobile-menu').addClass('subcategories-active')
    })


    $('#mobile-menu .back-menu-action').on('click', function() 
    {
        $('#mobile-menu').removeClass('subcategories-active');
    })


    $(window).on('resize', function() 
    {
        if($(this).width() > 1200)
            $('.sidebar').sidebar('hide');
    })


    $(document).on('click', 'button.file', function()
    {
        $(this).siblings('input[type="file"]').click();
    })

    $('#posts-by .button').on('click', function(){
        $('#posts-by').attr('class', $(this).data('slct'));
    })


    $('input[type="text"]').attr('spellcheck', false);


    $('#comments .reply').on('click', function()
    {
        let dataId = $(this).data('id');
        let author = $(this).closest('.content').find('.author').text();

        $('#reply-to input[name="reply-to"]').val(dataId);
        $('#reply-to span').text(author);
        $('#reply-to').show();
        $('#comment-form form textarea').focus();
    })

    $('#reply-to .delete.icon').on('click', function()
    {
        $('#reply-to input[name="reply-to"]').val('');
        $('#reply-to span').text('');
        $('#reply-to').hide();
    })
    

    $('.modal').each(function()
    {
        if($(this).hasClass('visible'))
        {
            $(this).modal('show');
        }
    })


    $('#change-lang a.item')
    .on('click', function()
    {
        $(this).siblings('input')
               .val($(this).data('lang'));

        $('#change-lang').submit();
    })
})