import '../scss/custom-codemirror.scss';

document.addEventListener('DOMContentLoaded', () => {
    if (typeof wp === "undefined" || typeof wp.codeEditor === "undefined") {
        return;
    }

    const textArea = document.getElementById('custom-css');
    if (!textArea) {
        return;
    }

    const editorSettings = window.editorSettings || {};

    editorSettings.codemirror = Object.assign({}, editorSettings.codemirror, {
        mode: 'css',
        lineNumbers: true,
        indentUnit: 4,
        tabSize: 4,
        lineWrapping: true,
        styleActiveLine: true,
        matchBrackets: true,
        autoCloseBrackets: true,
        autoCloseTags: true,
        showTrailingSpace: true,
        extraKeys: {
            "Ctrl-Space": "autocomplete",
            "Ctrl-S": "save",
            "Ctrl-F": "findPersistent"

        }
    });

    const editor = wp.codeEditor.initialize(textArea, editorSettings);

});
