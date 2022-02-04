<!doctype html>
<html lang="ru">
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 
	
	<link 
		rel="stylesheet" 
		href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" 
		integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" 
		crossorigin="anonymous">

	<title>Hello, world!</title>

	<style>
		body {
			font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
		}
	</style>
</head>
<body>	
	<main class="container">
		<?php if (! app()->isGuest()): ?>
			<div class="row mt-5 justify-content-between">
				<?php if (app()->request->getPath() !== '/dashboard') : ?>
					<div class="mt-1 col"><a href="/dashboard">Dashboard</a></div>
				<?php endif; ?>
				<form action="/logout" method="POST" class="flex align-items-end justify-content-end m-0 p-0">
					<button type="submit" class="btn btn-dark align-self-end">Logout</button>
				</form>
			</div>
		<?php else: ?>
			<div class="row mt-5 justify-content-between">
				<div class="mt-1 col"></div>
				<div class="flex align-items-end justify-content-end m-0 p-0">
					<a href="/login" class="btn btn-dark align-self-end">Login</a>
				</div>
			</div>
		<?php endif; ?>
        {{ content }}
    </main>

	<script 
		src="https://code.jquery.com/jquery-3.5.1.slim.min.js" 
		integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" 
		crossorigin="anonymous">
	</script>
	<script 
		src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" 
		crossorigin="anonymous">
	</script>
</body>
</html>
