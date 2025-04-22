// Ameya Gupta
// 400556266
// April 13th 2025
// Adds/Removes the Price and Stock fields while creating/updating a post

window.addEventListener('load', () => {
    document.getElementById('market').addEventListener('input', () => {
        if (document.getElementById('market').checked) {
            document.getElementById('marketplace-input').style.display = 'flex';
            document.getElementById('price').value = '';
            document.getElementById('stock').value = '';
        } else {
            document.getElementById('marketplace-input').style.display = 'none';
        }
    });
});
