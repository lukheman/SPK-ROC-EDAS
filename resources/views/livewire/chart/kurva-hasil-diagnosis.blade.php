<div class="card">
    <div class="card-header">


    </div>
    <div class="card-body">

        <canvas id="myChart">
        </canvas>
    </div>
</div>

@push('scripts')
<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: @json($labels),
      datasets: [{
        label: '',
        data: @json($data),
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
@endpush
