document.addEventListener('DOMContentLoaded', function() {
    const masonryContainer = document.querySelector('.masonry');

    async function getData() {
        const url = "../../db/user_db/images_fetch.php";
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`Response status: ${response.status}`);
            }
      
            const json = await response.json();

            masonryContainer.innerHTML = ''; // Clear existing content

            for (let i = 0; i < json.length; i++) {
                const itemDiv = document.createElement('div');
                itemDiv.classList.add('item', `item${i + 1}`);

                // Create image container
                const imageContainer = document.createElement('div');
                imageContainer.className = 'image-container';

                // Create image element
                const img = document.createElement('img');
                img.src = json[i].image_url;
                img.alt = json[i].title || `Pin ${i + 1}`;

                // Add click handler to open modal
                imageContainer.addEventListener('click', () => {
                    openPhotoModal(
                        json[i].image_url,
                        json[i].title,
                        json[i].description,
                        json[i].pin_id
                    );
                });

                // Create overlay
                const overlay = document.createElement('div');
                overlay.className = 'pin-overlay';
                overlay.innerHTML = `
                    <h3>${json[i].title || 'Untitled'}</h3>
                    <p>${json[i].description || ''}</p>
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
            }
        } catch (error) {
            console.error(error.message);
        }
    }

    getData();
});

function displayImages(images) {
    const masonry = document.querySelector('.masonry');
    masonry.innerHTML = ''; // Clear existing content

    images.forEach(image => {
        const pin = document.createElement('div');
        pin.className = 'pin';
        
        // Create container for image and overlay
        const imageContainer = document.createElement('div');
        imageContainer.className = 'image-container';
        
        // Create the image element
        const img = document.createElement('img');
        img.src = image.image_url;
        img.alt = image.title;
        img.loading = 'lazy';
        
        // Add click handler to open modal
        imageContainer.addEventListener('click', () => {
            openPhotoModal(
                image.image_url,
                image.title,
                image.description,
                image.pin_id
            );
        });
        
        // Add hover overlay
        const overlay = document.createElement('div');
        overlay.className = 'pin-overlay';
        overlay.innerHTML = `
            <h3>${image.title}</h3>
            <p>${image.description}</p>
        `;
        
        // Assemble the pin
        imageContainer.appendChild(img);
        imageContainer.appendChild(overlay);
        pin.appendChild(imageContainer);
        masonry.appendChild(pin);
    });
}