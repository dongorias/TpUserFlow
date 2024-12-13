@extends('dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <!-- Contenu principal -->
            <main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-4">
                <div class="embed-responsive embed-responsive-21by9">
                    <iframe class="embed-responsive-item w-100" style="height: 80vh" src="{{$menu->lien}}"></iframe>
                </div>
            </main>
        </div>
    </div>

@endsection
