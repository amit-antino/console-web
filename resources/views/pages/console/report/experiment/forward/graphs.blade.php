<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-header">
                <h6  class="mb-3 mb-md-0 text-uppercase font-weight-normal">Graphical Representation</h6>
            </div>
            <div class="card-body">
                @if(!empty($data['experimental_result']['graphs']))
                @foreach($data['experimental_result']['graphs'] as $graph)
                <?php print_r($graph); ?>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>