<h2>Tambah Siswa</h2>

<form method="POST" action="/admin/siswa">
    @csrf

    <label>NIS</label>
    <input type="text" name="nis" required>

    <label>Nama Lengkap</label>
    <input type="text" name="nama_lengkap" required>

    <label>Kelas</label>
    <input type="text" name="kelas_siswa" required>

    <label>Jenis Kelamin</label>
    <select name="jenis_kelamin" required>
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
    </select>

    <label>Alamat</label>
    <textarea name="alamat" required></textarea>

    <button type="submit">Simpan</button>
</form>