<div class="fixed-bottom">
    <footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between" style=" height:28px;">
        <p class="text-muted text-center text-md-left">
            Copyright &copy; <script>
                document.write(new Date().getFullYear());
            </script> <a href="https://www.simreka.com" style="margin-left:2px;" target="_blank" formtarget="_blank" target="_blank">Simreka</a>. All Rights Reserved
        </p>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            @if(!empty(get_quide_doc('quick_start')))
            <a href="{{url(get_quide_doc('quick_start'))}}" class="pr-2" target="_blank">Quick Start Guide</a>
            @else
            <a href="javascript:void(0);" data-toggle="modal" data-target=".quick_start_guide" class="pr-2">Quick Start Guide</a>
            @endif
            <a href="javascript:void(0);" class="pr-2">Release notes</a>
            <!-- <a href="{{url('/docs/runsimulation/1.0/limit')}}" class="pr-2" target="_blank">Benchmarks Data</a> -->
            @if(!empty(get_quide_doc('benchmark_doc')))
            <a href="{{url(get_quide_doc('benchmark_doc'))}}" class="pr-2" target="_blank">Benchmark Data</a>
            @else
            <a href="javascript:void(0);" data-toggle="modal" data-target=".quick_start_guide" class="pr-2">Benchmark Data</a>
            @endif
            <a href="javascript:void(0);" data-toggle="modal" data-target=".issue-example-modal-sm">Report an Issue</a>
            <p class="text-muted text-center text-md-right">
                <a href="javascript:void(0);" data-toggle="modal" data-target=".system-diagnostic" title="System Diagnostic" ><img src="{{ asset('assets/images/diagnostic.png') }}" width="50"
                    height="50" ></i>
                </a>
                <span> &nbsp; &nbsp; V1.0.5</span>
            </p>
        </div>

    </footer>
</div>
<script>

</script>
