// Ameya Gupta
// Apr. 14th 2025
// Login Page - Form Validation

import validate from './validate.js';

window.addEventListener('load', () => {
    let controller = new AbortController();
    const username = document.getElementById('username');
    const password = document.getElementById('password');

    const formState = {
        username: false,
        password: false,
    };

    validate(
        username,
        /^\w{1,20}$/,
        formState,
        'username should have no spaces and be between 1-20 chars.)',
        controller
    );
    validate(
        password,
        /\w{10,100}/,
        formState,
        'password should have 10 or more chars.',
        controller
    );

    document.getElementById('login-btn').addEventListener('click', () => {
        console.log('test');
        controller.abort();
    });
});
