<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url(); ?>">
        <div class="sidebar-brand-icon">
            <img width="35px" height="35px" src="<?= base_url('images/desa/' . getLogo()); ?>" class="rounded mx-auto d-block mb-1" alt="...">
        </div>
        <div class="sidebar-brand-text ml-2">SIAP BRANTI</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">


    <!-- Heading -->
    <div class="sidebar-heading">
        Main Menu
    </div>

    <li class="nav-item <?= menuaktif('dashboard', $aktif); ?>">
        <a class="nav-link" href="<?= base_url('/'); ?>">
            <i class="fa fa-tachometer"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?= ($show == 'kependudukan') ? 'active' : ''; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#kependudukan" aria-expanded="true" aria-controls="kependudukan">
            <i class="fas fa-address-card"></i>
            <span>Kependudukan</span>
        </a>
        <div id="kependudukan" class="collapse <?= ($show == 'kependudukan') ? 'show' : ''; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?= menuaktif('kartu_keluarga', $aktif); ?>" href="<?= base_url('kk'); ?>">Kartu Keluarga</a>
                <a class="collapse-item <?= menuaktif('individu', $aktif); ?>" href="<?= base_url('penduduk'); ?>">Penduduk</a>
            </div>
        </div>
    </li>

    <li class="nav-item <?= ($show == 'mutasi') ? 'active' : ''; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#mutasi" aria-expanded="true" aria-controls="mutasi">
            <i class="fas fa-exchange-alt"></i>
            <span>Mutasi</span>
        </a>
        <div id="mutasi" class="collapse <?= ($show == 'mutasi') ? 'show' : ''; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?= menuaktif('mutasi_datang', $aktif); ?>" href="<?= base_url('datang'); ?>">Datang</a>
                <a class="collapse-item <?= menuaktif('mutasi_pindah', $aktif); ?>" href="<?= base_url('pindah'); ?>">Pindah</a>
            </div>
        </div>
    </li>

    <li class="nav-item <?= ($show == 'peristiwa') ? 'active' : ''; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#peristiwa" aria-expanded="true" aria-controls="peristiwa">
            <i class="fab fa-sith"></i>
            <span>Peristiwa</span>
        </a>
        <div id="peristiwa" class="collapse <?= ($show == 'peristiwa') ? 'show' : ''; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?= menuaktif('kelahiran', $aktif); ?>" href="<?= base_url('lahir'); ?>">Kelahiran</a>
                <a class="collapse-item <?= menuaktif('kematian', $aktif); ?>" href="<?= base_url('kematian'); ?>">Kematian</a>
            </div>
        </div>
    </li>

    <li class="nav-item <?= ($show == 'report') ? 'active' : ''; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#report" aria-expanded="true" aria-controls="report">
            <i class="fas fa-file-pdf"></i>
            <span>Report</span>
        </a>
        <div id="report" class="collapse <?= ($show == 'report') ? 'show' : ''; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?= menuaktif('report_desa', $aktif); ?>" href="<?= base_url('report/report_desa'); ?>">Report Desa</a>
                <a class="collapse-item <?= menuaktif('report_dusun', $aktif); ?>" href="<?= base_url('report/report_dusun'); ?>">Report Dusun</a>
                <a class="collapse-item <?= menuaktif('report_rt', $aktif); ?>" href="<?= base_url('report/report_rt'); ?>">Report RT</a>
                <a class="collapse-item <?= menuaktif('report_penduduk', $aktif); ?>" href="<?= base_url('report/report_penduduk'); ?>">Report Penduduk</a>
            </div>
        </div>
        
    </li>

    <?php if (session()->get('role') == 'admin') : ?>
        <!-- Heading -->
        <div class="sidebar-heading">
            Menu Admin
        </div>


        <li class="nav-item <?= ($show == 'manajement') ? 'active' : ''; ?>">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manajement" aria-expanded="true" aria-controls="manajement">
                <i class="fas fa-cogs"></i>
                <span>Manajement Desa</span>
            </a>
            <div id="manajement" class="collapse <?= ($show == 'manajement') ? 'show' : ''; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item <?= menuaktif('mnj_desa', $aktif); ?>" href="<?= base_url('mnj_desa'); ?>">Manajement Desa</a>
                    <a class="collapse-item <?= menuaktif('mnj_petugas', $aktif); ?>" href="<?= base_url('mnj_petugas'); ?>">Manajement Petugas</a>
                </div>
            </div>
        </li>

    <?php endif ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->