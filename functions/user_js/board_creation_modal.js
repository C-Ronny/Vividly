// boards.js
function openBoardModal() {
    document.getElementById('board-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('board-modal').classList.add('hidden');
}

// Handle form submission
document.getElementById('board-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    
    try {
        const response = await fetch('../../db/user_db/create_board.php', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        
        if (data.success) {
            closeModal();
            location.reload(); // Refresh to show new board
        }
    } catch (error) {
        console.error('Error:', error);
    }
});
