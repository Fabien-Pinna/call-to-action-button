document.addEventListener('DOMContentLoaded', (event) => {
    const iconList = ['fas fa-gift', 'fas fa-car', 'fas fa-bell', 'fas fa-heart'];
    const iconPicker = document.getElementById('icon-picker');
    const hiddenInput = document.getElementById('button_icon');

    iconList.forEach((icon) => {
        const iconElement = document.createElement('i');
        iconElement.className = icon;
        iconElement.addEventListener('click', function () {
            iconList.forEach((i) => iconPicker.getElementsByClassName(i)[0].classList.remove('selected'));
            this.classList.add('selected');
            hiddenInput.value = this.className;
        });

        if (hiddenInput.value === icon) {
            iconElement.classList.add('selected');
        }

        iconPicker.appendChild(iconElement);
    });
});
