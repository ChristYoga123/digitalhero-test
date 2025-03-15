@extends('layouts.front')

@section('content')
    @Title([
        'title' => 'Service Kami',
        'breadcrumbs' => [['title' => 'Games']],
    ])

    <section class="games-section games-page-section">

        <div class="auto-container">

            <div class="row clearfix">
                <!--Game Block-->
                @foreach ($services as $service)
                    @ServiceCard(['service' => $service])
                @endforeach
            </div>
            {{ $services->links() }}
        </div>

    </section>
@endsection
