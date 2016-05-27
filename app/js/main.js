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
});
