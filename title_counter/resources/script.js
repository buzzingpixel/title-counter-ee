function runTitleCounter() {
    'use strict';

    function runCheck($input, theLimit, warningLevel, $count, $counterWrap) {
        var val = $input.val();
        var length = val.length;

        if (length > theLimit) {
            $input.val(val.substr(0, theLimit));
            length = theLimit;
        }

        $count.text(length);

        if (length >= warningLevel) {
            $counterWrap.addClass('TitleCounter--Warning');
        } else {
            $counterWrap.removeClass('TitleCounter--Warning');
        }

        if (length >= theLimit) {
            $counterWrap.addClass('TitleCounter--LimitReached');
        } else {
            $counterWrap.removeClass('TitleCounter--LimitReached');
        }
    }

    var segments;
    var isPublish;
    var $title;
    var $counterWrap;
    var $count;
    var $limit;
    var theLimit;
    var warningLevel;

    if (window.$ === undefined) {
        setTimeout(function() {
            runTitleCounter();
        }, 10);
        return;
    }

    segments = window.location.search.substr(2).split('/');
    isPublish = segments[0] === 'cp' && segments[1] === 'publish';

    if (! isPublish) {
        return;
    }

    theLimit = window.TITLE_COUNTER_LIMIT;
    warningLevel = theLimit * 0.65;
    $counterWrap = $(window.TITLE_COUNTER_TEMPLATE);
    $count = $counterWrap.find('.JSTitleCounter__Count');
    $limit = $counterWrap.find('.JSTitleCounter__Limit');
    $title = $('[name="title"]');

    $title.prop('maxlength', theLimit);

    $count.text($title.val().length);

    $limit.text(theLimit);

    $title.after($counterWrap);

    runCheck($title, theLimit, warningLevel, $count, $counterWrap);

    $title.on('keydown keyup change', function() {
        runCheck($title, theLimit, warningLevel, $count, $counterWrap);
    });
}

runTitleCounter();
