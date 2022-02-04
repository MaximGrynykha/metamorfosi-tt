<div class="mt-5"><a href="/">🠤 Home</a></div>
<h1 class="mt-3"><?= $post['title']; ?></h1>
<div class="mt-5 row">
    <article class="container mb-5">
        <div class="card-body p-0 m-0">
            <div class="mb-4"><small>PUBLISHED: <?= $post['created_at']; ?></small></div>
            <p class="card-text"><?= $post['content']; ?></p>
            <?php foreach($post['categories'] as $category): ?>
                <span class="badge badge-pill badge-secondary p-2">
                    <?= $category['name']; ?>
                </span>
            <?php endforeach; ?>
            <br><br>
        </div>
    </article>
</div>