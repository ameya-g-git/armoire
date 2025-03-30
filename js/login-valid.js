import validate from './validate';

window.addEventListener('load', () => {
    let controller;
    const username = document.getElementById('username');
    const password = document.getElementById('password');

    const formState = {
        username: false,
        password: false,
    };

    username.addEventListener('input', () => {
        username.value.trim();
    });
    password.addEventListener('input', () => {
        password.value.trim();
    });

    document.getElementById('create-btn').addEventListener('click', () => {
        controller = new AbortController();
        validate(
            username,
            /^\w{1,20}$/,
            formState,
            'username should be between 1-20 chars.)',
            controller
        );
        validate(
            password,
            /\w{10,100}/,
            formState,
            'password should have 10 or more chars.',
            controller
        );
    });

    document.getElementById('login-btn').addEventListener('click', () => {
        controller.abort();
    });
});
