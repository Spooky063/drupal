(function ($) {
    if(window.hljs) {
        document.querySelectorAll('pre code').forEach((el) => {
            window.hljs.highlightElement(el);
        })
    } else {
        console.warn('hljs was not found!')
    }

    $.fn.themeChangeCallback = function(style) {
        document.querySelectorAll('.codestyle').forEach((el) => {
            el.setAttribute('disabled', true);
        })
        document.querySelector(`.codestyle[data-name=${style}]`).removeAttribute('disabled')
    }
})(jQuery);
