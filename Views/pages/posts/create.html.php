<form action="/dashboard/posts" method="POST">
    <select name="category" class="custom-select mb-4 mt-5">
        <option selected>Choose category</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
        <?php endforeach; ?>
    </select>

    <div class="form-group">
        <label for="formGroupExampleInput">Title</label>
        <input name="title"  type="text" class="form-control" id="formGroupExampleInput" placeholder="Never leave that till tomorrow which you can do today.">
    </div>

    <div class="mb-3">
        <label for="formGroupExampleInput">Content</label>
        <textarea name="content" class="form-control" placeholder="The difference between ordinary and extraordinary is that little extra." required rows="6"></textarea>
    </div>

    <button class="mt-3 btn btn-primary" type="submit">Create post</button>
</form>