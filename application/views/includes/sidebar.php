<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url(); ?>assets/dashboard/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $this->session->userdata("full_name"); ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> <?php echo $this->session->userdata("email"); ?></a>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
			<?php if ($this->uri->segment(1) == 'admin') { ?>	
				<li class="<?php if($this->uri->segment(2)==''){echo "active";}?>">
					<a href="<?php echo base_url('admin'); ?>">
						<i class="fa fa-dashboard"></i> <span>Beranda</span>
					</a>
				</li>
				<li class="<?php if($this->uri->segment(2)=='law'){echo "active";}?>">
					<a href="<?php echo base_url('admin/mahasiswa'); ?>">
						<i class="fa fa-user"></i> <span>Mahasiswa</span>
					</a>
				</li>
				<li class="<?php if($this->uri->segment(3)=='request'){echo "active";}?>">
					<a href="<?php echo base_url('admin/schedules/request'); ?>">
						<i class="fa fa-bullhorn"></i> <span>Pengajuan Jadwal</span>
					</a>
				</li>
				<li class="<?php if($this->uri->segment(2)=='schedules' && $this->uri->segment(3)==''){echo "active";}?>">
					<a href="<?php echo base_url('admin/schedules'); ?>">
						<i class="fa fa-calendar-check-o"></i> <span>Jadwal</span>
					</a>
				</li>
				<li class="<?php if($this->uri->segment(3)=='history'){echo "active";}?>">
					<a href="<?php echo base_url('admin/schedule/history'); ?>">
						<i class="fa fa-history"></i> <span>Riwayat</span>
					</a>
				</li>
			<?php } else { ?>
				<li class="<?php if($this->uri->segment(2)==''){echo "active";}?>">
					<a href="<?php echo base_url('mahasiswa'); ?>">
						<i class="fa fa-dashboard"></i> <span>Beranda</span>
					</a>
				</li>
				<li class="<?php if($this->uri->segment(2)=='schedules'){echo "active";}?>">
					<a href="<?php echo base_url('mahasiswa/schedules'); ?>">
						<i class="fa fa-calendar-check-o"></i> <span>Pengajuan Jadwal</span>
					</a>
				</li>
			<?php } ?>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
