<div class="row">
  <div class="col-md-3">
    <div class="box box-success">
      <div class="box-body">
        <div class="value">
          <h3>{{ $totalUser ?? 0 }}</h3>
        </div>
        <strong>Pengguna/Donatur</strong>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="box box-danger">
      <div class="box-body">
        <div class="value">
          <h3>{{ "Rp " . number_format($totalDonationSuccess  ?? 0, 2, ".", ",") }}</h3>
        </div>
        <strong> Nominal Transaksi Donasi Sukses</strong>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="box box-primary">
      <div class="box-body">
        <div class="value">
          <h3>{{ $totalCampaignComplete ?? 0 }}</h3>
        </div>
        <strong>Jumlah Donasi Selesai</strong>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="box box-info">
      <div class="box-body">
        <div class="value">
          <h3>{{ $totalCampaign ?? 0 }}</h3>
        </div>
        <strong>Program Donasi</strong>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Statistik Pengunjung</h3>
        <p>Data diambil dari Google Analytic</p>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
        Statistik
      </div>
    </div>
  </div>
</div>