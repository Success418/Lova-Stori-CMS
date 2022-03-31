function paginationHandler(page, maxPages, pagination, author_data_pagination)
{
    var parentSelector = page.replace('_page', '');

    if(pagination === 'next')
    {
        if(maxPages > author_data_pagination[page])
        {
            author_data_pagination[page] += 1;

            $('#author-data .' + parentSelector + ' .button[data-pagination="next"]')
            .siblings('.button')
            .prop('disabled', false);

            if(maxPages == author_data_pagination[page])
            {
                $('#author-data .' + parentSelector + ' .button[data-pagination="next"]')
                .prop('disabled', true);
            }
            
            return true;
        }
    }
    else
    {
        if(author_data_pagination[page] > 1)
        {
            $('#author-data .' + parentSelector + ' .button[data-pagination="prev"]')
            .siblings('.button')
            .prop('disabled', false);

            author_data_pagination[page] -= 1;

            if(author_data_pagination[page] == 1)
            {
                $('#author-data .' + parentSelector + ' .button[data-pagination="prev"]')
                .prop('disabled', true);
            }

            return true;
        }
    }

    return false;
}

function userPostsRow(post)
{
    return '<tr>\
                <td>\
                    <a href="'+ location.origin + '/post/' + post.slug +'">\
                        '+ post.title +'\
                    </a>\
                </td>\
                <td class="three wide right aligned">\
                    '+ post.date +'\
                </td>\
                <td class="three wide center aligned">\
                    <div class="ui star rating" data-rating="' + post.rating + '" data-max-rating="5"></div>\
                </td>\
                <td class="right aligned">\
                    '+ post.views +'\
                </td>\
            </tr>';
}

function userCommentsRow(comment)
{
    return '<tr>\
                <td>\
                    <a href="'+ location.origin + '/post/' + comment.post_slug +'#'+ comment.anchor +'">\
                        '+ comment.post_title +'\
                    </a>\
                </td>\
                <td class="three wide right aligned">\
                    '+ comment.date +'\
                </td>\
                <td class="three wide center aligned">\
                    <div class="ui circular yellow small icon button read-comment">\
                        <i class="eye icon mx-0"></i>\
                        <div class="body d-none">\
                            '+ comment.body.replace("\n", "<br>") +'\
                        </div>\
                    </div>\
                </td>\
            </tr>';
}

