(function () {
    if(window.hljs) {
        document.querySelectorAll('pre code').forEach((el) => {
            window.hljs.highlightElement(el);
        })
    } else {
        console.warn('hljs was not found!')
    }
})();
