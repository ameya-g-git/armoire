// Ameya Gupta
// Apr. 14th 2025
// Post Creation - Form Validation

import validate from './validate.js';

// client-side validation for post form
window.addEventListener('load', () => {
    let permController = new AbortController();
    let optionalController = new AbortController();
    const title = document.getElementById('title');
    const content = document.getElementById('content');
    const listOnMarket = document.getElementById('market');
    const price = document.getElementById('price');
    const stock = document.getElementById('stock');

    const formState = {
        title: false,
        content: false,
        price: false,
        stock: false,
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
            // don't allow submit if there isn't a title and content
            e.preventDefault();
            document.getElementById('post-disc').style.display = 'block';
        }

        if (listOnMarket.checked && !(formState.price && formState.stock)) {
            // don't allow post if the user has not filled in price and stock details, if they checked the listOnMarket checkbox
            e.preventDefault();
            document.getElementById('post-disc').style.display = 'block';
        }
    });
});
