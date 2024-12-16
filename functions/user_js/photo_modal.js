document.addEventListener('DOMContentLoaded', function() {
    console.log('Modal script loaded');
    
    const modal = document.getElementById('photo-modal');
    const modalImage = document.getElementById('modal-image');
    const modalTitle = document.getElementById('modal-title');
    const modalDescription = document.getElementById('modal-description');
    const likeButton = document.getElementById('like-button');
    const likesCount = document.getElementById('likes-count');
    const commentForm = document.getElementById('comment-form');
    const commentsContainer = document.getElementById('comments-container');
    let currentPinId = null;

    // Add click event to all images (including dynamically added ones)
    document.body.addEventListener('click', function(e) {
        if (e.target.classList.contains('item ')) {
            console.log('Image clicked:', e.target);
            console.log('Pin ID:', e.target.dataset.pinId);
            currentPinId = e.target.dataset.pinId;
            openModal(e.target);
            fetchPinDetails(currentPinId);
        }
    });

    // Close modal
    document.getElementById('close-modal').addEventListener('click', () => {
        modal.classList.add('hidden');
        document.body.classList.remove('modal-open');
    });

    // Like functionality
    likeButton.addEventListener('click', async () => {
        try {
            const response = await fetch('../../db/user_db/toggle_like.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ pin_id: currentPinId })
            });
            const data = await response.json();
            
            if (data.success) {
                likeButton.classList.toggle('liked');
                likesCount.textContent = data.likes_count;
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });

    // Comment form submission
    commentForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const commentInput = document.getElementById('comment-input');
        const comment = commentInput.value.trim();

        if (!comment) return;

        try {
            const response = await fetch('../../db/user_db/add_comment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    pin_id: currentPinId,
                    comment: comment
                })
            });
            const data = await response.json();
            
            if (data.success) {
                addCommentToDOM(data.comment);
                commentInput.value = '';
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
});

function openModal(img) {
    const modal = document.getElementById('photo-modal');
    const modalImage = document.getElementById('modal-image');
    
    modalImage.src = img.src;
    modal.classList.remove('hidden');
    document.body.classList.add('modal-open');
}

async function fetchPinDetails(pinId) {
    try {
        const response = await fetch(`../../db/user_db/get_pin_details.php?pin_id=${pinId}`);
        const data = await response.json();
        
        if (data.success) {
            updateModalContent(data);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

function updateModalContent(data) {
    document.getElementById('modal-title').textContent = data.caption;
    document.getElementById('modal-description').textContent = data.description;
    document.getElementById('likes-count').textContent = data.likes_count;
    
    // Update comments
    const commentsContainer = document.getElementById('comments-container');
    commentsContainer.innerHTML = '';
    data.comments.forEach(comment => addCommentToDOM(comment));
}

function addCommentToDOM(comment) {
    const commentsContainer = document.getElementById('comments-container');
    const commentElement = document.createElement('div');
    commentElement.className = 'comment';
    commentElement.innerHTML = `
        <p class="font-semibold text-gray-200">${comment.user_name}</p>
        <p class="text-gray-300">${comment.comment}</p>
        <small class="text-gray-400">${comment.created_at}</small>
    `;
    commentsContainer.appendChild(commentElement);
} 