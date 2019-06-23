$(function (){
    'use strict';

    $('[placeholder]').focus(function(){
        $(this).attr('data-text',$(this).attr('placeholder'));

        $(this).attr('placeholder','');
    });
    $('[placeholder]').blur(function (){
        $(this).attr('placeholder',$(this).attr('data-text'));
    })
    $('.full').click(function(){
        $('.panel-body .box').css({
            'transition' : 'all .23s',
                'height' : '52px',
        });
    });
    $('.classic').click(function(){
        $('.panel-body .box').css({
            'transition' : 'all .23s',
                'height' : '0px',
        });
    });
});