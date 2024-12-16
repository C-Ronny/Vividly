function openPhotoModal(imageUrl, title, description, pinId) {
    console.log('Opening modal for pin:', pinId);
    window.currentPinId = pinId;
    
    // Update modal content
    document.getElementById('modal-image').src = imageUrl;
    document.getElementById('modal-title').textContent = title;
    document.getElementById('modal-description').textContent = description;
    
    // Show modal
    document.getElementById('photo-modal').classList.remove('hidden');
    
    // Fetch and update likes count
    fetchLikesCount(pinId);
    
    // Add logging
    console.log('Fetching user boards...');
    fetchUserBoards();
    
    // Fetch boards this pin is already added to
    fetchPinBoards(pinId);
}

function fetchLikesCount(pinId) {
    fetch(`../../db/user_db/get_likes.php?pin_id=${pinId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('likes-count').textContent = data.likes;
            }
        })
        .catch(error => console.error('Error fetching likes:', error));
}

function toggleLike() {
    if (!window.currentPinId) return;
    
    const formData = new FormData();
    formData.append('pin_id', window.currentPinId);
    
    fetch('../../db/user_db/toggle_like.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('likes-count').textContent = data.likes;
            // Toggle active state of like button
            document.getElementById('like-button').classList.toggle('text-red-500');
        } else {
            console.error('Error:', data.error);
        }
    })
    .catch(error => console.error('Error:', error));
}

function fetchUserBoards() {
    fetch('../../db/user_db/get_user_boards.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (!data.success) {
                throw new Error(data.error || 'Failed to fetch boards');
            }
            
            const dropdown = document.getElementById('board-select');
            if (!dropdown) {
                console.error('Board select element not found');
                return;
            }
            
            // Keep the default option
            dropdown.innerHTML = '<option value="">Select a board</option>';
            
            if (data.boards && Array.isArray(data.boards)) {
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
    fetch(`../../db/user_db/get_pin_boards.php?pin_id=${pinId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (!data.success) {
                throw new Error(data.error || 'Failed to fetch boards');
            }
            
            const boardsList = document.getElementById('added-boards-list');
            boardsList.innerHTML = '';
            
            if (data.boards && Array.isArray(data.boards)) {
                data.boards.forEach(board => {
                    const boardItem = document.createElement('div');
                    boardItem.className = 'flex items-center justify-between p-2 bg-gray-100 dark:bg-gray-700 rounded';
                    boardItem.innerHTML = `
                        <span>${board.title}</span>
                        <button onclick="removePinFromBoard(${pinId}, ${board.board_id})" 
                                class="text-red-500 hover:text-red-700">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    boardsList.appendChild(boardItem);
                });
            }
        })
        .catch(error => {
            console.error('Error fetching pin boards:', error);
            // Optionally show user-friendly error message
            const boardsList = document.getElementById('added-boards-list');
            boardsList.innerHTML = '<div class="text-red-500">Failed to load boards</div>';
        });
}

function closePhotoModal() {
    document.getElementById('photo-modal').classList.add('hidden');
    window.currentPinId = null;
}

function addPinToBoard(pinId, boardId) {
    const formData = new FormData();
    formData.append('pin_id', pinId);
    formData.append('board_id', boardId);

    fetch('../../db/user_db/add_pin_to_board.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Pin added to board successfully!');
            fetchPinBoards(pinId);
            document.getElementById('boards-dropdown').value = '';
        } else {
            alert(data.error || 'Failed to add pin to board');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to add pin to board');
    });
}

function addToBoard() {
    const boardId = document.getElementById('board-select').value;
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

// Initialize event listeners
document.addEventListener('DOMContentLoaded', () => {
    // Like button handler
    document.getElementById('like-button').addEventListener('click', toggleLike);
    
    // Add to board button handler
    document.getElementById('add-to-board-btn').addEventListener('click', () => {
        const boardId = document.getElementById('boards-dropdown').value;
        if (!boardId) {
            alert('Please select a board');
            return;
        }
        
        if (window.currentPinId) {
            addPinToBoard(window.currentPinId, boardId);
        }
    });

    // Close modal handlers
    document.getElementById('photo-modal').addEventListener('click', (e) => {
        if (e.target.id === 'photo-modal') {
            closePhotoModal();
        }
    });

    document.querySelector('#photo-modal button[onclick="closePhotoModal()"]')?.addEventListener('click', closePhotoModal);
}); 