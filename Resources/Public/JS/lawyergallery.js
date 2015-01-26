$(function(){
    var pluginContainer = $('.tx-lawyergallery');
    var bigImageContainer = $('<div />').addClass('bigimage').appendTo(pluginContainer);
    var anchors = pluginContainer.find('img.thumbnail').closest('a');
    anchors.on('click', function() {
        var anchor = $(this);
        anchor.siblings().removeClass('active');
        anchor.addClass('active');
        bigImageContainer.html('');
        $('<img />').attr('src', anchor.find('img').attr('src')).appendTo(bigImageContainer);
        return false;
    }).first().click();
});
