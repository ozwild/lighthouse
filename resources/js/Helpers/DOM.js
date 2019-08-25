import $ from 'jquery';

export function createDOMElement({classNames = [] | '', content = "", type = 'div', editable = false, $container = null} = {}) {

    let $element = $("<" + type + ">")
        .addClass(classNames)
        .html(content);

    if (editable) {
        $element.attr('contenteditable', true);
    }

    if ($container) {
        $element.appendTo($container);
    }

    return $element;

}

export function createDOMButton({classNames = ['btn'], icon = "", handler = null, content = ""} = {}) {

    let $element = createDOMElement({type: 'button', classNames, content});

    if (icon)
        $element.append(createDOMElement({classNames: ['material-icons'], type: "i", content: icon}));

    if (handler) {
        $element.on('click', handler);
    }

    return $element;
}

export const retrieveElementId = function (element) {
    let $element = $(element);
    return $element ? $element.data('lyric_id') : null;
};