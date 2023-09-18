import { iconList } from './iconList';
import '../scss/admin-picker.scss';

document.addEventListener('DOMContentLoaded', (event) => {
    const iconPicker = document.getElementById('icon-picker');
    const hiddenInput = document.getElementById('button_icon');

    console.log(iconList);

    iconList.forEach((iconObj) => {
        const iconElement = document.createElement('i');
        iconElement.className = iconObj.icon;
        iconElement.addEventListener('click', function () {
            iconList.forEach((i) => {
                const existingElement = iconPicker.getElementsByClassName(i.icon)[0];
                if (existingElement) {
                    existingElement.classList.remove('selected');
                }
            });
            this.classList.add('selected');
            hiddenInput.value = this.className;
        });

        if (hiddenInput.value === iconObj.icon) {
            iconElement.classList.add('selected');
        }

        iconPicker.appendChild(iconElement);
    });
});
