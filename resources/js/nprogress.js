import NProgress from 'nprogress';
import 'nprogress/nprogress.css';

document.addEventListener('DOMContentLoaded', function() {
    NProgress.configure({ showSpinner: true });

    function startLoading() {
        NProgress.start();
    }

    function stopLoading() {
        NProgress.done();
    }

    // Start NProgress on page load
    startLoading();

    // Stop NProgress on window load
    window.addEventListener('load', function() {
        stopLoading();
    });

    // Start NProgress on AJAX start
    $(document).ajaxStart(function() {
        startLoading();
    });

    // Stop NProgress on AJAX stop
    $(document).ajaxStop(function() {
        stopLoading();
    });

    // Turbolinks events (if you are using Turbolinks)
    document.addEventListener('turbolinks:request-start', function() {
        startLoading();
    });

    document.addEventListener('turbolinks:load', function() {
        stopLoading();
    });

    document.addEventListener('turbolinks:before-render', function() {
        stopLoading();
    });
});
