<div class="mt-5"><a href="/">🠤 Home</a></div>
<h1 class="mt-3">Authentication</h1>
<form action="/login" method="POST">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" id="name">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" id="password">
    </div>

    <button type="submit" class="mt-3 btn btn-primary">Login</button>
</form>