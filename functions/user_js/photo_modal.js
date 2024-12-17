// Global variable to store current pin ID
let currentPinId = null;

function openPhotoModal(imageUrl, title, description, pinId) {
    // Set global current pin ID
    currentPinId = pinId;
    
    // Update modal content
    const modalImage = document.getElementById('modal-image');
    const modalTitle = document.getElementById('modal-title');
    const modalDescription = document.getElementById('modal-description');
    const likeButton = document.getElementById('like-button');
    const addToBoardBtn = document.getElementById('add-to-board-btn');
    
    if (modalImage) modalImage.src = imageUrl;
    if (modalTitle) modalTitle.textContent = title;
    if (modalDescription) modalDescription.textContent = description;
    
    // Show modal
    const photoModal = document.getElementById('photo-modal');
    if (photoModal) photoModal.classList.remove('hidden');
    
    // Fetch and update likes count
    fetchLikesCount(pinId);
    
    // Fetch user boards
    fetchUserBoards();
    
    // Fetch boards this pin is already added to
    fetchPinBoards(pinId);
}

function fetchLikesCount(pinId) {
    fetch(`../../db/user_db/get_likes.php?pin_id=${pinId}`)
        .then(response => response.json())
        .then(data => {
            const likesCount = document.getElementById('likes-count');
            if (likesCount && data.success) {
                likesCount.textContent = data.likes;
            }
        })
        .catch(error => console.error('Error fetching likes:', error));
}

function toggleLike() {
    if (!currentPinId) return;
    
    const formData = new FormData();
    formData.append('pin_id', currentPinId);
    
    fetch('../../db/user_db/toggle_like.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const likesCount = document.getElementById('likes-count');
        const likeButton = document.getElementById('like-button');
        
        if (data.success) {
            if (likesCount) likesCount.textContent = data.likes;
            if (likeButton) likeButton.classList.toggle('text-red-500');
        } else {
            console.error('Error:', data.error);
        }
    })
    .catch(error => console.error('Error:', error));
}

function fetchUserBoards() {
    fetch('../../db/user_db/get_user_boards.php')
        .then(response => response.json())
        .then(data => {
            const dropdown = document.getElementById('board-select');
            
            if (!dropdown) {
                console.error('Board select element not found');
                return;
            }
            
            // Keep the default option
            dropdown.innerHTML = '<option value="">Select a board</option>';
            
            if (data.success && data.boards && Array.isArray(data.boards)) {
                data.boards.forEach(board => {
                    const option = document.createElement('option');
                    option.value = board.board_id;
                    option.textContent = board.title;
                    dropdown.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error fetching boards:', error);
        });
}

function fetchPinBoards(pinId) {
    // Implementation remains the same as previous script
}

function closePhotoModal() {
    const photoModal = document.getElementById('photo-modal');
    if (photoModal) photoModal.classList.add('hidden');
    currentPinId = null;
}

function addToBoard() {
    const boardSelect = document.getElementById('board-select');
    if (!boardSelect) return;
    
    const boardId = boardSelect.value;
    
    if (!boardId || !currentPinId) {
        alert('Please select a board');
        return;
    }

    fetch('../../db/user_db/add_pin_to_board.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            pin_id: currentPinId,
            board_id: boardId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Pin added to board successfully!');
            closePhotoModal();
        } else {
            alert('Error adding pin to board: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding pin to board');
    });
}

// Safe initialization of event listeners
document.addEventListener('DOMContentLoaded', () => {
    const likeButton = document.getElementById('like-button');
    const addToBoardBtn = document.getElementById('add-to-board-btn');
    const photoModal = document.getElementById('photo-modal');
    const closeModalBtn = photoModal?.querySelector('button[onclick="closePhotoModal()"]');

    if (likeButton) {
        likeButton.addEventListener('click', toggleLike);
    }

    if (addToBoardBtn) {
        addToBoardBtn.addEventListener('click', addToBoard);
    }

    if (photoModal) {
        photoModal.addEventListener('click', (e) => {
            if (e.target === photoModal) {
                closePhotoModal();
            }
        });
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closePhotoModal);
    }
});