export default function validate(elem, regex, formState, msg, controller) {
    elem.addEventListener(
        'input',
        () => {
            // elem.value = elem.value.trim(); // remove whitespaces
            const elemLabel = document.querySelector(
                `legend[for='${elem.id}']`
            );
            if (elem.value.match(regex)) {
                elemLabel.innerHTML =
                    String(elem.id[0]).toLocaleUpperCase() + elem.id.slice(1);
                elemLabel.style.color = 'var(--dark)';
                formState[elem.id] = true;
            } else {
                elemLabel.innerHTML = `
                ${
                    String(elem.id[0]).toLocaleUpperCase() + elem.id.slice(1)
                } * <small>(${msg})</small>`;
                elemLabel.style.color = 'orangered';
                formState[elem.id] = false;
            }
        },
        { signal: controller.signal }
    );
}
