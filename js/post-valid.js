import validate from './validate.js';

window.addEventListener('load', () => {
    let permController = new AbortController();
    let optionalController = new AbortController();
    const title = document.getElementById('title');
    const content = document.getElementById('content');
    const listOnMarket = document.getElementById('market');
    const price = document.getElementById('price');
    const stock = document.getElementById('stock');

    function addDisclaimer() {
        document.getElementById('post-details').children = document
            .getElementById('post-details')
            .children.slice(1);
    }

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
            e.preventDefault();
            document.getElementById('post-disc').style.display = 'block';
        }

        if (listOnMarket.checked && !(formState.price && formState.stock)) {
            console.log('check');
            e.preventDefault();
            document.getElementById('post-disc').style.display = 'block';
        }
    });

    // validate(title, /.{1,50}/, 'title cannot be longer than 50 chars.');
    // validate(title, /.{1,50}/, 'title cannot be longer than 50 chars.');
});
