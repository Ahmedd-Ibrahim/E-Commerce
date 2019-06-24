$(function (){
    'use strict';
 /** palceholder action */
    $('[placeholder]').focus(function(){
        $(this).attr('data-text',$(this).attr('placeholder'));

        $(this).attr('placeholder','');
    });
    /** palceholder action */
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
    /**toggle between login form and signup form */

    $('.login-page h2 span').click(function(){
       $(this).addClass('active').siblings().removeClass('active');
       $('.login-page form').hide();
       $('.' + $(this).data('class')).fadeIn(100);
    });
    /**preview within write */
    $('.live').keyup(function (){
     $($(this).data('class')).text($(this).val())
    });
    
});