import { iconList } from './iconList';
import '../scss/admin-picker.scss';

document.addEventListener('DOMContentLoaded', (event) => {
    const iconPicker = document.getElementById('icon-picker');
    const hiddenInput = document.getElementById('button_icon');

    // Vérifier si iconPicker et hiddenInput existent
    if (!iconPicker || !hiddenInput) {
        return; // Quitter la fonction si l'un des éléments n'existe pas
    }

    iconList.forEach((iconObj) => {
        const iconBox = document.createElement('div');
        const iconElement = document.createElement('i');
        const iconName = document.createElement('span');

        iconBox.className = 'icon-box';
        iconElement.className = iconObj.icon;
        iconName.className = 'icon-name';
        iconElement.title = iconObj.icon.replace('fa fa-', '');

        iconElement.addEventListener('click', function () {
            iconList.forEach((i) => {
                const existingElement = iconPicker.getElementsByClassName(i.icon)[0];
                if (existingElement) {
                    const parentBox = existingElement.parentNode;
                    parentBox.classList.remove('selected');
                }
            });
            iconBox.classList.add('selected');
            hiddenInput.value = iconObj.icon;
        });

        if (hiddenInput.value === iconObj.icon) {
            iconBox.classList.add('selected');
        }

        iconBox.appendChild(iconElement);
        iconPicker.appendChild(iconBox);
    });
});
