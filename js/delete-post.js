/**
 * Anita Jiang
 * April 12, 2025
 * AJAX to delete post from database + update dashboard details w/o reload
 */
document.addEventListener('DOMContentLoaded', function () {
    let confirmDialog = document.getElementById('confirmDialog');
    let confirmMessage = document.getElementById('confirmMessage');
    let cancelDelete = document.getElementById('cancelDelete');
    let deleteForm = document.getElementById('deleteForm');
    let deletePostIdInput = document.getElementById('deletePostId');

    let deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach((button) => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            let postId = this.getAttribute('data-post-id');
            let postTitle = this.getAttribute('data-post-title');

            confirmMessage.textContent = `are you sure you want to delete "${postTitle}"? You can't undelete posts!`;
            deletePostIdInput.value = postId;
            deleteForm.action = 'post-delete.php';
            confirmDialog.style.display = 'block';
        });
    });

    cancelDelete.addEventListener('click', function () {
        confirmDialog.style.display = 'none';
    });

    confirmDialog.addEventListener('click', function (e) {
        if (e.target === confirmDialog) {
            confirmDialog.style.display = 'none';
        }
    });

    deleteForm.addEventListener('submit', function (e) {
        e.preventDefault();

        let postId = deletePostIdInput.value;
        let formData = new FormData();
        formData.append('post_id', postId);

        fetch('post-delete.php', {
            method: 'POST',
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    let postElement = document.getElementById('post' + postId);
                    if (postElement) {
                        postElement.remove();
                    }

                    let postCountElement = document.querySelector(
                        '#userStats .stat-box:first-child .stat-number'
                    );
                    if (postCountElement) {
                        let currentCount = parseInt(
                            postCountElement.textContent
                        );
                        postCountElement.textContent = currentCount - 1;

                        // edge case if no posts left
                        if (currentCount - 1 === 0) {
                            let postsList =
                                document.getElementById('postsList');
                            postsList.innerHTML = `
                            <div id="noPosts">
                                <p>you haven't created any posts yet.</p>
                                <a href="../dashboard/" class="btn">create your first post</a>
                            </div>
                        `;
                        }
                    }
                } else {
                    console.error('Error deleting post:', data.message);
                }
                confirmDialog.style.display = 'none';
            })
            .catch((error) => {
                console.error('Error:', error);
                confirmDialog.style.display = 'none';
            });
    });
});
