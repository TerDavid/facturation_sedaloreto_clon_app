
/**
 * Function to populate a <select> element.

 */
function populateSelect(selectId, options) {
    console.log('populateSelect called with:', selectId, options);
    try {
        let selectElement;
        if (selectId instanceof HTMLElement) {
            selectElement = selectId;
        }
        else {
            selectElement = document.getElementById(selectId);
        }
        if (!selectElement) {
            console.error(`Select element with ID "${selectId}" not found.`);
            return;
        }

        // Clear existing options
        selectElement.innerHTML = '';

        // Add new options
        options.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option.value; // Assuming the API returns an object with a "value" property
            opt.textContent = option.label; // Assuming the API returns an object with a "label" property
            selectElement.appendChild(opt);
        });
    } catch (error) {
        console.error('Error fetching options:', error);
    }
}
