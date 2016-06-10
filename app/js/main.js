$(document).ready(function(){
    $('.model a').venobox();

    var $forceUpdateButton = $('[data-action="forceUpdate"]');
    $forceUpdateButton.on('click', function forceUpdate(){
        $forceUpdateButton.text('Updating...');
        $.ajax({
            url: 'api.php?resource=models&action=reload',
            type: 'post'
        }).then(function(){
            window.location.reload();
        });
    });

    function getSortFunction(attribute) {
        switch (attribute) {
            case 'data-date':
                return function(a,b) {
                    return (new Date(b.elm.getAttribute(attribute))) - (new Date(a.elm.getAttribute(attribute)));
                };
            case 'data-views':
            case 'data-likes':
                return function(a,b){
                    return parseInt(b.elm.getAttribute(attribute), 10) - parseInt(a.elm.getAttribute(attribute), 10);
                };
        }
    }

    $('button[data-action]').on('click', function(){
        var $this = $(this);
        var attribute = $this.attr('data-action').replace('sort', 'data');
        $('button[data-action]').removeClass('active');
        $this.addClass('active');
        tinysort('ul.skfb-grid>li', { sortFunction: getSortFunction(attribute)});
    });
});
