// Ameya Gupta
// Apr. 14th 2025
// Base Form Validation Function

export default function validate(elem, regex, formState, msg, controller) {
    elem.addEventListener(
        'input',
        () => {
            // elem.value = elem.value.trim(); // remove whitespaces
            const elemLabel = document.querySelector(
                `legend[for='${elem.id}']`
            );
            if (elem.value.match(regex)) {
                // if the content matches the regex, give visual feedback showing it's good
                elemLabel.innerHTML =
                    String(elem.id[0]).toLocaleUpperCase() + elem.id.slice(1);
                elemLabel.style.color = 'var(--dark)';
                formState[elem.id] = true;
            } else {
                // otherwise, make the title of the field orangered and append a message to show what's wrong
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
