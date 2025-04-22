// Ameya Gupta
// Apr. 14th 2025
// Image preview logic for post form

window.addEventListener('load', () => {
    document.getElementById('upload').addEventListener('change', () => {
        const uploadElem = document.getElementById('upload');
        const uploadPath = uploadElem.value;
        const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/;

        if (!allowedExtensions.exec(uploadPath)) {
            // if the file does not match one of the allowed extensions
            // add a disclaimer showing the user what files are allowed
            uploadElem.insertAdjacentHTML(
                'afterend',
                document.getElementById('ext-disc')
                    ? ''
                    : '<p id="ext-disc">file must be a JPG, JPEG, PNG, or GIF</p>'
            );
            uploadElem.value = '';
            return;
        } else {
            if (document.getElementById('ext-disc'))
                uploadElem.parentElement.removeChild(
                    document.getElementById('ext-disc')
                );

            if (uploadElem.files && uploadElem.files[0]) {
                const reader = new FileReader();
                reader.addEventListener('load', (e) => {
                    document.getElementById('upload-preview').src =
                        e.target.result;
                });

                reader.readAsDataURL(uploadElem.files[0]);
            }
        }
    });
});
