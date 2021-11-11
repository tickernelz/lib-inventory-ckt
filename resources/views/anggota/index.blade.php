@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@section('title_prefix', 'List Buku')
@section('title', '|')
@section('title_postfix', 'PERPUSTAKAAN')

@section('plugins.Datatables', true)

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">
        <div class="container-login100"
             style="background-image: url('https://unsplash.com/photos/k2Kcwkandwg/download?ixid=MnwxMjA3fDB8MXxhbGx8fHx8fHx8fHwxNjM2NDc5ODg2&force=true&w=2400');">
            <div class="wrap-pinjam p-l-55 p-r-55 p-t-80 p-b-30">
                <form class="login100-form validate-form">
				<span class="login100-form-title p-b-37">
					Halo, {{ $anggota->nama }}
				</span>

                    <div class="text-center p-t-0 p-b-20">
					<span class="txt1">
						List Buku
					</span>
                    </div>
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> Success!</h5>
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (session('errors'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-ban"></i> Error!</h5>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="table" style="width:100%" class="table text-center table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>ISBN</th>
                                <th>Judul Buku</th>
                                <th>No Rak</th>
                                <th>Kategori</th>
                                <th>Stok Tersedia</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $li)
                                @if($li->stok !== 0)
                                    <tr>
                                        <td>{!! $loop->iteration !!}</td>
                                        <td>{!! $li->isbn !!}</td>
                                        <td>{!! $li->judul !!}</td>
                                        <td>{!! $li->kategori_buku->rak->nomor !!}</td>
                                        <td>{!! $li->kategori_buku->nama !!}</td>
                                        <td>{!! $li->stok !!}</td>
                                        <td>
                                            @if($booking->firstWhere('buku_id', $li->id) != null)
                                                @if(($booking->firstWhere('buku_id', $li->id))->status === 'Menunggu')
                                                    <span>Sudah Dibooking!</span>
                                                @elseif($booking->firstWhere('buku_id', $li->id)->status === 'Tersedia')
                                                    <span>Dapat Dipinjam!</span>
                                                @else
                                                    <a type="button" class="btn btn-sm btn-secondary"
                                                       href="{{ Request::url() }}/tambah/{{$li->id}}"
                                                       onclick="return confirm('Yakin Mau Dibooking?');">
                                                        <i class="fa fa-bookmark"></i> Booking
                                                    </a>
                                                @endif
                                            @else
                                                <a type="button" class="btn btn-sm btn-secondary"
                                                   href="{{ Request::url() }}/tambah/{{$li->id}}"
                                                   onclick="return confirm('Yakin Mau Dibooking?');">
                                                    <i class="fa fa-bookmark"></i> Booking
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center p-t-20">
                        <a href="{{ route('get.logout') }}" class="txt2 hov1">
                            Keluar
                        </a>
                        <span> | </span>
                        <a href="{{ route('index.booking.pinjam') }}" class="txt2 hov1">
                            List Booking
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('adminlte_css')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('dist/pinjam/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('dist/pinjam/fonts/iconic/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/pinjam/vendor/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/pinjam/vendor/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/pinjam/vendor/animsition/css/animsition.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/pinjam/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/pinjam/css/main.css') }}">
@endsection

@section('adminlte_js')
    <script src="{{ asset('dist/pinjam/vendor/animsition/js/animsition.min.js') }}"></script>
    <script src="{{ asset('dist/pinjam/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('dist/pinjam/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('dist/pinjam/js/bootstrap-datepicker.id.min.js') }}"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table').DataTable();
        });
    </script>
@endsection
