window.addEventListener('load', () => {
    let controller;
    const createRadio = document.getElementById('create');
    const username = document.getElementById('username');
    const password = document.getElementById('password');

    const formState = {
        username: false,
        password: false,
    };

    function validate(elem, pattern, msg, controller) {
        elem.addEventListener(
            'input',
            () => {
                elem.value = elem.value.trim(); // remove whitespaces
                const elemLabel = document.querySelector(
                    `legend[for='${elem.id}']`
                );
                if (elem.value.match(pattern)) {
                    elemLabel.innerHTML =
                        String(elem.id[0]).toLocaleUpperCase() +
                        elem.id.slice(1);
                    elemLabel.style.color = 'var(--dark)';
                    formState[elem.id] = true;
                } else {
                    elemLabel.innerHTML = `
                    ${
                        String(elem.id[0]).toLocaleUpperCase() +
                        elem.id.slice(1)
                    } * <small>(${msg})</small>`;
                    elemLabel.style.color = 'orangered';
                    formState[elem.id] = false;
                }
            },
            { signal: controller.signal }
        );
    }

    document.getElementById('create-btn').addEventListener('click', () => {
        controller = new AbortController();
        validate(
            username,
            /^\w{1,20}$/,
            'username should be between 1-20 chars.)',
            controller
        );
        validate(
            password,
            /\w{10,100}/,
            'password should have 10 or more chars.',
            controller
        );
    });

    document.getElementById('login-btn').addEventListener('click', () => {
        console.log(controller);
        controller.abort();
    });
});
