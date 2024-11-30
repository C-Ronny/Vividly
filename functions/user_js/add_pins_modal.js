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
toggle.addEventListener('change', () => {
  if (!(toggle.checked)) {
      modal.classList.add('hidden');  // Hide the modal
  } else {
      modal.classList.remove('hidden');  // Show the modal
  }
});




function previewImage(event) {
  const file = event.target.files[0]; // Get the selected file
  const reader = new FileReader();
  
  reader.onload = function(e) {
      const preview = document.getElementById('preview');
      preview.src = e.target.result; // Set the preview image source to the uploaded file
      preview.classList.remove('hidden'); // Show the preview image
  };
  
  if (file) {
      reader.readAsDataURL(file); // Read the file as a data URL
  } else {
      // If no file is selected, hide the preview
      const preview = document.getElementById('preview');
      preview.classList.add('hidden');
  }
}