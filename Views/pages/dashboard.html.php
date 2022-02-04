<div class="mt-5"><a href="/">🠤 Home</a></div>
<h1 class="mt-3">Dashboard</h1>
<a href="/dashboard/posts/create" class="mt-4 btn btn-secondary text-white">Create new post</a>

<?php if (app()->session->hasFlash('success')): ?>
        <div class="mt-3 alert alert-success">
        <?= app()->session->getFlash('success'); ?>
    </div>
<?php endif ?>

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
                    <a href="/dashboard/posts/<?= $post['id']; ?>/edit" class="btn btn-primary">Edit</a>
                    <form action="/dashboard/posts/<?= $post['id']; ?>" method="POST" class="btn p-0 m-0">
                        <input name="_method" type="hidden" value="DELETE">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>  
        </article>
    <?php endforeach; ?>
</div>