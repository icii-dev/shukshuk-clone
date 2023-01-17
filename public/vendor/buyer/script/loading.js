function startLoading() {
    $('html').append('<div id="ajaxForm">\n' +
        '    <div class="loader">\n' +
        '        <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>\n' +
        '    </div>\n' +
        '</div>');
}
function stopLoading() {
    $('#ajaxForm').remove();
}