<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/style/force.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/style/index.css') ?>">
    <title>Mahkamah Agung | Pencarian Keputusan</title>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form enctype="multipart/form-data" method="GET" action="<?= base_url('welcome/search') ?>">
                    <h3 class="card-title">Pencarian keputusan Mahkamah Agung</h3>
                    <input class="inpForm" type="text" name="q">
                    <input class="btnForm" type=submit>
                </form>    
            </div>       
        </div>
    </div>
</body>
</html>