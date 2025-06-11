<div class="container">
    <h2>Data Tugas</h2>

    <!-- Notifikasi sukses -->
    <div id="success-message" style="display: none;"></div>

    <a href="{{ route('create') }}">Tambah Tugas</a>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
        <tr>
            <th>Nama Tugas</th>
            <th>Gambar</th>
            <th>Deadline</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody id="data-table">
            @foreach($data as $tugas)
            <tr>
                <td>{{ $tugas->nama_tugas }}</td>
                <td><img src="{{ asset('storage/' . $tugas->gambar) }}" width="100" alt="{{ $tugas->nama_tugas }}"></td>
                <td>{{ \Carbon\Carbon::parse($tugas->deadline)->format('d M Y') }}</td>
                <td>
                    <form action="/tugas/{{ $tugas->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background-color:red; color:white; border:none; padding:5px 10px; cursor:pointer;">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
