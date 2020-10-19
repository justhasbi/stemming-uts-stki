<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
	<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
	<title>STEMMING</title>
</head>
<body>
	<header>
		<nav>
			<ul class="nav-list">
                <li><a href="<?= base_url() ?>">Home</a></li>
				<li><a href="<?= base_url('upload') ?>">Upload File</a></li>
			</ul>
		</nav>
    </header>
    <main>
        <div class="container">
            <form enctype="multipart/form-data" method="POST" action="<?= base_url('welcome/pdfreader') ?>">
                File yang di upload : <input type="file" class="form-control" name="fupload"><br>
                Deskripsi File : <br>
                <textarea name="deskripsi" rows="8" cols="40"></textarea><br>
                <input type=submit value=Upload class="btn-form">
            </form>
        </div>
    </main>
</body>
</html>