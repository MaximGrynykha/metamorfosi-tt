<h1 class="mt-3">Posts</h1>
<div class="mt-5 row">
    <?php foreach ($posts as $index => $post): ?>
        <article class="container mb-4">
            <div class="card">
                <small class="card-header"><?= $post['published']; ?></small>
                <div class="card-body">
                    <h5 class="card-title"><?= $post['title']; ?></h5>
                    <p class="card-text"><?= $post['preview']; ?></p>
                    <?php foreach($post['categories'] as $category): ?>
                        <span class="badge badge-pill badge-secondary p-2">
                            <?= $category['name']; ?>
                        </span>
                    <?php endforeach; ?>
                    <br><br>
                    <a href="/posts/<?= $post['id']; ?>" class="btn btn-primary">Read more</a>
                </div>
            </div>  
        </article>
    <?php endforeach; ?>
</div>