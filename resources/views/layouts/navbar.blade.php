<!-- Collect the nav links, forms, and other content for toggling --> 
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <!-- <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li> -->

              @if(Auth::user()->can(['lihat_pembelian', 'tambah_pembelian']))
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pembelian <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  @if(Auth::user()->can(['tambah_pembelian']))
                  <li><a href="/pembelian/create">Pembelian Baru</a></li>
                  @endif
                  @if(Auth::user()->can(['lihat_pembelian']))
                  <li><a href="/pembelian">List Pembelian</a></li>
                  @endif
                </ul>
              </li>
              @endif
            

              @if(Auth::user()->can(['lihat_penjualan', 'tambah_penjualan']))
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Penjualan <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                @if(Auth::user()->can(['tambah_penjualan']))
                <li><a href="/penjualan/create">Penjualan Baru</a></li>
                @endif
                @if(Auth::user()->can(['lihat_penjualan']))
                <li><a href="/penjualan">List Penjualan</a></li>
                @endif
                
              </ul>
            </li>
            @endif

            @if(Auth::user()->can(['lihat_barang', 'lihat_opname', 'lihat_jenis']))
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Barang <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                @if(Auth::user()->can(['lihat_barang']))
                <li><a href="/barang">List Barang</a></li>
                @endif
                @if(Auth::user()->can(['lihat_opname']))
                <li><a href="/opname">Stok Opname</a></li>
                @endif
                @if(Auth::user()->can(['lihat_jenis']))
                <li><a href="/jenis">Jenis Barang</a></li>
                @endif
                
                
              </ul>
            </li>
            @endif

            @if(Auth::user()->can(['lihat_member']))
            <li><a href="/member">Member</a></li>
            @endif
			
			@if(Auth::user()->can(['lihat_suplier']))
            <li><a href="/suplier">Suplier</a></li> 
            @endif

            @if(Auth::user()->can(['lihat_user', 'lihat_grup']))
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">User <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                @if(Auth::user()->can(['lihat_user']))
                <li><a href="/user">Daftar User</a></li>
                @endif
                @if(Auth::user()->can(['lihat_grup']))
                <li><a href="/grup">Grup User</a></li>
                @endif
              </ul>
            </li>
            @endif

            @if(Auth::user()->can(['lihat_laporan_member', 'lihat_laporan_barang', 'lihat_laporan_stokopname', 'lihat_laporan_historystok', 'lihat_laporan_hilang', 'lihat_laporan_pembelian', 'lihat_laporan_penjualan', 'lihat_keuntungan']))
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Laporan <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                @if(Auth::user()->can(['lihat_laporan_barang']))
                <li><a href="/laporan/barang">Daftar Barang</a></li>
                @endif
                @if(Auth::user()->can(['lihat_laporan_stokopname']))
                <li><a href="/laporan/opname">Stok Opname</a></li>
                @endif
                @if(Auth::user()->can(['lihat_laporan_historystok']))
                <li><a href="/laporan/history">History Stok</a></li>
                @endif
                @if(Auth::user()->can(['lihat_laporan_hilang']))
                <li><a href="/laporan/hilang">Stok Hilang</a></li>
                @endif
                @if(Auth::user()->can(['lihat_laporan_member']))
                <li><a href="/laporan/member">Daftar Member</a></li>
                @endif
				@if(Auth::user()->can(['lihat_suplier']))
                <li><a href="/laporan/konsinyasi">Daftar Suplier dan Konsinyasi</a></li>
                @endif
                @if(Auth::user()->can(['lihat_laporan_pembelian']))
                <li><a href="/laporan/pembelian">Transaksi Pembelian</a></li>
                @endif
                @if(Auth::user()->can(['lihat_laporan_penjualan']))
                <li><a href="/laporan/penjualan">Transaksi Penjualan</a></li>
                @endif
                @if(Auth::user()->can(['lihat_keuntungan']))
                <li><a href="/laporan/laba">Rugi Laba</a></li>
                @endif
              </ul>
            </li>
            @endif
          </ul>
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user"></i>
              <span class="hidden-xs">{{ Auth::user()->fullname }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <i class="fa fa-user-circle-o fa-5x"></i>

                <p>
                  {{ Auth::user()->fullname }} - {{ Auth::user()->role()->display_name }}
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <button title="Ganti Password User" class="btn btn-default btn-flat" data-toggle="modal" data-target="#modalPassword" onclick="PasswordClick();"> Ganti Password</button>
                </div>
                <div class="pull-right">
                  <a href="{{ url('/logout') }}" class="btn btn-default btn-flat"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                </div>
              </li>
            </ul>
          </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu