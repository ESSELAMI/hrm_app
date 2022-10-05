@extends('layouts.base')

@section('page-styles')
    <style>
    .jFiler-theme-default .jFiler-input-button {
    background-color: #404e67;
    background-image: none;
    color: #fff;
}
.jFiler-theme-default .jFiler-input {
   height: 40px;
   width: 120%;
   font-size: 14px
}
    .ms-container .ms-selectable li.ms-hover, .ms-container .ms-selection li.ms-hover {
    background-color: #404e67;
}
.btn {

line-height: 1.25;
}
.form-control {

height: 40px;
}
.btn-light{
    border-color: #404e67;
}

    </style>
@endsection

@section('page_title')
<h4>Ajouter un véhicule</h4>
<span>Veuillez remplir le formulaire suivant</span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
<a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
<a href="{{ route('create-vehicle') }}">Ajouter un véhicule</a>
</li>
@endsection


@include('parc_manager.navigation')


@section('page_content')
<div class="row">
    <div class="col-lg-12 ">
        <div class="card" id="add-vehicle-form">
            <div class="card-header">
                <h5 class="text-danger">Veuillez remplir tous les champs obligatoires (*)</h5>
                <div v-if="errors.length"> @{{ errors }}</div>
            </div>
            <div class="card-block">

                <h6 class="sub-title">Renseignements du véhicule <span class="text-danger">(*)</span> </h6>
                <form>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="brands" class="block">Marque du véhicule <span class="text-danger"> (*)</span></label>
                            <div :class="[errors.vehicle_model_id ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                <select id="brands" class="selectpicker show-tick" data-live-search="true" title="Marque..." v-model="brand"
                                    data-width="100%" data-size="7" v-on:change="show_models($('#brands').selectpicker('val'))">
                                    @foreach ($brands as $brand)
                                    <option value="{{$brand->name}}" v-model="vehicle_model_id"> {{$brand->name}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-addon">
                                    <i class="icofont icofont-brand-mercedes" data-toggle="tooltip" data-placement="top"
                                        :data-original-title="errors.vehicle_model_id"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="-date" class="block">Modèle du véhicule <span class="text-danger">(*)</span></label>
                            <div :class="[errors.vehicle_model_id ? 'input-group input-group-danger' : 'input-group input-group-inverse']"
                            data-toggle="tooltip" data-placement="top" :data-original-title="errors.vehicle_model_id">
                                <select id="models" class="selectpicker show-tick" data-live-search="true" title="Modèle..."
                                    data-width="100%" data-size="7" data-hide-disabled= 'true' >

                                    @foreach ($brands as $brand)
                                    <optgroup label="{{$brand->name}}" disabled>
                                        @foreach ($brand->models as $model)
                                        <option value="{{$model->id}}" v-model="vehicle_model_id"> {{$model->name}}</option>
                                        @endforeach
                                    </optgroup>
                                    @endforeach
                                </select>
                                <span class="input-group-addon">
                                    <i class="icofont icofont-car" data-toggle="tooltip" data-placement="top"
                                        :data-original-title="errors.vehicle_model_id"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="energy_types" class="block">Energie <span class="text-danger">(*)</span></label>
                            <div :class="[errors.energy_type_id ? 'input-group input-group-danger' : 'input-group input-group-inverse']"
                            data-toggle="tooltip" data-placement="top" :data-original-title="errors.energy_type_id">
                                <select id="energy_types" class="selectpicker show-tick" title="Energie..."
                                    data-width="100%">
                                    @foreach ($energyTypes as $energyType)
                                    <option value="{{$energyType->id}}" v-model="energy_type_id"> {{$energyType->name}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-addon">
                                    <i class="icofont icofont-water-drop"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="horsepower" class="block">Puissance <span class="text-danger">(*)</span></label>
                            <div :class="[errors.horsepower ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                                <input id ="horsepower" type="number" class="form-control" placeholder="Nombre de chevaux..." v-model="horsepower"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.horsepower">
                                <span class="input-group-addon">
                                    <i class="icofont icofont-dashboard"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="engine" class="block">Motorisation <span class="text-danger">(*)</span></label>
                            <div :class="[errors.engine ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                                <input id ="engine" type="text" class="form-control" placeholder="Type du moteur : 1.2, 1.4, 1,6..." v-model="engine"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.engine">
                                <span class="input-group-addon">
                                    <i class="icofont icofont-speed-meter"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="-date" class="block">Numéro de chassis <span class="text-danger">(*)</span></label>
                            <div :class="[errors.identification_number ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                                <input type="text" class="form-control" placeholder="Numéro de chassis..." v-model="identification_number"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.identification_number">
                                <span class="input-group-addon">
                                    <i class="icofont icofont-social-slack"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="-date" class="block">Numéro d'Immatriculation <span class="text-danger">(*)</span></label>
                            <div :class="[errors.licence_plate ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                                <input type="text" class="form-control" placeholder="Immatriculaton..." v-model="licence_plate"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.licence_plate">
                                <span class="input-group-addon">
                                    <i class="icofont icofont-social-slack"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="-date" class="block">Immatriculation ancienne <span class="text-danger">(*)</span></label>
                            <div :class="[errors.old_licence_plate ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                                <input type="text" class="form-control" placeholder="Immatriculaton Ancienne" v-model="old_licence_plate"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.old_licence_plate">
                                <span class="input-group-addon">
                                    <i class="icofont icofont-social-slack"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-sm-5">
                            <label for="-date" class="block">Etat général du Véhicule <span class="text-danger">(*)</span></label>
                            <div :class="[errors.status ? 'input-group input-group-danger' : 'input-group input-group-inverse']"
                            data-toggle="tooltip" data-placement="top" :data-original-title="errors.status">
                                <select id="conditions" class="selectpicker show-tick" title="Etat général..."
                                    data-width="100%">
                                    @foreach ($conditions as $condition)
                                    <option value="{{$condition->name}}" v-model="status"> {{$condition->name}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-addon">
                                    <i class="icofont icofont-checked"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-sm-5">
                            <label for="-date" class="block">Type du véhicule <span class="text-danger">(*)</span></label>
                            <div :class="[errors.vehicle_type_id ? 'input-group input-group-danger' : 'input-group input-group-inverse']"
                            data-toggle="tooltip" data-placement="top" :data-original-title="errors.vehicle_type_id">
                                <select id="vehicle-types" class="selectpicker show-tick" title="Type du véhicule..."
                                    data-width="100%">
                                    @foreach ($vehicleTypes as $vehicleType)
                                    <option value="{{$vehicleType->id}}" v-model="vehicle_type_id">
                                        {{$vehicleType->name}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-addon">
                                    <i class="icofont icofont-vehicle-delivery-van"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="-date" class="block">Traqué par GPS <span class="text-danger">(*)</span></label>
                            <div :class="[errors.has_gps_tracker ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                                <select id="has_gps_tracker" class="selectpicker show-tick" title="GPS..." data-width="100%"
                                data-toggle="tooltip" data-placement="top" :data-original-title="errors.has_gps_tracker">
                                    <option value="1" v-model="has_gps_tracker"> OUI</option>
                                    <option value="0" v-model="has_gps_tracker"> NON</option>
                                </select>
                                <span class="input-group-addon">
                                    <i class="icofont icofont-location-pin"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="-date" class="block">Kilométrage <span class="text-danger">(*)</span></label>
                            <div :class="[errors.kilometrage ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                                <input type="number" class="form-control" placeholder="Kilométrage..." v-model="kilometrage"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.kilometrage" min="0">
                                <span class="input-group-addon">
                                    <i class="icofont icofont-ui-map"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <h5 class="sub-title">Assurance du véhicle <span class="text-danger">(*)</span></h5>
                <form>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="-date" class="block">Compagnie d'assurance <span class="text-danger">(*)</span></label>
                            <div :class="[errors.insurance_company_id ? ' input-group input-group-danger' : ' input-group input-group-inverse']"
                                data-toggle="tooltip" data-placement="top" :data-original-title="errors.insurance_company_id">
                                <select id="insurance-companies" class="selectpicker show-tick" title="Compagnie d'assurance.."
                                    data-width="100%">
                                    @foreach ($insuranceCompanies as $insuranceCompany)
                                    <option value="{{$insuranceCompany->id}}">{{$insuranceCompany->name}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-addon">
                                    <i class="icofont icofont-listing-box"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="-date" class="block">Date d'assurance <span class="text-danger">(*)</span></label>
                            <div :class="[errors.insurance_dates ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                                <input id="insurance-dates" type="text" class="form-control" placeholder="Date d'assurance..."
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.insurance_dates"
                                   >
                                <span class="input-group-addon">
                                    <i class="icofont icofont-calendar"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="-date" class="block">Numéro du police <span class="text-danger">(*)</span></label>
                            <div :class="[errors.police_number ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                <input type="number" class="form-control" placeholder="Numéro du police..." data-toggle="tooltip"
                                    data-placement="top" :data-original-title="errors.police_number" v-model="police_number" min="0">
                                <span class="input-group-addon">
                                    <b class="icofont icofont-police-cap"></b>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="-date" class="block">Coût <span class="text-danger">(*)</span></label>
                            <div :class="[errors.cost ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                <input type="number" class="form-control" placeholder="Coût..." data-toggle="tooltip"
                                    data-placement="top" :data-original-title="errors.cost" v-model="cost" min="0">
                                <span class="input-group-addon">
                                    <b class="fa fa-money"></b>
                                </span>
                            </div>
                        </div>

                    </div>
                </form>
                <hr>
                <h5 class="sub-title">Affectation du véhicle <span class="text-danger"> (*)</span></h5>
                <form>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="-date" class="block">Propriétaire du véhicule <span class="text-danger"> (*)</span></label>
                            <div :class="[errors.owner_id ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                data-toggle="tooltip" data-placement="top" :data-original-title="errors.owner_id">
                                <select id="owners" class="selectpicker show-tick" title="Propriétaire du véhicule.."
                                    data-width="100%">
                                    @foreach ($owners as $owner)
                                    <option value="{{$owner->id}}">{{$owner->name}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-addon">
                                    <i class="icofont icofont-id-card"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="decision-number" class="block">Numéro du décision d'affectation <span class="text-danger"> (*)</span></label>
                            <div :class="[errors.decision_number ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                <input id="decision-number" type="number" class="form-control" placeholder="Numéro du décision..."
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.decision_number"
                                    v-model="decision_number">
                                <span class="input-group-addon">
                                    <strong class="icofont icofont-social-slack"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="decision-date" class="block">Date d'affectation <span class="text-danger"> (*)</span></label>
                            <div :class="[errors.decision_date ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                <input id="decision-date" name="birthdate" type="text" class="text-center form-control" placeholder="Date d'affectation..."
                                    data-toggle="tooltip" data-placement="top"
                                    :data-original-title="errors.decision_date" >
                                <span class="input-group-addon">
                                    <i class="icofont icofont-calendar"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-sm-6"  >
                            <label for="-date" class="block">Décision d'affectation <span class="text-danger">(*) </span></label>
                            <div :class="[errors.decision_file ? '  input-group input-group-danger' : ' input-group input-group-inverse']" v-on:click="$('#files').click()">
                                <input id="decision-file" name="birthdate" type="text" class="form-control bg-white" placeholder="Décison d'affectation scannée..."
                                data-toggle="tooltip" data-placement="top"
                                :data-original-title="errors.decision_file" readonly >
                                <span class="input-group-addon">
                                    <i class="icofont icofont-file-pdf"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-sm-6 form-group-danger" style="display:none">
                            <label for="-date" class="block">Décision d'affectation <span class="text-danger">(*) </span></label>
                            <div :class="[errors.decision_file ? 'input-group input-group-danger' : 'input-group input-group-inverse']"
                            data-toggle="tooltip" data-placement="top"
                                    :data-original-title="errors.decision_file">
                                <input type="file" id="files" ref="files" name="decision_file"
                                    v-on:change="handleFilesUpload()"  />
                            </div>
                        </div>
                    </div>
                </form>
                <hr>

            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <button type="submit" class="btn btn-primary m-r-10" v-on:click="add_vehicle()">
                            Sauvgarder
                        </button>
                        <button type="submit" class="btn btn-default" v-on:click="reset_form()">Réinitialiser</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('page_scripts')
<script>
    $(document).ready(function () {
        $('#conditions').selectpicker();
        $('#brands').selectpicker();
        $('#models').selectpicker();
        $('#energy-types').selectpicker();
        $('#vehicle-types').selectpicker();
        $('#has_gps_tracker').selectpicker();
    });
</script>
<script>
    const app = new Vue({
        el: '#app',
        data() {
            return {
                brand:'',
                loading: false,
                licence_plate: '',
                old_licence_plate: '',
                status: '',
                has_gps_tracker: '',
                identification_number: '',
                flag: '',
                structure_id: '',
                vehicle_model_id: '',
                vehicle_type_id: '',
                fuel_card_id: '',
                police_number: '',
                kilometrage: '',
                owner_id: '',
                energy_type_id: '',
                insurance_type: '',
                insurance_dates: '',
                started_at: '',
                ended_at: '',
                insurance_company_id: '',
                cost: '',
                decision_number: '',
                decision_date: '',
                decision_file: '',
                decision_file_name: '',
                horsepower: '',
                engine: '',
                errors: [],
                notifications:[],
            }
        },
        methods: {
            fetch_notifications(){
                    var app = this;
                    return axios.get('/getNotifications')
                        .then(function (response) {
                            app.notifications = response.data.notifications;
                            if (app.notifications.length > 0 ) {
                                ion.sound.play("ding_ding", {
                                    loop: 2
                                });
                            }
                        });
                },
            add_vehicle() {
                var app = this;
                app.status = $('#conditions').selectpicker('val');
                app.has_gps_tracker = $('#has_gps_tracker').selectpicker('val');
                app.vehicle_model_id = $('#models').selectpicker('val');
                app.vehicle_type_id = $('#vehicle-types').selectpicker('val');
                app.energy_type_id = $('#energy_types').selectpicker('val');
                app.owner_id = $('#owners').selectpicker('val');
                app.insurance_company_id = $('#insurance-companies').selectpicker('val');
                app.decision_date = formatDate($('#decision-date').data('daterangepicker').startDate);
                app.started_at = formatDate($('#insurance-dates').data('daterangepicker').startDate);
                app.ended_at = formatDate($('#insurance-dates').data('daterangepicker').endDate);
                app.decision_file = app.$refs.files.files[0];


                let formData = new FormData();
                formData.append('engine', this.engine);
                formData.append('licence_plate', this.licence_plate);
                formData.append('old_licence_plate', this.old_licence_plate);
                formData.append('status', this.status);
                formData.append('has_gps_tracker', this.has_gps_tracker);
                formData.append('identification_number', this.identification_number);
                formData.append('vehicle_model_id', this.vehicle_model_id);
                formData.append('vehicle_type_id', this.vehicle_type_id);
                formData.append('kilometrage', this.kilometrage);
                formData.append('energy_type_id', this.energy_type_id);
                formData.append('horsepower', this.horsepower);

                formData.append('started_at', this.started_at);
                formData.append('ended_at', this.ended_at);
                formData.append('insurance_company_id', this.insurance_company_id);
                formData.append('police_number', this.police_number);
                formData.append('cost', this.cost);

                formData.append('owner_id', this.owner_id);
                formData.append('decision_file', this.decision_file);
                formData.append('decision_number', this.decision_number);
                formData.append('decision_date', this.decision_date);

                app.block('add-vehicle-form');
                axios.post('/add_vehicle', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (response) {
                        notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                        app.unblock('add-vehicle-form');
                        console.log(response.data.vehicle);

                         app.reset_form();

                    })
                    .catch(function (error) {
                        if (error.response) {
                            app.unblock('add-vehicle-form');
                            app.$set(app, 'errors', error.response.data.errors);
                            notify('Erreurs!', 'Veuillez vérifier les informations introduites', 'red', 'topCenter', 'bounceInDown');
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                    });
            },
            reset_form() {
                this.loading= false;
                this.licence_plate= '';
                this.old_licence_plate= '';
                this.status= '';
                this.has_gps_tracker= '';
                this.identification_number= '';
                this.flag= '';
                this.structure_id= '';
                this.vehicle_model_id= '';
                this.vehicle_type_id= '';
                this.fuel_card_id= '';
                this.police_number= '';
                this.kilometrage= '';
                this.owner_id= '';
                this.energy_type_id= '';
                this.insurance_type= '';
                this.insurance_dates= '';
                this.started_at= '';
                this.ended_at= '';
                this.insurance_company_id= '';
                this.cost= '';
                this.decision_number= '';
                this.decision_date= '';
                this.decision_file= '';
                this.decision_file_name= '';
                this.horsepower= '';
                this.engine= '';
                this.errors= [];
                $('#conditions').selectpicker('val',null);
                $('#has_gps_tracker').selectpicker('val',null);
                $('#models').selectpicker('val',null);
                $('#vehicle-types').selectpicker('val',null);
                $('#energy_types').selectpicker('val',null);
                $('#owners').selectpicker('val',null);
                $('#insurance-companies').selectpicker('val',null);

            },
            handleFilesUpload() {
                this.decision_file = this.$refs.files.files;
                this.decision_file_name = this.decision_file[0].name;
                $('#decision-file').val(this.decision_file_name);

            },
            block(element) {
                $('#' + element).block({
                    message: '<div class="preloader3 loader-block">' +
                        '<div class="circ1 loader-info"></div>' +
                        '<div class="circ2 loader-info"></div>' +
                        '<div class="circ3 loader-info"></div>' +
                        '<div class="circ4 loader-info"></div>' +
                        '</div>',
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: 0.5,
                        showOverlay: false,
                    }
                });
            },
            unblock(element) {
                $('#' + element).unblock();
            },
            show_models(brand) {
                //$('#code_wilaya').val('');
                $('#models').find('[label]').attr('disabled',true);
                $('#models').find("[label='"+brand+"']").attr('disabled',false);
                $('#models').selectpicker('refresh');
                },

            get_wilaya() {
                $('#code_wilaya').val('');
                var value = $('#structure_affectation').val();
                var code_wilaya = $('.selectpicker').find("[value='"+value+"']" ).attr('code_wilaya');
                    $('#code_wilaya').val(code_wilaya);
                }
        },
        mounted() {
            this.fetch_notifications();
            $('#decision-date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                "opens": "center",
                "locale": {
                    "format": "DD/MM/YYYY",
                    "daysOfWeek": [
                        "Di",
                        "Lu",
                        "Ma",
                        "Me",
                        "Je",
                        "Ve",
                        "Sa"
                    ],
                    "monthNames": [
                        "Janvier",
                        "Février",
                        "Mars",
                        "Avril",
                        "Peut",
                        "Juin",
                        "Juillet",
                        "Août",
                        "Septembre",
                        "Octobre",
                        "Novembre",
                        "Décembre"
                    ],
                    "firstDay": 1
                }
            });
            $('#files').filer({
                limit: 1,
                maxSize: 1,
                extensions: ['jpg', 'jpeg', 'png', 'pdf'],
                showThumbs: false,
                addMore: false,
                changeInput: true,
                maxSize: 100,

                captions: {
                    button: "<span class='icofont icofont-file-pdf'> </span>",
                    feedback: "Décision d'affectation scannée...",
                    feedback2: "Fichier sélectionné &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp" +
                        "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",

                    errors: {
                        filesLimit: 'Only ${limit} files are allowed to be uploaded.',
                        filesType: 'Veuillez sélectionner des fichiers de type : PDF, JPG, JPEG, PNG',
                        fileSize: '${name} is too large! Please choose a file up to ${fileMaxSize}MB.',
                        filesSizeAll: 'Files that you chose are too large! Please upload files up to ${maxSize} MB.',
                        fileName: 'File with the name ${name} is already selected.',
                        folderUpload: 'Veuillez sélectionner des fichiers uniquement (pas de dossiers!)'
                    }
                },

            });

            $('#insurance-dates').daterangepicker({
                "autoApply": true,
                "parentEl": "body",
                "opens": "right",
                "drops": "up",
                "locale": {
                    "format": "DD/MM/YYYY",
                    "separator": " - ",
                    "applyLabel": "Ok",
                    "cancelLabel": "Cancel",
                    "fromLabel": "From",
                    "toLabel": "To",
                    "customRangeLabel": "Custom",
                    "weekLabel": "W",
                    "daysOfWeek": [
                        "Di",
                        "Lu",
                        "Ma",
                        "Me",
                        "Je",
                        "Ve",
                        "Sa"
                    ],
                    "monthNames": [
                        "Janvier",
                        "Février",
                        "Mars",
                        "Avril",
                        "Peut",
                        "Juin",
                        "Juillet",
                        "Août",
                        "Septembre",
                        "Octobre",
                        "Novembre",
                        "Décembre"
                    ],
                    "firstDay": 1
                },
                "alwaysShowCalendars": true,
            }, function (start, end, label) {
                console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
            });

        }


    });

</script>







@endsection
