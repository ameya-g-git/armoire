// Irene Chen
// April 14th, 2025
// AJAX to load post data from the database and generate HTML components from them

window.addEventListener('load', function (event) {
    url = '../feed/load-feed.php';
    parentElement = document.getElementById('feed');

    // make and append post component using information gathered from posts table
    function makePost(data) {
        console.log(data);
        for (const post of data['posts']) {
            let image = getImage(data['images'], post['post_id']);
            let imgElem = image
                ? `<img src="${image}" alt="Post image" class="post-thumbnail">`
                : '';

            let postHTML = `
            <div class="post-item" id="post<?php echo $post['post_id'];">
                <div class="post-header">
                    <h3>${post['title']}</h3>
                    <span>${post['date']}</span>
                </div>
                <a href="view_post.php?id=${post['post_id']}" class="post-link">
                    <div class="post-content">
                        ${post['content']}
                        ${imgElem}
                    </div>
                    <div class="post-stats">
                        <span>ovations: ${post['ovation']}</span>
                        ${
                            post['price']
                                ? `<span>price: ${post['price']}</span>`
                                : ''
                        }
                        ${
                            post['price']
                                ? `<span>stock: ${post['stock']}</span>`
                                : ''
                        }
                    </div>
                </a>
            </div>`;
            parentElement.insertAdjacentHTML('beforeend', postHTML);
        }
    }

    // get image from images table
    function getImage(images, post_id) {
        const i = images.findIndex((img) => img['post_id'] == post_id);

        let imageurl = i >= 0 ? images[i]['image_url'] : '';
        return imageurl;
    }

    // fetch request
    fetch(url)
        .then((response) => {
            return response.json();
        })
        .then(makePost);
});
