<div class="tab-pane fade show active" id="v-rate_parameter" role="tabpanel" aria-labelledby="v-rate_parameter-tab">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <ul id="list-example" class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link show active" id="user_input_tab" data-toggle="tab" href="#user_input" role="tab" aria-controls="user_input" aria-selected="true">User Input</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="calculation_tab" data-toggle="tab" href="#calculation" role="tab" aria-controls="calculation" aria-selected="false">Calculate</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content profile-tab" id="myTabContent">
                        @include('pages.console.other_input.reaction.properties.user_input')
                        @include('pages.console.other_input.reaction.properties.calculation')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>