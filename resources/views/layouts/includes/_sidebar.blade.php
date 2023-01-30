        <div id="left-sidebar" class="sidebar">
			<button type="button" class="btn btn-xs btn-link btn-toggle-fullwidth">
				<span class="sr-only">Toggle Fullwidth</span>
				<i class="fa fa-angle-left"></i>
			</button>
			<div class="sidebar-scroll">
				<div class="user-account">
					<img src="{{asset('images')}}/{{auth()->user()->avatar}}" class="img-responsive img-circle user-photo" alt="User Profile Picture">
					<div class="dropdown">
						<a href="#" class="dropdown-toggle user-name" data-toggle="dropdown">Hello, <strong>{{auth()->user()->name}}</strong> <i class="fa fa-caret-down"></i></a>
						<ul class="dropdown-menu dropdown-menu-right account">
							<li><a href="/user/{{auth()->user()->id}}/data_diri">Lihat Data Diri</a></li>
							<li><a href="/user/{{auth()->user()->id}}/ubah_password">Ubah Password</a></li>
							<li class="divider"></li>
							<li><a href="/logout">Logout</a></li>
						</ul>
					</div>
				</div>
				<nav id="left-sidebar-nav" class="sidebar-nav">
					<ul id="main-menu" class="metismenu">
						<li class="{{Request::segment(1) == 'dashboard' ? 'active':''}}"><a href="/dashboard"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
						@if(auth()->user()->role == 'admin')
                        	<li class="{{Request::segment(1) == 'user' ? 'active':''}}"><a href="/user"><i class="lnr lnr-user"></i> <span>User</span></a></li>
							<li class="{{Request::segment(1) == 'cabang' ? 'active':''}}"><a href="/cabang"><i class="lnr lnr-store"></i> <span>Cabang</span></a></li>
							<li class="{{Request::segment(1) == 'supplier' ? 'active':''}}"><a href="/supplier"><i class="lnr lnr-apartment"></i> <span>Supplier</span></a></li>
							<li class="{{Request::segment(1) == 'kategori' ? 'active':''}}"><a href="/kategori"><i class="lnr lnr-tag"></i> <span>Kategori</span></a></li>
							<li class="{{Request::segment(1) == 'barang' ? 'active':''}}"><a href="/barang"><i class="lnr lnr-coffee-cup"></i> <span>barang</span></a></li>
							<!-- <li class="{{Request::segment(1) == 'jumlahTransaksi' ? 'active':''}}"><a href="/jumlahTransaksi"><i class="lnr lnr-book"></i> <span>Jumlah Transaksi</span></a></li>
							<li class="{{Request::segment(1) == 'penggunaan' ? 'active':''}}"><a href="/penggunaan"><i class="lnr lnr-exit-up"></i> <span>Penggunaan</span></a></li>
							<li class="{{Request::segment(1) == 'penyediaan' ? 'active':''}}"><a href="/penyediaan"><i class="lnr lnr-enter-down"></i> <span>Penyediaan</span></a></li>
							<li class="{{Request::segment(1) == 'jumlahTransaksi' ? 'active':''}}"><a href="/jumlahTransaksi/laporan"><i class="lnr lnr-enter-down"></i> <span>Laporan Jumlah Transaksi</span></a></li>
							<li class="{{Request::segment(1) == 'penyediaan' ? 'active':''}}"><a href="/penyediaan/laporan"><i class="lnr lnr-enter-down"></i> <span>Laporan Penyediaan</span></a></li>
							<li class="{{Request::segment(1) == 'barang' ? 'active':''}}"><a href="/barang/laporanHarga"><i class="lnr lnr-enter-down"></i> <span>Laporan Perubahan Harga</span></a></li>
							<li class="{{Request::segment(1) == 'barang' ? 'active':''}}"><a href="/barang/laporanStock"><i class="lnr lnr-enter-down"></i> <span>Laporan Stock Terkini</span></a></li>
							<li class="{{Request::segment(1) == 'penggunaan' ? 'active':''}}"><a href="/penggunaan/laporan"><i class="lnr lnr-enter-down"></i> <span>Laporan Penggunaan</span></a></li> -->
						@endif
						@if(auth()->user()->role == 'pegawai')
							<li class="{{Request::segment(1) == 'jumlahTransaksi' ? 'active':''}}"><a href="/jumlahTransaksi"><i class="lnr lnr-book"></i> <span>Jumlah Transaksi</span></a></li>
							<li class="{{Request::segment(1) == 'penyediaan' ? 'active':''}}"><a href="/penyediaan"><i class="lnr lnr-enter-down"></i> <span>Penyediaan</span></a></li>
							<li class="{{Request::segment(1) == 'penggunaan' ? 'active':''}}"><a href="/penggunaan"><i class="lnr lnr-exit-up"></i> <span>Penggunaan</span></a></li>
							<li class="{{Request::segment(2) == 'stock' ? 'active':''}}"><a href="/barang/stock"><i class="lnr lnr-coffee-cup"></i> <span>Stock</span></a></li>
						@endif
						@if(auth()->user()->role == 'owner')
							<li class="{{Request::segment(1) == 'jumlahTransaksi' ? 'active':''}}"><a href="/jumlahTransaksi/laporan"><i class="lnr lnr-chart-bars"></i> <span>Laporan Jumlah Transaksi</span></a></li>
							<!-- <li class="{{Request::segment(1) == 'penyediaanx' ? 'active':''}}"><a href="/penyediaan/laporan"><i class="lnr lnr-enter-down"></i> <span>Laporan Penyediaan</span></a></li> -->
							<li class="{{Request::segment(1) == 'penyediaan' ? 'active':''}}">
								<a href="#subPages" class="has-arrow" aria-expanded="false"><i class="lnr lnr-enter-down"></i> <span>Laporan Penyediaan</span></a>
								<ul aria-expanded="true">
									<li class="{{Request::segment(3) == 'penyediaan1' ? 'active':''}}"><a href="/penyediaan/laporan/penyediaan1">- Total Jumlah Penyediaan</a></li>
									<li class="{{Request::segment(3) == 'penyediaan2' ? 'active':''}}"><a href="/penyediaan/laporan/penyediaan2">- Total Penyediaan Per-Kategori</a></li>
									<li class="{{Request::segment(3) == 'penyediaan3' ? 'active':''}}"><a href="/penyediaan/laporan/penyediaan3">- Jumlah Penyediaan Bulanan Per-Barang</a></li>
								</ul>
							</li>
							<!-- <li class="{{Request::segment(1) == 'penggunaanx' ? 'active':''}}"><a href="/penggunaan/laporan"><i class="lnr lnr-enter-down"></i> <span>Laporan Penggunaan</span></a></li> -->
							<li class="{{Request::segment(1) == 'penggunaan' ? 'active':''}}">
								<a href="#subPages" class="has-arrow" aria-expanded="false"><i class="lnr lnr-exit-up"></i> <span>Laporan Penggunaan</span></a>
								<ul aria-expanded="true">
									<li class="{{Request::segment(3) == 'penggunaan1' ? 'active':''}}"><a href="/penggunaan/laporan/penggunaan1">- Total Jumlah penggunaan</a></li>
									<li class="{{Request::segment(3) == 'penggunaan2' ? 'active':''}}"><a href="/penggunaan/laporan/penggunaan2">- Total Penggunaan Per-Kategori</a></li>
									<li class="{{Request::segment(3) == 'penggunaan3' ? 'active':''}}"><a href="/penggunaan/laporan/penggunaan3">- Jumlah Penggunaan Bulanan Per-Barang</a></li>
								</ul>
							</li>
							<li class="{{Request::segment(2) == 'laporanHarga' ? 'active':''}}"><a href="/barang/laporanHarga"><i class="lnr lnr-tag"></i> <span>Laporan Perubahan Harga</span></a></li>
							<li class="{{Request::segment(2) == 'laporanStock' ? 'active':''}}"><a href="/barang/laporanStock"><i class="lnr lnr-coffee-cup"></i> <span>Laporan Stock Terkini</span></a></li>
							@endif
					</ul>
				</nav>
			</div>
		</div>