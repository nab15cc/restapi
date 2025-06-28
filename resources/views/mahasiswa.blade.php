@extends('layouts.app')

@section('content')
<h3>Data Mahasiswa</h3>
<button class="btn btn-primary mb-3" id="btn-tambah">Tambah Mahasiswa</button>

<table class="table table-bordered" id="table-mahasiswa">
    <thead>
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Tanggal Lahir</th>
            <th>Jurusan</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>
</table>

<!-- Modal Tambah -->
<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="ModalAddLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="formMahasiswa"><div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="ModalAddLabel">Tambah Mahasiswa</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="edit-nim">
        <div class="mb-3">
          <label for="nim" class="form-label">NIM</label>
          <input type="text" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM">
      </div>
      <div class="mb-2">
        <label for="">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama">

      </div>
        <div class="mb-2">
            <label for="jk">Jenis Kelamin</label>
            <select class="form-select" id="jk" name="jk">
                <option value="">Pilih Jenis Kelamin</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
        </div>
        <div class="mb-2">
            <label for="tgl_lahir">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir">
        </div>
        <div class="mb-2">
            <label for="jurusan">Jurusan</label>
            <select name="jurusan" id="jurusan" class="form-control">
                <option value="">Pilih Jurusan</option>
                <option value="TI">Teknik Informatika</option>
                <option value="SI">Sistem Informasi</option>
                <option value="MI">Manajemen Informatika</option>
            </select>
        </div>
        <div class="mb-2">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="3"></textarea>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-simpan">Save Data</button>
        <button type="button" class="btn btn-primary" id="btn-update">Edit Data</button>
      </div>
</form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        const table = $('#table-mahasiswa').DataTable({
            ajax: "/api/mahasiswas",
            columns: [
                { data: 'nim', name: 'nim' },
                { data: 'nama', name: 'nama' },
                { data: 'jk', name: 'jk' },
                { data: 'tgl_lahir', name: 'tgl_lahir' },
                { data: 'jurusan', name: 'jurusan' },
                { data: 'alamat', name: 'alamat' },
                {
                    data: 'nim',
                    render: function(nim) {
                        return `
                            <button class="btn btn-success btn-sm btn-edit" data-id="${nim}">Edit</button>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="${nim}">Hapus</button>
                        `;
                    }
                }
            ]
        });

        function ambildataForm(){
            return {
                nim: $('#nim').val(),
                nama: $('#nama').val(),
                jk: $('#jk').val(),
                tgl_lahir: $('#tgl_lahir').val(),
                jurusan: $('#jurusan').val(),
                alamat: $('#alamat').val()
            };
        }

        $('#btn-tambah').click(function() {
            $('#ModalAddLabel').text('Tambah Mahasiswa');
            $('#ModalAdd').modal('show');
            $('#formMahasiswa')[0].reset();
            $('#btn-simpan').show();
            $('#btn-update').hide();
            $('#edit-nim').val('');
            $('#nim').prop('readonly', false);
        });

        $('#btn-simpan').click(function() {
            var data = ambildataForm();

            $.ajax({
                url: '/api/mahasiswas',
                type: 'POST',
                data: data,
                success: function(response) {
                    table.ajax.reload();
                    $('#ModalAdd').modal('hide');
                    alert('Data berhasil disimpan');
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        $('#table-mahasiswa').on('click', '.btn-edit', function() {
            var nim = $(this).data('id');

            $.ajax({
                url: '/api/mahasiswas/' + nim,
                type: 'GET',
                success: function(data) {
                    $('#ModalAddLabel').text('Edit Mahasiswa');
                    $('#ModalAdd').modal('show');
                    $('#nim').val(data.nim).prop('readonly', true);
                    $('#nama').val(data.nama);
                    $('#jk').val(data.jk);
                    $('#tgl_lahir').val(data.tgl_lahir);
                    $('#jurusan').val(data.jurusan);
                    $('#alamat').val(data.alamat);
                    $('#btn-simpan').hide();
                    $('#btn-update').show();
                    $('#edit-nim').val(nim);
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        $('#btn-update').click(function() {
            var nim = $('#edit-nim').val();
            var data = ambildataForm();

            $.ajax({
                url: '/api/mahasiswas/' + nim,
                type: 'PUT',
                data: data,
                success: function(response) {
                    table.ajax.reload();
                    $('#ModalAdd').modal('hide');
                    alert('Data berhasil diupdate');
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        $('#table-mahasiswa').on('click', '.btn-delete', function() {
            var nim = $(this).data('id');

            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: '/api/mahasiswas/' + nim,
                    type: 'DELETE',
                    success: function(response) {
                        table.ajax.reload();
                        alert('Data berhasil dihapus');
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            }
        });
    });
</script>
@endsection
