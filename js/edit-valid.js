// Ameya Gupta
// Apr. 14th 2025
// Post Editing - Form Validation

import validate from './validate.js';

window.addEventListener('load', () => {
    let permController = new AbortController();
    let optionalController = new AbortController();
    const title = document.getElementById('title');
    const content = document.getElementById('content');
    const listOnMarket = document.getElementById('market');
    const price = document.getElementById('price');
    const stock = document.getElementById('stock');

    // only difference between this and post-valid.js is that
    // if the post has already been posted, formState should begin as all true
    const formState = {
        title: true,
        content: true,
        price: true,
        stock: true,
    };

    validate(
        title,
        /^.{1,50}$/,
        formState,
        'title cannot be empty or more than 50 chars.',
        permController
    );
    validate(
        content,
        /^.{1,2000}$/,
        formState,
        'post content cannot be empty or more than 2000 chars.',
        permController
    );

    listOnMarket.addEventListener('change', () => {
        if (listOnMarket.checked) {
            validate(
                price,
                /^\d+$|^\d+.\d{2}$/,
                formState,
                'in dollar amount',
                optionalController
            );

            validate(
                stock,
                /\d+/,
                formState,
                'should be an integer value',
                optionalController
            );
        } else {
            formState.price = false;
            formState.stock = false;
        }
    });

    document.getElementById('post-details').addEventListener('submit', (e) => {
        if (!(formState.title && formState.content)) {
            e.preventDefault();
            document.getElementById('post-disc').style.display = 'block';
        }

        if (listOnMarket.checked && !(formState.price && formState.stock)) {
            e.preventDefault();
            document.getElementById('post-disc').style.display = 'block';
        }
    });
});
