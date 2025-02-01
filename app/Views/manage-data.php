<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .table-container {
            margin: 20px auto;
            max-width: 800px;
            padding: 20px;
            border-radius: 8px;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 90%;
        }
        .edit,
        .delete {
            color: #007bff;
            text-decoration: none;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        h1 {
            font-weight: bold;
        }
        .edit:hover {
            background-color: #d4edda;
        }
        .delete:hover {
            background-color: #f8d7da;
        }
        .edit-nama {
            text-align: left;
        }
        .form_control {
            width: 60%;
        }
        #searchButton {

        }
        label {
            text-align: left;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            margin: 20px auto;
            width: fit-content;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        #output {
            text-align: left;
            margin-top: 20px;
        }
        #output div {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f8f9fa;
        }
        #output img {
            width: 100px;
            height: auto;
            margin-right: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        #output h4 {
            margin: 0;
            padding: 0;
            font-size: 18px;
        }
        #output p {
            margin: 5px 0 0 0;
            padding: 0;
        }
        @media (max-width: 600px) {
            .btn-custom {
                width: 100%;
                margin: 0 auto;
            }
            .table-container {
                padding: 10px;
            }
            h1 {
                font-size: 24px;
            }
        }
        @media (min-width: 601px) and (max-width: 800px) {
            .btn-custom {
                width: 100%;
                margin: 0 auto;
            }
        }
    </style>
