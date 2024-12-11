// Get references to the profile photo link and the modal
const profilePhotoLink = document.getElementById('profile_photo');
const fileDropModal = document.querySelector('.bg-gray-100.h-screen');
const fileDropModalClose = document.getElementById('close');

// Initially hide the modal
fileDropModal.style.display = 'none';

// Add click event listener to the "Update Profile Photo" link
profilePhotoLink.addEventListener('click', (e) => {
    e.preventDefault(); // Prevent default link behavior
    fileDropModal.style.display = 'flex'; // Show the modal
});

// Add click event listener to the close button
fileDropModalClose.addEventListener('click', (e) => {
    fileDropModal.style.display = 'none'; // Hide the modal
});


// Add functionality to close the modal (optional but recommended)
fileDropModal.addEventListener('click', (e) => {
    // Close modal if clicking outside the modal content
    if (e.target === fileDropModal) {
        fileDropModal.style.display = 'none';
    }
});

// Existing dropzone code (keeping the previous handleFiles logic)
const dropzone = document.getElementById('dropzone');
const fileInput = document.getElementById('fileInput');
const fileList = document.getElementById('fileList');

dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('border-blue-500', 'border-2');
});

dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('border-blue-500', 'border-2');
});

dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('border-blue-500', 'border-2');

    const files = e.dataTransfer.files;
    handleFiles(files);
});

fileInput.addEventListener('change', (e) => {
    const files = e.target.files;
    handleFiles(files);
});

function handleFiles(files) {
    fileList.innerHTML = '';

    for (const file of files) {
        const listItem = document.createElement('div');
        listItem.textContent = `${file.name} (${formatBytes(file.size)})`;
        fileList.appendChild(listItem);
    }
}

function formatBytes(bytes) {
    if (bytes === 0) return '0 Bytes';

    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));

    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}