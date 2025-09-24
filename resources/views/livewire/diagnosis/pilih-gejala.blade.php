    <!-- Pilih Gejala Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="gejala-card">
                        <h5 class="text-center mb-4"><b>Pilih Gejala</b></h5>
                        <form action="">
                            <div class="row">
                                <!-- Kolom Kiri (Gejala 1 sampai setengah) -->
                                <div class="col-md-6">
                                    @foreach ($gejala->take(ceil($gejala->count() / 2)) as $item)
                                        <div class="form-group mb-3">
                                            <div class="checkbox form-check form-check-lg">
                                                <input wire:model="id_gejala_terpilih" type="checkbox" id="gejala-{{ $item->id }}" value="{{ $item->id }}" class="form-check-input">
                                                <label for="gejala-{{ $item->id }}" class="ms-2 mt-1">{{ $loop->index + 1 . '. ' . $item->nama }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Kolom Kanan (Gejala setengah sampai akhir) -->
                                <div class="col-md-6">
                                    @foreach ($gejala->skip(ceil($gejala->count() / 2)) as $item)
                                        <div class="form-group mb-3">
                                            <div class="checkbox form-check form-check-lg">
                                                <input wire:model="id_gejala_terpilih" type="checkbox" id="gejala-{{ $item->id }}" value="{{ $item->id }}" class="form-check-input">
                                                <label for="gejala-{{ $item->id }}" class="ms-2 mt-1">{{ $loop->index + 1 + ceil($gejala->count() / 2) . '. ' . $item->nama }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12"> 
                                    <button wire:click="backToInfoPasien" class="btn btn-primary" type="button">Kembali</button>
                                    <button wire:click="start" class="btn btn-primary" type="button">Diagnosis</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
