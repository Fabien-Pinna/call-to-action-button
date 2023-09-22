import '../scss/custom-codemirror.scss';

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM Loaded');
    if (typeof wp === "undefined" || typeof wp.codeEditor === "undefined") {
        console.log("wp.codeEditor is not defined.");
        return;
    }
    console.log('wp.codeEditor is defined.');

    var textArea = document.getElementById('custom-css');
    if (!textArea) {
        console.log('textArea not found');
        return;
    }
    console.log('textArea found');

    var editorSettings = window.editorSettings || {};
    console.log('Editor Settings:', editorSettings);

    editorSettings.codemirror = Object.assign({}, editorSettings.codemirror, {
        mode: 'css',
        lineNumbers: true,
        indentUnit: 4,
        tabSize: 4,
        lineWrapping: true
    });

    console.log('Updated Editor Settings:', editorSettings);

    var editor = wp.codeEditor.initialize(textArea, editorSettings);
    console.log('Editor initialized:', editor);
});
console.log('custom-codemirror.js loaded')