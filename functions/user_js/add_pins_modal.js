const modal = document.getElementById('crud-modal');
const toggle = document.getElementById('toggle'); // The new toggle checkbox
const overlay = document.getElementById('modal-overlay'); // The modal overlay
const closeButton = modal.querySelector('[data-modal-toggle="crud-modal"]'); // Close button (if any)

// Toggle to show modal when the checkbox is checked
toggle.addEventListener('change', () => {
    if (toggle.checked) {
        modal.classList.remove('hidden');  // Show the modal
    } else {
        modal.classList.add('hidden');  // Hide the modal
    }
});

// Close modal when the overlay is clicked
overlay.addEventListener('click', () => {
    toggle.checked = false;  // Uncheck the toggle checkbox to hide the modal
});

// Close modal when the close button is clicked (optional)
closeButton.addEventListener('click', () => {
    toggle.checked = false;  // Uncheck the toggle checkbox to hide the modal
});
