import $ from 'jquery';

export const createDOMElement = function (typeString, classString, content) {

    let $element = $("<" + typeString + ">", {
        class: classString
    });

    $element.html(content);

    return $element;
};

export const retrieveElementId = function (element) {
    let $element = $(element);
    return $element ? $element.data('lyric_id') : null;
};