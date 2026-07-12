<div style="
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:24px;
">

    <div>
        <h3 style="margin:0;color:#166534;">
            Dashboard Anggota
        </h3>

        <small style="color:#666;">
            Selamat datang,
            {{ session('nama_lengkap') }}
        </small>
    </div>

    <form action="/logout" method="POST">

        @csrf

        <button type="submit" style="
                background:#dc2626;
                color:white;
                border:none;
                padding:10px 18px;
                border-radius:8px;
                cursor:pointer;
            ">

            Logout

        </button>

    </form>

</div>