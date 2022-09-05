<link href="{{ asset('assets/plugins/simplemde/simplemde.min.css') }}" rel="stylesheet" />
<script src="{{ asset('assets/plugins/simplemde/simplemde.min.js') }}"></script>
<!-- <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script> -->
<link href="{{ asset('assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
<script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
<style>
    .wizard>.content {
        background: #eee;
        display: block;
        margin: 0.5em;
        min-height: 25em;
        overflow: hidden;
        position: relative;
        width: auto;
        border-radius: 5px;
        min-height: 28rem;
        overflow: auto;
        background: #ffffff;
        border: 1px solid #e8ebf1;
        margin-left: 0;
        padding: 1em 1em;
    }
</style>

<div class="tab-pane" id="qa" role="tabpanel" aria-labelledby="qa_tab">
    <form method="post" id="profileE1massQA" action="javascript:void(0)" enctype="multipart/form-data">
    <input type="hidden" id="dataset_id" name="dataset_id" class="form-control" value="{{___encrypt($process_dataset['id'])}}">
        <div id="wizard">
            <h2>Genral Risk Aspect</h2>
            <section>
                <div class="form-row">
                    <div class="form-group col-md-12 ">
                        <p class="text-left">This parameter is based on the external economic aspects and technical aspects of the product molecule or reaction pathway, whichcan play a crucial role in the practical implementation of a new process. Using this parameter each process is assessed based on scoring statements (qualitative phrases) for each indicator. As in other cases lower scores are better for respective processes. The overall parameter score for risk aspects is obtained by weighted addition of indicator scores. Review the weights at the end of the scoring.</p>
                        <h6 class="text-left">Select the most valid phrases for the process in each of the categories below</h6>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="form-row">
                            <label class="control-label">
                                <h5>Feedstock supply risk <i data-toggle="tooltip" title=" Select the most applicable statement from the options below that characterize the feedback supply" data-original-title=" Select the most applicable statement from the options below that characterize the feedback supply" class="mdi mdi-information-outline"></i></h5>
                            </label>
                            <div class="form-group col-md-12">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="feedstock_supply_risk" id="feedstock_supply_risk1" value="0.5" {{ ( !empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['feedstock_supply_risk'] == 0.5 ) ? "checked" : ""}}>
                                        Large-scale availability (commodity chemical or fuel) and the major current application is of a lower value than the one targeted.
                                        <i class="input-frame"></i>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="feedstock_supply_risk" id="feedstock_supply_risk1" value="1.0" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['feedstock_supply_risk'] == 1.0 ) ? "checked" : ""}}>
                                        Potential for near-term bulk availability. Multiple equivalent or lower-value applications in sight.Feedstock under development.
                                        <i class="input-frame"></i>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="feedstock_supply_risk" id="feedstock_supply_risk1" value="1.5" {{ ( !empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['feedstock_supply_risk'] == 1.5 ) ? "checked" : ""}}>
                                        Conceptual feedstock (needs fundamental development). Potential applications have a higher value than the one proposed.
                                        <i class="input-frame"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <p class="text-left">This indicator takes into account the global feedstock availability. Technically speaking, a bulk of the available feedstock is only "available" if the proposed application is of a higher value than the current application. For a lower-value proposed application, additional feedstock needs to be produced, since the currently available feedstock will not be diverted from a higher-value application. Hence it is important to take into account the value of the proposed application when feedstock availability is considered.</p>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="form-row">
                            <label class="control-label">
                                <h5>Regional feedstock availability<i data-toggle="tooltip" title="Select the most applicable statement from the options below that characterize the regional availability of the feedstock" data-original-title="" class="mdi mdi-information-outline"></i></h5>
                            </label>
                            <div class="form-group col-md-12">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="regional_feedstock_availability" id="regional_feedstock_availability_1" value="0" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['regional_feedstock_availability'] == 0 ) ? "checked" : ""}}>
                                        Feedstock available in bulk quantities within a trade region (e.g., the European Union).
                                        <i class="input-frame"></i>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="regional_feedstock_availability" id="regional_feedstock_availability_2" value="0.5" {{ ( !empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['regional_feedstock_availability'] == 0.5 ) ? "checked" : ""}}>
                                        Feedstock available in other parts of the world in free and open markets.
                                        <i class="input-frame"></i>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="regional_feedstock_availability" id="regional_feedstock_availability_3" value="1.0" {{ ( !empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['regional_feedstock_availability'] == 1 ) ? "checked" : ""}}>
                                        Feedstock primarily available in regulated markets with limited global market access.
                                        <i class="input-frame"></i>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="regional_feedstock_availability" id="regional_feedstock_availability_4" value="1.5" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['regional_feedstock_availability'] == 1.5 ) ? "checked" : ""}}>
                                        Feedstock available in other parts of the world in free and open markets.
                                        <i class="input-frame"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <p class="text-left">This indicator is used to incorporate feedstock security issues and local growth opportunities.
                        <p>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="form-row">
                            <label class="control-label">
                                <h5>Market Risk <i data-toggle="tooltip" title="Select the most applicable statement from the options below that characterize the markets for the products from this process" data-original-title="" class="mdi mdi-information-outline"></i></h5>
                            </label>
                            <div class="form-group col-md-12">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="market_risk" id="market_risk_1" value="0" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['market_risk'] == 0 ) ? "checked" : ""}}>
                                        Existing bulk chemical/fuel market.
                                        <i class="input-frame"></i>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="market_risk" id="market_risk_2" value="0.33" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['market_risk'] == 0.33 ) ? "checked" : ""}}>
                                        Existing commodity (e.g., lactic acid).
                                        <i class="input-frame"></i>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="market_risk" id="market_risk_3" value="0.66" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['market_risk'] == 0.66 ) ? "checked" : ""}}>
                                        Near-term bulk chemical/fuel market potential.
                                        <i class="input-frame"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <p class="text-left">This indicator is used to incorporate feedstock security issues and local growth opportunities.
                        <p>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="form-row">
                            <label class="control-label">
                                <h5>Infrastructure (availability) risk <i data-toggle="tooltip" title="Select the most applicable statement from the options below that characterize the infrastructure requirement for this process" data-original-title="" class="mdi mdi-information-outline"></i></h5>
                            </label>
                            <div class="form-group col-md-12">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="Infrastructure" id="Infrastructure_1" value="0" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['Infrastructure'] == 0 ) ? "checked" : ""}}>The process can be integrated or retrofitted into existing processing infrastructure. Also, the existing target product is part of existing processing and supply chains.
                                        <i class="input-frame"></i>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="Infrastructure" id="Infrastructure_2" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['Infrastructure'] == 0.33 ) ? "checked" : ""}} value="0.33">
                                        New processing plants are required based on known technologies. Also, the existing target product is part of existing processing and supply chains.
                                        <i class="input-frame"></i>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="Infrastructure" id="Infrastructure_3" value="0.66" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['Infrastructure'] == 0.66 ) ? "checked" : ""}}>
                                        New processing plants are required based on known technologies. Also, the target product is new and would need new processing and supply chains.
                                        <i class="input-frame"></i>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="Infrastructure" id="Infrastructure_4" value="1" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['Infrastructure'] == 1 ) ? "checked" : ""}}>
                                        New greenfield process plants built with new technologies. Also, the target product is new and would need new processing and supply chains.
                                        <i class="input-frame"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <h2>Application Technical Aspect</h2>
            <section>
                <h5>Application-Technical Aspects</h5>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" onclick="select_radio('1')" id="Chemical_show" name="select_please" value="ch">
                                Chemicals.
                                <i class="input-frame"></i>
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" onclick="select_radio('3')" id="fuel_show" name="select_please" value="fu">
                                Fuels.
                                <i class="input-frame"></i>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-row" id="rd1">
                    <div class="form-group col-md-12">
                        <label class="control-label">
                            <h5> Functional groups</h5>
                            <p>(defined as the number of same or different functional groups on the hydrocarbon backbone)</p>
                        </label>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" id="Chemical_show_1" name="functional_groups" value="0" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['functional_groups'] == 0 ) ? "checked" : ""}}>
                                Between 2 and 4 functional groups. Platform molecule.Wider potential applications.
                                <i class="input-frame"></i>
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" id="Chemical_show_2" name="functional_groups" value="0.5" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['functional_groups'] == 0.5 ) ? "checked" : ""}}>
                                More than 4 functional groups. Difficult platform molecule to work with, which can narrow down potential applications.
                                <i class="input-frame"></i>
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" id="Chemical_show_3" name="functional_groups" value="1" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['functional_groups'] == 1 ) ? "checked" : ""}}>
                                One functional group. Limited potential for platform chemical.
                                <i class="input-frame"></i>
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <h5>Retention of raw material functionality</h5>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" id="Chemical_show_4" name="retention_raw_material" value="0" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['retention_raw_material'] == 0 ) ? "checked" : ""}}>
                                Complete functionality is preserved. Fundamentally efficient approach, that can offer future improvement potential.
                                <i class="input-frame"></i>
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" id="Chemical_show_5" name="retention_raw_material" value="0.5" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['retention_raw_material'] == 0.5 ) ? "checked" : ""}}>
                                Limited modification of functionality.
                                <i class="input-frame"></i>
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" id="Chemical_show_6" name="retention_raw_material" value="1" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['retention_raw_material'] == 1 ) ? "checked" : ""}}>
                                All functionality stripped off.Lower theoretical improvement potential.
                                <i class="input-frame"></i>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-row" id="rd2">
                    <div class="form-group col-md-12">
                        <h5>
                            Energy density
                        </h5>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" id="fuel_show_1" name="energy_density" value="0" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['energy_density'] == 0 ) ? "checked" : ""}}>
                                High energy density.Greater than or equivalent to gasoline/diesel(as applicable)
                                <i class="input-frame"></i>
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" id="fuel_show_2" name="energy_density" value="0.5" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['energy_density'] == 0.5 ) ? "checked" : ""}}>
                                Energy density 80-90% that of gasoline/diesel
                                <i class="input-frame"></i>
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" id="fuel_show_3" name="energy_density" value="1" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['energy_density'] == 1 ) ? "checked" : ""}}>
                                Energy density below 80% that of gasoline/diesel.
                                <i class="input-frame"></i>
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <h4>Engine compatibility </h4>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" id="fuel_show_4" name="engine_compatibility" value="0" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['engine_compatibility'] == 0 ) ? "checked" : ""}}>
                                Perfectly compatible. Gasoline/diesel equivalent.No engine modification required for use.
                                <i class="input-frame"></i>
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" id="fuel_show_5" name="engine_compatibility" value="0.5" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['engine_compatibility'] == 0.5 ) ? "checked" : ""}}>
                                Potential for use in existing engines when mixed with gasoline/diesel.
                                <i class="input-frame"></i>
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" id="fuel_show_6" name="engine_compatibility" value="1" {{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['engine_compatibility'] == 1 ) ? "checked" : ""}}>
                                Engine modification necessary for use.Will be a critical application barrier.
                                <i class="input-frame"></i>
                            </label>
                        </div>
                    </div>
                </div>
            </section>
            <h2>Application Technical Aspect</h2>
            <section>
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label class="control-label">Feedstock Supply Risk
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Feedstock Supply Risk"></i></span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="feedstock_supply_risk_input" id="feedstock_supply_risk_input" value="{{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['feedstock_supply_risk_input'] != "") ? $process_dataset['quality_assesment']['feedstock_supply_risk_input']:""}}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="control-label">Regional Feedstock availability
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Regional Feedstock availability"></i></span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="regional_feedstock_input" id="regional_feedstock_input" value="{{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['regional_feedstock_input'] != "") ? $process_dataset['quality_assesment']['regional_feedstock_input']:""}}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="control-label">Market Risk
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Market Risk"></i></span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="market_risk_input" value="{{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['market_risk_input'] != "") ? $process_dataset['quality_assesment']['market_risk_input']:""}}" id="market_risk_input">
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="control-label">Infrastructure (Availability)
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Infrastructure (Availability)"></i></span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="infrastructure_avl_input" id="infrastructure_avl_input" value="{{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['infrastructure_avl_input'] != "") ? $process_dataset['quality_assesment']['infrastructure_avl_input']:""}}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="control-label">Application-Technical Aspects
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Application-Technical Aspects"></i></span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="application_technical_input" id="application_technical_input" value="{{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['application_technical_input'] != "") ? $process_dataset['quality_assesment']['application_technical_input']:""}}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="control-label">Fuels: High Energy Content
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Fuels: High Energy Content"></i></span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="fuels_heigh_input" id="fuels_heigh_input" value="{{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['fuels_heigh_input'] != "") ? $process_dataset['quality_assesment']['fuels_heigh_input']:""}}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="control-label">Fuels: Engine Compatibility
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Fuels: Engine Compatibility"></i></span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="fuels_engine_input" id="fuels_engine_input" value="{{ (!empty($process_dataset['quality_assesment']) && $process_dataset['quality_assesment']['fuels_engine_input'] != "") ? $process_dataset['quality_assesment']['fuels_engine_input']:""}}">
                    </div>
                </div>
            </section>
        </div>
    </form>
