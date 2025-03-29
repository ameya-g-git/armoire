window.addEventListener('load', () => {
    const accountBtns = document.querySelectorAll('#account-btns div');

    if (accountBtns) {
        accountBtns.forEach((elem) => {
            elem.addEventListener('click', () => {
                const radio = document.getElementById(elem.id.slice(0, -4)); // radio with id 'login' or `create`
                const createCheck = document.getElementById('create-check');
                const heading = document.getElementById('heading');
                const submitButton = document.getElementById('submit');

                radio.checked = true;
                elem.classList = 'active';

                if (radio.id == 'create') {
                    createCheck.checked = true;
                    heading.innerHTML = 'create account';
                    submitButton.value = 'create account!';
                } else {
                    createCheck.checked = false;
                    heading.innerHTML = 'log in';
                    submitButton.value = 'sign in!';
                }

                for (const btn of accountBtns) {
                    if (btn.id != elem.id) {
                        btn.classList = '';
                        btn.checked = false;
                    }
                }
            });
        });
    }
});
