document.addEventListener('DOMContentLoaded', (event) => {
    const {
        buttonLabel = 'Click Me',
        buttonLinkTarget = '#',
        labelColor = '#000000',
        buttonColor = '#000000',
        buttonQuerySelector = '',
        buttonIcon = 'fa-regular fa-heart'
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
    buttonText.setAttribute('class', 'donation-button-text');
    buttonText.appendChild(document.createTextNode(buttonLabel.toUpperCase()));

    const iconBox = document.createElement('div');
    iconBox.setAttribute('class', 'icon-box');

    const faIcon = document.createElement('i');
    faIcon.className = buttonIcon;
    faIcon.style.color = labelColor;
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
