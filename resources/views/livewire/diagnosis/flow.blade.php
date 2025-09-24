<div class="py-5">

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-10">


                @if ($step === 1)
                <livewire:diagnosis.info-pasien />
                @elseif($step === 2)
                <livewire:diagnosis.pilih-gejala />
                @elseif($step === 3)
                <livewire:diagnosis.hasil-diagnosis />
                @endif




            </div>
        </div>

    </div>
</div>
