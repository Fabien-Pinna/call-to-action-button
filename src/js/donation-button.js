import '../scss/donation-button.scss'

document.addEventListener('DOMContentLoaded', (event) => {
    const {
        buttonLabel = 'Click Me',
        labelColor = '#000000',
        buttonColor = '#000000',
        labelFontSize = '1em',
        iconSize = '1em',
        buttonLinkTarget = '#',
        buttonQuerySelector = '',
        buttonIcon = 'fas fa-heart'
    } = localizedObject;

    const button = document.createElement('a');
    setAttributes(button, {
        href: buttonLinkTarget,
        target: '_blank',
        class: 'donation-button',
        style: `
        background-color: ${buttonColor}; 
        color: ${labelColor};
        border-color: ${labelColor};
        `
    });

    const buttonText = document.createElement('span');
    setAttributes(buttonText, {
        class: 'donation-button-text',
        style: `font-size: ${labelFontSize};`
    })
    buttonText.appendChild(document.createTextNode(buttonLabel.toUpperCase()));


    const iconBox = document.createElement('div');
    iconBox.setAttribute('class', 'icon-box');

    const faIcon = document.createElement('i');
    setAttributes(faIcon, {
        class: buttonIcon.replace('selected', ''),
        style: `
        color: ${labelColor};
        font-size: ${iconSize};`
    });
    iconBox.appendChild(faIcon);

    button.onmouseover = function () {
        this.style.backgroundColor = labelColor;
        this.style.color = buttonColor;
        this.style.borderColor = buttonColor;
        faIcon.style.color = buttonColor;
    };

    button.onmouseout = function () {
        this.style.backgroundColor = buttonColor;
        this.style.color = labelColor;
        faIcon.style.color = labelColor;
    };

    button.appendChild(iconBox);
    button.appendChild(buttonText);

    const header = document.querySelector(buttonQuerySelector);
    if (header) {
        header.appendChild(button);
    }

    function setAttributes(el, attrs) {
        for (let key in attrs) {
            el.setAttribute(key, attrs[key]);
        }
    }
});
