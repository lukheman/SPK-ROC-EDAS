    <!-- Data Diri Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h5 class="text-center mb-4"><b>Masukan data diri Anda</b></h5>
                    <div class="login-card">

                    <form> <!-- Ini wrapper form, tapi nggak wajib kalo Livewire handle semuanya -->
                        <div class="form-group mb-3">
                            <label for="nama">Nama</label>
                            <input wire:model="nama" type="text" class="form-control" id="nama">
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="umur">Umur (Tahun)</label>
                            <input wire:model="umur" type="number" class="form-control" id="umur" min="1">
                            @error('umur')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select wire:model="jenis_kelamin" class="form-control" id="jenis_kelamin">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat">Alamat</label>
                            <input wire:model="alamat" type="text" class="form-control" id="alamat">
                            @error('alamat')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button wire:click="nextStep" class="btn btn-primary w-100" type="button">Lanjut</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
