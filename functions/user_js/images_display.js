document.addEventListener('DOMContentLoaded', function() {
    const masonryContainer = document.querySelector('.masonry');
    getData(); // Load all pins initially
});

async function getData(categoryId = null) {
    let url = "../../db/user_db/images_fetch.php";
    if (categoryId) {
        url = `../../db/user_db/get_pins_by_category.php?category_id=${categoryId}`;
    }

    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
  
        const json = await response.json();
        displayImages(json);
    } catch (error) {
        console.error(error.message);
    }
}

function filterByCategory(categoryId) {
    // Update active category visual state
    document.querySelectorAll('.category-name a').forEach(link => {
        link.classList.remove('active');
        if (parseInt(link.dataset.category) === categoryId) {
            link.classList.add('active');
        }
    });

    // Fetch and display pins for the selected category
    getData(categoryId);
}

function displayImages(images) {
    const masonryContainer = document.querySelector('.masonry');
    masonryContainer.innerHTML = ''; // Clear existing content

    images.forEach((image, index) => {
        const itemDiv = document.createElement('div');
        itemDiv.classList.add('item', `item${(index % 20) + 1}`);

        // Create image container
        const imageContainer = document.createElement('div');
        imageContainer.className = 'image-container';

        // Create image element
        const img = document.createElement('img');
        img.src = image.image_url;
        img.alt = image.caption || `Pin ${index + 1}`;

        // Add click handler to open modal
        imageContainer.addEventListener('click', () => {
            openPhotoModal(
                image.image_url,
                image.caption,
                image.description,
                image.pin_id
            );
        });

        // Create overlay
        const overlay = document.createElement('div');
        overlay.className = 'pin-overlay';
        overlay.innerHTML = `
            <h3>${image.caption || 'Untitled'}</h3>
            <p>${image.description || ''}</p>
            <p class="text-sm mt-2">By ${image.fname} ${image.lname}</p>
        `;

        // Determine grid row span
        const rowSpans = [10, 15, 20, 25, 30];
        const randomRowSpan = rowSpans[Math.floor(Math.random() * rowSpans.length)];
        itemDiv.style.gridRow = `span ${randomRowSpan}`;

        // Assemble the pin
        imageContainer.appendChild(img);
        imageContainer.appendChild(overlay);
        itemDiv.appendChild(imageContainer);
        masonryContainer.appendChild(itemDiv);
    });
}

function createPin(pin) {
    const pinElement = document.createElement('div');
    pinElement.className = 'pin';
    
    // Create the hover overlay
    const overlay = document.createElement('div');
    overlay.className = 'pin-overlay';
    
    // Use caption instead of title
    const title = document.createElement('h3');
    title.textContent = pin.caption || 'Untitled';
    title.className = 'pin-title';
    
    overlay.appendChild(title);
    
    // Create the image element
    const img = document.createElement('img');
    img.src = pin.image_url;
    img.alt = pin.caption;
    img.loading = 'lazy';
    
    // Add click event listener for the modal
    pinElement.addEventListener('click', () => {
        openPhotoModal(pin.image_url, pin.caption, pin.description, pin.pin_id);
    });
    
    pinElement.appendChild(img);
    pinElement.appendChild(overlay);
    
    return pinElement;
}