</head>
<body>
    <div class="table-container">
        <h1>Tabel Buku Perpustakaan</h1>
        <div class="form-group">
            <form id="searchForm" action="/admin/manage-data/search" method="post">
                <input type="text" class="form_control" id="search" name="search"
                    placeholder="Masukkan judul atau nama penerbit">
                <button type="submit" id="searchButton">Cari</button>
            </form>
            <div id="output"></div>
        </div>
        <br><br>
        <table class="table table-bordered table-striped" id="bukuTable">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Judul Buku</th>
                    <th>Nama Penerbit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($dummy_data) && is_array($dummy_data)): ?>
                    <?php foreach ($dummy_data as $item): ?>
                        <tr data-id="<?= esc($item['id']) ?>">
                            <td>
                                <?php
                                $index = array_search($item, $dummy_data) + 1;
                                echo $index;
                                ?>
                            </td>
                            <td><img src="<?= base_url($item['image']) ?>" alt="Gambar Buku"
                                    style="width: 100px; height: auto;"></td>
                            <td><?= esc($item['nama']) ?></td>
                            <td><?= esc($item['deskripsi']) ?></td>
                            <td>
                                <a href="#" class="edit" data-id="<?= esc($item['id']) ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path
                                            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                    </svg>
                                </a> |
                                <a href="#" class="delete" data-id="<?= esc($item['id']) ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-trash" viewBox="0 0 16 16">
                                        <path
                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                        <path
                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada data.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- Edit Data -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="edit-id" name="id">
                        <div class="form-group">
                            <label for="edit-nama" style="text-align: left;">Judul Buku:</label>
                            <input type="text" class="form-control" id="edit-nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-deskripsi">Nama Penerbit:</label>
                            <input type="text" class="form-control" id="edit-deskripsi" name="deskripsi" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-status">Status:</label>
                            <select class="form-control" id="edit-status" name="status_data">
                                <option value="ada" selected>Ada</option>
                                <option value="tidak">Tidak</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <button class="btn-custom" data-toggle="modal" data-target="#addModal">Tambah data</button>
    <!-- Tambah Data -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm" enctype="multipart/form-data" method="post">
                        <div class="form-group">
                            <label for="nama">Judul Buku:</label>
                            <input type="text" class="form-control" name="tambah-nama" id="tambah-nama" required>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Nama Penerbit:</label>
                            <input type="text" class="form-control" name="tambah-deskripsi" id="tambah-deskripsi"
                                required>
                            <label for="gambar">Gambar Buku:</label>
                            <input type="file" class="form-control" name="image" id="gambar" required>
                        </div>
                        <button type="submit" id="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="output"></div>
    <!-- <script src="<?php echo base_url('lib/bootstrap-config.js') ?>"></script>-->
    <script>
        (function () {
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
                                    let resultHTML = '<table class="table table-bordered table-striped">';
                                    resultHTML += '<tbody>';

                                    response.forEach(function (item, index) {
                                        resultHTML += `<tr>
                        <td>${index + 1}</td>
                        <td><img src="<?= base_url() ?>/${item.image}" alt="Gambar Buku" style="width: 100px;"></td>
                        <td>${item.nama}</td>
                        <td>${item.deskripsi}</td>
                        <td>
                            <button class="btn btn-warning btn-sm edit" data-id="${item.id}" data-nama="${item.nama}" data-deskripsi="${item.deskripsi}" data-toggle="modal" data-target="#editModal">Edit</button>
                            <button class="btn btn-danger btn-sm delete" data-id="${item.id}" data-toggle="modal" data-target="#deleteModal">Delete</button>
                        </td>
                    </tr>`;
                                    });
                                    resultHTML += '</tbody></table><br><hr />';
                                    output.innerHTML = resultHTML;
                                } else {
                                    output.innerHTML = '<p class="text-center">Tidak ada data yang ditemukan.</p>';
                                }
                            } else {
                                alert('Terjadi kesalahan saat mengambil data.');
                            }
                        };
                        xhr.onerror = function () {
                            alert('Terjadi kesalahan saat mengirim permintaan.');
                        };
                        xhr.send(`search=${encodeURIComponent(searchQuery)}`);
                    } else {
                        document.getElementById('output').innerHTML = '<p class="text-center">Masukkan kata kunci untuk mencari.</p>';
                    }
                });
                document.addEventListener('click', function (e) {
                    if (e.target.classList.contains('edit')) {
                        let id = e.target.getAttribute('data-id');
                        let nama = e.target.getAttribute('data-nama');
                        let deskripsi = e.target.getAttribute('data-deskripsi');

                        document.getElementById('edit-id').value = id;
                        document.getElementById('edit-nama').value = nama;
                        document.getElementById('edit-deskripsi').value = deskripsi;
                    }
                    if (e.target.classList.contains('delete')) {
                        let id = e.target.getAttribute('data-id');
                        document.getElementById('deleteId').value = id;
                    }
                });
            });
            document.querySelectorAll('.edit').forEach(element => {
                element.addEventListener('click', async (e) => {
                    e.preventDefault();
                    const id = element.dataset.id;
                    try {
                        const response = await fetch(`<?= site_url("/admin/manage-data/edit/") ?>${id}`);

                        if (!response.ok) throw new Error('Gagal mengambil data.');
                        const data = await response.json();

                        if (data.status === 'error') {
                            throw new Error(data.message);
                        }
                        document.getElementById('edit-id').value = data.id;
                        document.getElementById('edit-nama').value = data.nama;
                        document.getElementById('edit-deskripsi').value = data.deskripsi;
                        document.getElementById('edit-status').value = data.status_data;
                        $('#editModal').modal('show');
                    } catch (error) {
                        alert('Gagal mengambil data: ' + error.message);
                    }
                });
            });
            document.getElementById('editForm').addEventListener('submit', async (event) => {
                event.preventDefault();
                const id = document.getElementById('edit-id').value;

                if (!validateForm()) {
                    alert('Form tidak valid, silakan periksa kembali.');
                    return;
                }
                try {
                    const response = await fetch(`<?= site_url("/admin/manage-data/edit/") ?>${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams(new FormData(event.target)).toString(),
                    });
                    if (!response.ok) throw new Error('Gagal memperbarui data.');
                    const result = await response.json();

                    if (result.status === 'success') {
                        location.reload();
                    } else {
                        throw new Error(result.message);
                    }
                } catch (error) {
                    alert('Gagal memperbarui data: ' + error.message);
                }
            });
            document.getElementById('addForm').addEventListener('submit', async (event) => {
                event.preventDefault();

                if (!addValidate()) {
                    alert('Form tidak valid, silakan periksa kembali.');
                    return;
                } else if (!imageUpload()) {
                    alert('Gambar buku belum dipilih.');
                    return;
                }
                const formData = new FormData(event.target);
                try {
                    const response = await fetch(`<?= site_url("/admin/manage-data/add/") ?>`, {
                        method: 'POST',
                        body: formData,
                    });
                    if (!response.ok) throw new Error('Gagal menyimpan data.');
                    const result = await response.json();

                    if (result.status === 'success') {
                        location.reload();
                    } else {
                        throw new Error(result.message);
                    }
                } catch (error) {
                    alert('Gagal menyimpan data: ' + error.message);
                }
            });
            document.querySelectorAll('.delete').forEach(element => {
                element.addEventListener('click', async (e) => {
                    e.preventDefault();
                    const id = element.dataset.id;
                    try {
                        const response = await fetch(`<?= site_url("/admin/manage-data/delete/") ?>${id}`, {
                            method: 'DELETE'
                        });
                        if (!response.ok) throw new Error('Gagal menghapus data.');
                        const result = await response.json();

                        if (result.status === 'success') {
                            location.reload();
                        } else {
                            throw new Error(result.message);
                        }
                    } catch (error) {
                        alert('Gagal menghapus data: ' + error.message);
                    }
                });
            });
            function validateForm() {
                const nama = document.getElementById('edit-nama').value;
                const deskripsi = document.getElementById('edit-deskripsi').value;
                const status = document.getElementById('edit-status').value;

                return nama.trim() !== '' && deskripsi.trim() !== '' && status.trim() !== '';
            }
            function addValidate() {
                const add = document.getElementById('tambah-nama').value;
                const addDeskripsi = document.getElementById('tambah-deskripsi').value;

                return add.trim() !== '' && addDeskripsi.trim() !== '';
            }
            function imageUpload() {
                const file = document.getElementById('gambar').files[0];
                return file !== undefined;
            }
        })();
        $.ajax({
            type: "GET",
            url: "<?= site_url("/permission/erly-access/api/version/v1") ?>",
            data: "data",
            dataType: "json",
            success: function (response) {
                console.log(response);
            },
            error: function (xhr, status, error) {
                console.error('Error fetching version:', status, error);
            }
        });
        // Gabut
        document.addEventListener('keydown', function(event) {
                switch (event.key) {
                    case 'Control':
                        return false;
                        event.preventDefault();
                        break;
                    case 'Shift':
                        return false;
                        event.preventDefault();
                        break;
                    case 'I':
                        case 'i':
                            if (event.ctrlKey) {
                                return false;
                                event.preventDefault();
                            }
                            break;
                    case 'F12':
                        return false;
                        event.preventDefault();
                        break;
                        default:
                            break;
                    }
                });
    </script>
</body>
</html>