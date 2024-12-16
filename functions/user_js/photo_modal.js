let currentPinId = null;

function openPhotoModal(imageUrl, title, description, pinId) {
    currentPinId = pinId;
    
    // Update modal content
    document.getElementById('modal-image').src = imageUrl;
    document.getElementById('modal-title').textContent = title;
    document.getElementById('modal-description').textContent = description;
    
    // Show modal
    document.getElementById('photo-modal').classList.remove('hidden');
    
    // Fetch and update likes count
    fetchLikesCount(pinId);
    
    // Fetch and populate boards dropdown
    fetchUserBoards();
    
    // Fetch boards this pin is already added to
    fetchPinBoards(pinId);
}

function fetchLikesCount(pinId) {
    fetch(`../../db/user_db/get_likes.php?pin_id=${pinId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('likes-count').textContent = data.likes;
        });
}

function toggleLike() {
    if (!currentPinId) return;
    
    fetch('../../db/user_db/toggle_like.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `pin_id=${currentPinId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            fetchLikesCount(currentPinId);
        }
    });
}

function fetchUserBoards() {
    fetch('../../db/user_db/get_user_boards.php')
        .then(response => response.json())
        .then(data => {
            const dropdown = document.getElementById('boards-dropdown');
            dropdown.innerHTML = '<option value="">Select a board</option>';
            
            data.boards.forEach(board => {
                const option = document.createElement('option');
                option.value = board.board_id;
                option.textContent = board.title;
                dropdown.appendChild(option);
            });
        });
}

function fetchPinBoards(pinId) {
    fetch(`../../db/user_db/get_pin_boards.php?pin_id=${pinId}`)
        .then(response => response.json())
        .then(data => {
            const boardsList = document.getElementById('added-boards-list');
            boardsList.innerHTML = '';
            
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
        });
}

function closePhotoModal() {
    document.getElementById('photo-modal').classList.add('hidden');
    currentPinId = null;
}

// Initialize event listeners
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('like-button').addEventListener('click', toggleLike);
    
    document.getElementById('add-to-board-btn').addEventListener('click', () => {
        const boardId = document.getElementById('boards-dropdown').value;
        if (boardId && currentPinId) {
            addPinToBoard(currentPinId, boardId);
        }
    });

    // Close modal when clicking outside
    document.getElementById('photo-modal').addEventListener('click', (e) => {
        if (e.target.id === 'photo-modal') {
            closePhotoModal();
        }
    });

    // Close modal when clicking close button
    document.querySelector('#photo-modal button[onclick="closePhotoModal()"]')?.addEventListener('click', closePhotoModal);
}); 