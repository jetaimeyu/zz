$(function(){
    $('.confirmDelLink').click(function(){
        if (confirm('您确实要删除吗？')) {
            return true;
        }
        return false;
    });
    $('.confirmLink').click(function(){
        if (confirm($(this).attr('confirmMessage'))) {
            return true;
        }
        return false;
    });
});

var showMessage = function(message, showTime, fa) {
    $('#alertMessage').show();
    $('#alertMessage span').html(message);
    if(fa) {
        $('#alertMessage i').attr('class', 'fa fa-fw ' + fa);
    }
    if(showTime > 0) {
        setTimeout(function(){
            hideMessage();
        }, showTime * 1000);
    }
};

var hideMessage = function() {
    $('#alertMessage').hide();
    $('#alertMessage span').html('');
};

var showLoading = function(message) {
    if(!message) {
        message = '正在加载..';
    }
    showMessage(message, 0, 'fa-spinner fa-pulse');
};

var showOkMessage = function (message, showTime) {
    showMessage(message, showTime, 'fa-check');
};

