<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Perpustakaan</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .search-form {
            margin-bottom: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-weight: bold;
            text-shadow: 0px 5px 10px;
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        ul li a {
            text-decoration: none;
            color: #007bff;
        }
        ul li a:hover {
            text-decoration: underline;
        }
        .btn-block {
            width: 200px;
            color: #fff;
            background-color: #007bff;
        }
        a {
            color: #fff;
        }
        #bckground {
            background-color: #c4c4c4;
        }
        @media (max-width: 768px) {
            .btn-block {
                width: 30%;
            }
        }
    </style>
</head>
<body>
    <?php
    if (session('masuk')) {
        echo "<b>Selamat datang: " . session('masuk') . "</b><br />";
        echo '<div class="text-center"><a href="/logout" class="btn btn-block">Logout</a></div>';
    } else {
        echo '<div class="text-center"><a href="/masuk" class="btn btn-block">Masuk</a></div>';
    }
    ?>
    <hr>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarNav">
        </div>
    </nav>
    <!-- class="search-form form-inline justify-content-center" -->
    <h1>Perpustakaan SMK</h1>
    <div class="container">
        <form id="searchForm" action="/admin/manage-data/search" class="search-form form-inline justify-content-center"
            method="post">
            <input type="text" class="form_control" id="search" name="search"
                placeholder="Masukkan judul atau nama penerbit">
            <button type="submit" id="searchButton">Cari</button>
        </form>
        <div id="output"></div>
        <?php if (!empty($data)): ?>
            <ul class="list-group">
                <?php foreach ($data as $row): ?>
                    <?php if ($row['status_data'] == 'ada'): ?>
                        <li class="list-group-item">
                            <img src="<?= base_url(relativePath: $row['image']) ?>" alt="Gambar Buku"
                                style="width: 100px; height: auto;">
                            &nbsp;&nbsp; <a href="/member/detail/<?= esc(
                                urlencode(
                                    $row['id']
                                )
                            ) ?>"><?= esc($row['nama']) ?></a>
                            <br>
                            <br>
                            <span>Judul Buku: <?= esc($row['nama']) ?></span>
                            <br>
                            <span>Oleh: <?= esc($row['deskripsi']) ?></span>
                            <br><br>
                            <span>Status: Ada</span>
                        </li>
                        </li>
                    <?php else: ?>
                        <li class="list-group-item" id="bckground">
                            <img src="<?= base_url($row['image']) ?>" alt="Gambar Buku" style="width: 100px; height: auto;">
                            &nbsp;&nbsp; <a><?= esc($row['nama']) ?></a>
                            <br>
                            <br>
                            <span>Judul Buku: <?= esc($row['nama']) ?></span>
                            <br>
                            <span>Oleh: <?= esc($row['deskripsi']) ?></span>
                            <br><br>
                            <span>Status: Buku sedang dipinjam</span>
                        </li>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-center text-muted">Data perpustakaan kosong.</p>
        <?php endif; ?>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('searchForm').addEventListener('submit', function (e) {
                e.preventDefault();

                let searchQuery = document.getElementById('search').value;

                if (searchQuery) {
                    let xhr = new XMLHttpRequest();
                    xhr.open('POST', '<?= site_url("admin/manage-data/search") ?>', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            let response = JSON.parse(xhr.responseText);
                            let output = document.getElementById('output');
                            output.innerHTML = '';

                            if (response.length > 0) {
                                let resultHTML = '<ul class="list-group">';
                                response.forEach(function (item) {
                                    resultHTML += `
                                    <li class="list-group-item">
                                    <a href="/member/detail/${encodeURIComponent(item.id)}">${item.nama}</a>
                                    <br><br>
                                    <span>Judul Buku: ${item.nama}</span>
                                    <br>
                                    <span>Oleh: ${item.deskripsi}</span>
                                    <br><br>
                                    <span>Status: ${item.status_data}</span>
                                    </li>`;
                                });
                                resultHTML += '</ul><br><br>';
                                output.innerHTML = resultHTML;
                            } else {
                                output.innerHTML = '<p class="text-center">Tidak ada data yang ditemukan.</p>';
                            }
                        } else {
                            alert('Error mengambil data.');
                        }
                    };
                    xhr.onerror = function () {
                        alert('Error http Request');
                    };
                    xhr.send(`search=${encodeURIComponent(searchQuery)}`);
                } else {
                    document.getElementById('output').innerHTML = '<p class="text-center">Masukkan input untuk mencari</p>';
                }
            });
        });
    </script>
</body>

</html>