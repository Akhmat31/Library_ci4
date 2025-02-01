<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<style>
    #reason {
        width: 100%;
    }
    #alasan {
        display: none;
    }
    .form-group {
        text-align: center;
    }
</style>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Manajemen User</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
            Tambah User
        </button><br><br>
        <div class="form-group">
            <form id="searchForm" action="/admin/manage-user/search" method="post">
                <input type="text" class="form_control" id="search" name="search"
                    placeholder="Masukkan nama user">
                <button type="submit" id="searchButton">Cari</button>
            </form><br><br>
            <div id="output"></div>
        </div>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($data)): ?>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= esc($row['username']); ?></td>
                            <td><?= esc($row['password']); ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUserModal" 
                                        data-id="<?php echo $row['id']; ?>" 
                                        data-username="<?php echo htmlspecialchars($row['username']); ?>" 
                                        data-password="<?php echo htmlspecialchars($row['password']) ?>">
                                    Edit
                                </button>
                                <button class="btn btn-danger btn-sm deleteUserModal" data-id="<?php echo $row['id']; ?>">
                                Hapus
                            </button>
                            <b>Status: <?php echo htmlspecialchars($row['role']) ?></b>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">Data user kosong.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- Modal Tambah User -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm" action="/admin/manage-user/add" method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="member">Member</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit User -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" action="/admin/manage-user/edit" method="post">
                        <input type="hidden" name="id" id="editUserId">
                        <div class="form-group">
                            <label for="editUsername">Username</label>
                            <input type="text" class="form-control" id="editUsername" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="editPassword">Password</label>
                            <input type="password" class="form-control" id="editPassword" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Ban</label>
                            <select class="form-control" id="banned" name="banned" required>
                                <option value="ok" selected>banned status</option>
                                <option value="member">Unban (ok)</option>
                                <option value="ban" id="banned">Banned</option>
                            </select>
                            <br><br>
                            <div id="alasan">
                            <label for="reason">Alasan: </label>
                            <textarea name="reason" id="reason"></textarea>
                        </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready (() => {
            $('#banned').click (function () {
                var ban = document.getElementById('banned').value;
                if (ban === 'ban') {
                    document.getElementById('alasan').style.display = 'block';
                } else {
                    document.getElementById('alasan').style.display = 'none';
                }
            })
        });
        document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('searchForm').addEventListener('submit', function (e) {
                    e.preventDefault();

                    let searchQuery = document.getElementById('search').value;

                    if (searchQuery) {
                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', '<?= site_url("admin/manage-user/search") ?>', true);
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
                        <td>${item.username}</td>
                        <td>
                            <button class="btn btn-warning btn-sm edit" data-id="${item.id}" data-nama="${item.nama}" data-deskripsi="${item.deskripsi}" data-toggle="modal" data-target="#editModal">Edit</button>
                            <button class="btn btn-danger btn-sm delete" data-id="${item.id}" data-toggle="modal" data-target="#deleteModal">Delete</button>
                            <b>Status: ${item.role}</b>
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
            });
    $('#editUserModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Tombol yang dipilih
            var id = button.data('id'); // Ambil data-id
            var username = button.data('username'); // Ambil data-username
            var password = button.data('password'); // Ambil data-password

            var modal = $(this);
            modal.find('#editUserId').val(id);
            modal.find('#editUsername').val(username);
            modal.find('#editPassword').val(password);
        });
        document.getElementById('editUserForm').addEventListener('submit', async (event) => {
            event.preventDefault(); // Mencegah form dari pengiriman standar
            const id = document.getElementById('editUserId').value;

            const username = document.getElementById('editUsername').value;
            const password = document.getElementById('editPassword').value;
            const ban = document.getElementById('banned').value;

            if (username.trim() === '' || password.trim() === '' || ban.trim() === '') {
                alert('Form tidak valid, silakan periksa kembali.');
                return;
            }
            try {
                const response = await fetch(`/admin/manage-user/edit/${id}`, {
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
        document.getElementById('addUserForm').addEventListener('submit', async (event) => {
            event.preventDefault();

            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const role = document.getElementById('role').value.trim();
            
            if (!username || !password || !role) {
                alert('Form tidak valid, silakan periksa kembali.');
                return;
            }
            const formData = new FormData(event.target);
            try {
                const response = await fetch('/admin/manage-user/add', {
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
                alert(error.message);
            }
        });
        document.querySelectorAll('.deleteUserModal').forEach(button => {
    button.addEventListener('click', async (event) => {
        const id = event.target.dataset.id;
        try {
            const response = await fetch(`/admin/manage-user/delete/${id}`, {
                method: 'DELETE',
            });
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
    </script>
</body>
</html>