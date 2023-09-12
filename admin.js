document.addEventListener('DOMContentLoaded', (event) => {
    const {
        buttonLabel = 'Click Me',
        buttonLinkTarget = '#',
        labelColor = '#000000',
        buttonColor = '#000000',
        buttonQuerySelector = ''
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

    button.onmouseover = function () {
        this.style.backgroundColor = labelColor;
        this.style.color = buttonColor;
        this.style.borderColor = buttonColor;
    }

    button.onmouseout = function () {
        this.style.backgroundColor = buttonColor;
        this.style.color = labelColor;
        this.style.borderColor = labelColor;
    }

    const renderIconHeart = node => {
        const iconHeart = document.createElementNS(
            'http://www.w3.org/2000/svg',
            'svg'
        )
        const iconPath = document.createElementNS(
            'http://www.w3.org/2000/svg',
            'path'
        )

        iconHeart.setAttribute('height', '44')
        iconHeart.setAttribute('width', '44')
        iconHeart.setAttribute('fill', buttonColor)

        iconPath.setAttribute(
            'd',
            'M20.14 10.198L22 12.083l3.667-3.325a9.555 9.555 0 015.016-1.425c2.56 0 5.014 1.03 6.824 2.864a9.846 9.846 0 012.826 6.915c0 7.164-11 19.555-18.333 19.555-7.334 0-18.333-12.39-18.333-19.554a9.846 9.846 0 012.826-6.915 9.586 9.586 0 016.824-2.864 9.583 9.583 0 016.823 2.864z'
        )
        iconPath.setAttribute('stroke', labelColor)
        iconPath.setAttribute('stroke-width', '1.5px')
        iconPath.setAttribute('stroke-linecap', 'round')
        iconPath.setAttribute('stroke-linejoin', 'round')

        iconHeart.appendChild(iconPath)
        return node.appendChild(iconHeart)

    }
    renderIconHeart(button);
    button.appendChild(document.createTextNode(buttonLabel.toUpperCase()));


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