    $('.deleteJob').click(function(e) {
        e.preventDefault();
        var $link = $(this);
        bootbox.confirm("Are you Sure want to delete!", function (confirmation) {
            confirmation && document.location.assign($link.attr('href'));
        });        
    });