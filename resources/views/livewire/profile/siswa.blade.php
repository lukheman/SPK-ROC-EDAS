<div class="row">
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <div class="avatar avatar-2xl">
                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('assets/compiled/jpg/2.jpg') }}" alt="">
                    </div>
                    <h3 class="mt-3">{{ $user->nama }}</h3>
                    <p class="text-small">{{ class_basename($user) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="form-group mb-2">
                        <label for="nisn" class="form-label">NISN</label>
                        <input type="text" id="nisn" class="form-control" value="{{ $user->nisn }}" readonly>
                    </div>

                    <div class="form-group mb-2">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" id="nama" class="form-control" value="{{ $user->nama }}" readonly>
                    </div>

                    <div class="form-group mb-2">
                        <label for="status_ekonomi" class="form-label">Status Ekonomi</label>
                        <input type="text" id="status_ekonomi" class="form-control" value="{{ $user->status_ekonomi }}" readonly>
                    </div>

                    <div class="form-group mb-2">
                        <label for="phone" class="form-label">No. HP</label>
                        <input type="text" id="phone" class="form-control" value="{{ $user->phone }}" readonly>
                    </div>

                    <div class="form-group mb-2">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <input type="text" id="jenis_kelamin" class="form-control"
                               value="{{ $user->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}" readonly>
                    </div>

                    <div class="form-group mb-2">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea id="alamat" class="form-control" rows="3" readonly>{{ $user->alamat }}</textarea>
                    </div>

                    <div class="form-group mb-2">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" class="form-control" value="{{ $user->tanggal_lahir }}" readonly>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
