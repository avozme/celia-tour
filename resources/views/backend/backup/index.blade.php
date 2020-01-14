 @extends('layouts.backend')
@section('content')
 <div class="container -body-block pb-5">
                <li class="nav-item active mr-3">
                    <a href="{{ url('backup/create') }}" class="nav-link text-primary" title="Crear nuevo backup">
                        <i class="far fa-plus" aria-hidden="true"></i> Crear nuevo backup
                    </a>
                </li>
            <div class="py-4"></div>
            <div class="py-3"></div>
    </div>
@endsection