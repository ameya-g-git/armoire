window.addEventListener('load', () => {
    document.getElementById('market').addEventListener('input', () => {
        if (document.getElementById('market').checked) {
            document.getElementById('marketplace-input').style.display = 'none';
        } else {
            document.getElementById('marketplace-input').style.display = 'flex';
            document.getElementById('price').value = '';
            document.getElementById('stock').value = '';
        }
    });
});
