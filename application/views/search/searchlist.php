<?php $keyword = $this->input->get('q'); ?>
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
				<li><a href="<?= base_url('welcome/upload') ?>">Upload File</a></li>
			</ul> 
		</nav>
    </header>
    <main>
        <div class="container">
            <div class="Search-container">
                <h1 class="title-tag">Search Document</h1>
                <form enctype="multipart/form-data" method="GET" action="<?= base_url('welcome/search') ?>">
                    <input class="keyword" type="text" name="q" id="kata" value="">
                    <input class="btn-form" type="submit" value="Submit"/>
                </form>
            </div>
            <p>Hasil pencarian dari : <?= $keyword ?></p>
            <div class="results">
                <?php 
                // print_r($data);
                foreach ($data as $dt) { 
                    //get data upload
                    $upload = $this->db->query("SELECT LEFT(SUBSTRING_INDEX(isi, '$keyword', 2),150) as deskripsi from upload WHERE nama_file='$dt[nama_file]'")->row_array();
                ?>
                <div class="result">
                    <div class="result-head">
                        <a href="<?= base_url('uploads/'.$dt['nama_file']) ?>" target="_blank"><h2 class="document-title-result"><?= $dt['nama_file'] ?></h2></a>
                        <a href="<?= base_url('uploads/'.$dt['nama_file']) ?>" target="_blank"><p class="document-title"><?= $dt['nama_file'] ?></p></a>
                        <div class="info-icon-container">    
                            <p><i class="fas fa-user"></i> Mahkamah Agung Semarang | Unisbank</p>
                            <p><i class="far fa-clock"></i> <?= $dt['created_at'] ?></p>
                        </div>
                    </div>
                    <div class="result-body">
                        <?= $upload['deskripsi'] ?>..
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </main>
</body>
</html>