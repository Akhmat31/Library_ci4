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