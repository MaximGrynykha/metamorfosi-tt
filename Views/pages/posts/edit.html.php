<form action="/dashboard/posts/<?= $post['id']; ?>" method="POST">
    <input name="_method" type="hidden" value="PUT">

    <select name="category" class="custom-select mb-4 mt-5">
        <option selected>Choose category</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
        <?php endforeach; ?>
    </select>

    <div class="form-group">
        <label for="formGroupExampleInput">Title</label>
        <input name="title" type="text" class="form-control" id="formGroupExampleInput" placeholder="Never leave that till tomorrow which you can do today." value="<?= $post['title']; ?>">
    </div>

    <div class="mb-3">
        <label for="formGroupExampleInput">Content</label>
        <textarea name="content" class="form-control" placeholder="The difference between ordinary and extraordinary is that little extra." required rows="6"><?= $post['content']; ?></textarea>
    </div>

    <button class="mt-3 btn btn-primary" type="submit">Edit post</button>
</form>