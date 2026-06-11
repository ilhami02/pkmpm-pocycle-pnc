import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// === Image Preview for Scan Upload ===
document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const uploadPlaceholder = document.getElementById('upload-placeholder');

    if (imageInput) {
        imageInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (ev) {
                    if (previewImg) {
                        previewImg.src = ev.target.result;
                        previewImg.classList.remove('hidden');
                    }
                    if (uploadPlaceholder) {
                        uploadPlaceholder.classList.add('hidden');
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