$(function() 
{
    $('form i.search.link').on('click', function()
    {
        console.log($(this).siblings('input[name="search"]').val().trim())
        if($(this).siblings('input[name="search"]').val().trim().length > 0)        
            $(this).closest('form').submit();
    })

    $('#categories-menu').slick({
      infinite: true,
      speed: 500,
      centerMode: false,
      variableWidth: true,
      arrows: true,
      slidesToScroll: 2,
      mobileFirst: true,
      draggable: false,
      prevArrow: '<span class="scroll prev"><i class="chevron inverted blue circular left icon mx-0"></i></span>',
      nextArrow: '<span class="scroll next"><i class="chevron inverted blue circular right icon mx-0"></i></span>',
    })
    
    $('.ui.dropdown').dropdown({
        transition: 'drop',
        action: 'hide'
    });

    $.post(location.origin+'/analytics', 
           {screen_size: {width: window.innerWidth, 
                          height: window.innerHeight}});

    $('.ui.rating').rating({maxRating: 5});

    $('.sidebar').sidebar('setting', 'transition', 'push', 'scrollLock');

    $('.message .close').on('click', function() 
    {
        $(this).closest('.message')
               .transition('fade');
    });

    if(localStorage.getItem('cookies') === null)
    {
        $('#cookies').css('visibility', 'visible');
    }

    $('#cookies button').on('click', function()
    {
        localStorage.setItem('cookies', 1);
        $('#cookies').fadeOut('slow');
    })

    $('#mobile-menu-toggler').on('click', function()
    {
    	$('.sidebar').sidebar('toggle');
    })


    $('.sign-in-form-toggler').on('click', function()
    {
    	$('#sign-in-form').modal('toggle');
    })


    $('.sign-up-form-toggler').on('click', function()
    {
    	$('#sign-up-form').modal('toggle');
    })


    $('.reset-pwd-form').on('click', function()
    {
        $('#reset-pwd-form').modal('toggle');
    })


    $('.modal .close:not(.message .close)').on('click', function() 
    {
    	$('.modal').modal('hide');
    })


    $(document)
    .on('click', '#mobile-menu .categories .ui.item > .header:not(.active)', function()
    {
        var subcategories = $(this).siblings('.subcategories');

        if(subcategories.length)
        {
            $('#mobile-menu .items > .subcategories')
            .html(subcategories.html())
            .show()
            .siblings('.categories')
            .hide();
        }
    })

    $(document)
    .on('click', '#mobile-menu .back', function()
    {
        $(this).closest('.subcategories')
        .hide()
        .siblings('.categories')
        .show();
    })


    $(document)
    .on('click', '#mobile-menu i.close', function()
    {
        $('#mobile-menu').sidebar('hide');
    })

    $('.contact-form-toggler').on('click', function() 
    {
    	$('#contact-form').modal('toggle');
    })



    $('#left-menu .dropdown').dropdown({
        on: 'hover',
        action: 'select'
    })


    $('#r-side').append('<div id="l-menu-popup"></div>');


    $('#left-menu .item')
    .mouseover(function(e) 
    {
        var items = $('.items', this);

        if(items.length)
        {
            $('#l-menu-popup').html(items.html()).show();
        }
        else
        {
            $('#l-menu-popup').hide();
        }
    })

    $('#left-menu .item, #l-menu-popup')
    .mouseleave(function() 
    {
        setTimeout(function()
        {
            var menuItemHasHover = $('#left-menu .item:hover').length;
            var menuHasHover     = $('#l-menu-popup:hover').length;

            if(!(menuItemHasHover + menuHasHover))
            {
                $('#l-menu-popup').hide();
            }
        }, 1000)
    })

    $(window)
    .on('click', function(e)
    {
        if(!/^(l-menu-popup)$/.test(e.target.id))
        {
            $('#l-menu-popup').hide();
        }
    })

    $('#left-menu a.header:not(.active)')
    .hover(function()
    {
    	$('i', this).addClass('blue')
    				.removeClass('outline');
    }, function(){
    	$('i', this).addClass('outline')
    				.removeClass('blue');
    })

    $('#comments .reply')
    .on('click', function() 
    {
        let dataId = $(this).data('id');
        let author = $(this).closest('.content').find('.author').text();

        $('#reply-to input[name="reply_to"]').val(dataId);
        $('#reply-to span').text(author);
        $('#reply-to').show();
        $('#comment-form form textarea').focus();
    })

    $('#reply-to .delete.icon')
    .on('click', function() 
    {
        $('#reply-to input[name="reply_to"]').val('');
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

    $(document)
    .on('click', '#scrollbar-toggler .item', function()
    {        
        var item            = $(this).text().toLowerCase();
        var scrollbarToggle = (item === 'show') ? 0 : 1;
        var stylesheetUrl   = location.origin + '/assets/css/scrollbar.css?v=' + (new Date()).getTime();

        localStorage.setItem('scrollbar', scrollbarToggle);

        if(scrollbarToggle)
        {
            if(!$("#scrollbar").length)
                $('head').append('<link id="scrollbar" rel="stylesheet" href="'+ stylesheetUrl +'" >');
        }
        else
        {
            if($("#scrollbar").length)
                $("#scrollbar").remove();
        }
    })

    if(localStorage.getItem('scrollbar') === '0')
    {
        if($("#scrollbar").length)
            $("#scrollbar").remove();
    }

    $('#style-toggler, #change-lang')
    .on('change', function() {
        $(this).submit();
    })

    $('form.search').form({
        fields: {
            search: 'minLength[2]'
        }
    })

    $('html').css('visibility', 'visible');
})