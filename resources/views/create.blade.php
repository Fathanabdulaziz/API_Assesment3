<div class="container">
    <h2>Tambah Tugas</h2>

    <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label>Nama Tugas:</label>
            <input type="text" name="nama_tugas" value="{{ old('nama_tugas') }}" required>
        </div>
        <div>
            <label>Gambar:</label>
            <input type="file" name="gambar" required>
        </div>
        <div>
            <label>Deadline:</label>
            <input type="date" name="deadline" value="{{ old('deadline') }}" required>
        </div>
        <button type="submit">Simpan</button>
    </form>
</div>
