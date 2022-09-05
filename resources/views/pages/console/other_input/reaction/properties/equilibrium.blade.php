<div class="tab-pane fade" id="v-equilibrium" role="tabpanel" aria-labelledby="v-equilibrium-tab">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <ul id="list-example" class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link show active" id="equi_user_input_tab" data-toggle="tab" href="#equi_user_input" role="tab" aria-controls="user_input" aria-selected="true">User Input</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="equi_calculation_tab" data-toggle="tab" href="#equi_calculation" role="tab" aria-controls="equi_calculation" aria-selected="false">Calculate</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        @include('pages.console.other_input.reaction.properties.equi-user_input')
                        @include('pages.console.other_input.reaction.properties.equi-calculation')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>