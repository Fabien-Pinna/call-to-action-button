import '../scss/admin-picker.scss';

document.addEventListener('DOMContentLoaded', (event) => {
    function updateIconList() {
        fetch(window.location.origin + '/webinfab-sandbox/index.php/wp-json/myplugin/v1/icons/')
            .then(async response => {
                if (response.ok) {
                    return response.json();
                } else {
                    const text = await response.text();
                    throw new Error(text);
                }
            })
            .then(data => {
                const iconPicker = document.getElementById('icon-picker');
                const hiddenInput = document.getElementById('button_icon');


                // Add icons to the icon picker
                data.forEach((iconObj) => {
                    const iconBox = document.createElement('div')
                    const iconElement = document.createElement('i')

                    iconBox.className = 'box-icon';
                    iconElement.className = iconObj.id;

                    iconElement.addEventListener('click', function () {
                        const existingElements = iconPicker.getElementsByClassName('selected');
                        Array.from(existingElements).forEach(el => el.classList.remove('selected'));
                        iconBox.classList.add('selected');
                        hiddenInput.value = iconObj.id;
                    });

                    if (hiddenInput && hiddenInput.value === iconObj.id) {
                        iconBox.classList.add('selected');
                    }

                    iconBox.appendChild(iconElement);
                    iconPicker.appendChild(iconBox);
                });
            })
            .catch(error => {
                console.error("Error fetching icons:", error)
            });
    }

    // Call the function to update the icon list
    updateIconList()
});
