<div class="page-breadcrumb">

    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Dashboard</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">                           
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    @if(!$notice->isEmpty())
    <div class="row">
        <div class="col-12 align-self-center">
            <div class="cssmarquee">
                @foreach($notice as $notices)
                <p> {{ $notices->title }} </p>
                @endforeach
            </div>
        </div>
    </div>
    @endif

</div>