</div>

<script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
<script src="{{asset('assets/js/test.js')}}"></script>
<script src="{{ asset('assets/js/tinymce.js') }}"></script>
<script>
$("#wizard").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        labels: {
            finish: "Submit",
        },
        onFinished: function(event, currentIndex) {
            ///Genral Risk Aspec

            dataset_id =  $("#dataset_id").val();
            var feedstock_supply_risk = $("input[name='feedstock_supply_risk']:checked").val();
            var regional_feedstock_availability = $("input[name='regional_feedstock_availability']:checked").val();
            var market_risk = $("input[name='market_risk']:checked").val();
            var Infrastructure = $("input[name='Infrastructure']:checked").val();
            ///Application Technical Aspect 
            //chemical
            var functional_groups = $("input[name='functional_groups']:checked").val();
            var retention_raw_material = $("input[name='retention_raw_material']:checked").val();
            //fueal
            var energy_density = $("input[name='energy_density']:checked").val();
            var engine_compatibility = $("input[name='engine_compatibility']:checked").val();
            ///Application Technical Aspect
            feedstock_supply_risk_input = document.getElementById('feedstock_supply_risk_input').value;
            regional_feedstock_input = document.getElementById('regional_feedstock_input').value;
            market_risk_input = document.getElementById('market_risk_input').value;
            infrastructure_avl_input = document.getElementById('infrastructure_avl_input').value
            application_technical_input = document.getElementById('application_technical_input').value;
            fuels_heigh_input = document.getElementById('fuels_heigh_input').value;
            fuels_engine_input = document.getElementById('fuels_engine_input').value
            var objJson = {
                "feedstock_supply_risk": feedstock_supply_risk,
                "regional_feedstock_availability": (regional_feedstock_availability) ? regional_feedstock_availability : "",
                "market_risk": (market_risk) ? market_risk : "",
                "Infrastructure": (Infrastructure) ? Infrastructure : "",
                "functional_groups": (functional_groups) ? functional_groups : "",
                "retention_raw_material": (retention_raw_material) ? retention_raw_material : "",
                "energy_density": (energy_density) ? energy_density : "",
                "engine_compatibility": (engine_compatibility) ? engine_compatibility : "",
                "feedstock_supply_risk_input": feedstock_supply_risk_input,
                "regional_feedstock_input": regional_feedstock_input,
                "market_risk_input": market_risk_input,
                "infrastructure_avl_input": infrastructure_avl_input,
                "application_technical_input": application_technical_input,
                "fuels_heigh_input": fuels_heigh_input,
                "fuels_engine_input": fuels_engine_input
            }
            var objectWiz = {
                "dataset_id": dataset_id,
                "quality_assesment": objJson
            };
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{ url('/mfg_process/simulation/dataset/qual_assesment')}}",
                data: JSON.stringify(objectWiz),
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.success === true) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        Toast.fire({
                            icon: 'success',
                            title: data.message,
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.errors,
                        })
                    }
                },
            });
        }
    });
    var viewflag = '{{$viewflag}}'
    if(viewflag=='view_config'){
        $("input").prop("disabled", true);
        $("textarea").prop("disabled", true);
    }
</script>
