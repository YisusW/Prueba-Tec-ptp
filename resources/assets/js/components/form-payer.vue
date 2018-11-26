<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header text-center">Registro del pagador</div>

                    <div class="card-body">


                      <div v-show="options==true" class="row">
                          <div class="card" style="margin: auto;">
                            <div class="card-body">
                                <h3 class="card-text">Usar datos del Comprador </h3>
                                <a v-bind:href="url_bank" class="btn btn-info text-white">Seguir Comprando</a>
                            </div>
                          </div>
                          <div class="card" style="margin: auto;">
                            <div class="card-body">
                                <h3 class="card-text">Registrar Pagador </h3>
                                <button type="button" name="button" class="btn btn-secondary" v-on:click="options=2">Regsitrar Pagador</button>
                            </div>
                          </div>
                      </div>

                      <div v-show="options == 1" class="">
                          <div class="alert aler-info">
                            <strong>Información</strong> Para usar los datos del Comprador continua haciendo clic en el botón
                          </div>
                          <a v-bind:href="url_bank" type="button" class="btn btn-info btn-block" name="button">Usar datos del Comprador</a>
                      </div>

                      <div v-show="options == 2" class="">

                          <button type="button" name="button" class="btn btn-secondary mb-2" v-on:click="options=true"><< Volver</button>
                          <div v-if="message_validate_form != null && message_success==false" class="alert alert-warning">
                              <strong>Debes completar el formulario !</strong> {{message_validate_form}}
                          </div>

                          <div v-if="message_success==true" class="alert alert-success">
                              <strong>Datos Guardados correctamente !</strong> el comprador se ha registrado Correctamente
                          </div>

                          <form class="form" action="index.html" method="post">
                            <!-- Tipo de Documento -->
                            <div class="form-group">
                                <label for="method">Tipo de Documento</label>
                                <select class="form-control" name="type_documnet" v-model="type_document">
                                  <option value="CC" >Cédula de ciudanía colombiana</option>
                                  <option value="CE" >Cédula de extranjería</option>
                                  <option value="TI" >Tarjeta de identidad</option>
                                  <option value="PPN" >Pasaporte</option>
                                  <option value="NIT" >Número de identificación tributaria</option>
                                  <option value="SSN" >Social Security Number</option>
                                </select>
                            </div>
                            <!--  Documento -->
                            <div class="form-group">
                                <label for="method">Documento de identidad</label>
                                <input type="text" name="name" class="form-control" required="true" v-model="documnet" >
                            </div>
                            <!--  Tipo de persona -->
                            <div class="form-group">
                                <label for="">Tipo de persona</label>
                                <select class="form-control" name="" v-model="type_person">
                                  <option v-for="value in types_person" :value="value.id">{{ value.description }}</option>
                                </select>
                            </div>
                            <!-- Nombre -->
                            <div class="form-group">
                                <label for="method">Nómbre</label>
                                <input type="text" name="name" class="form-control" required="true" v-model="firstname" >
                            </div>
                            <!-- Apellido -->
                            <div class="form-group">
                                <label for="">Apellido</label>
                                <input type="text" name="last_name" class="form-control" required="true" v-model="lastname" >
                            </div>
                            <!-- email -->
                            <div class="form-group">
                              <label for="">Correo Electrónico</label>
                              <input type="email" name="email" value="" v-model="email" class="form-control">
                            </div>
                            <!-- Departamento -->
                            <div class="form-group">
                                <label for="method">Departamento</label>
                                <select class="form-control" name="departament" v-model="departament" v-on:change="getCities" >
                                 <option v-for="value in departaments"
                                         :value="value.id">{{ value.description }} </option>
                                </select>
                            </div>
                            <!-- Ciudad -->
                            <div class="form-group">
                                <label for="method">Ciudad</label>
                                <select class="form-control" name="city" v-model="city">
                                  <option v-for="value in cities"
                                          :value="value.id">{{ value.description }} </option>
                                </select>
                            </div>
                            <!-- Dirección -->
                            <div class="form-group">
                                <label for="">Dirección</label>
                                <textarea name="name" class="form-control" v-model="address"></textarea>
                            </div>
                            <!-- telefono -->
                            <div class="form-group">
                                <label for="">Teléfono (fíjo)</label>
                                <input type="text" name="" class="form-control" value=""  v-model="phone">
                            </div>
                            <!-- Celular -->
                            <div class="form-group">
                                <label for="">Celular</label>
                                <input type="text" name="" value="" class="form-control" v-model="mobile">
                            </div>
                            <!-- Compañia -->
                            <div class="form-group">
                                <label for="">Compañia</label>
                                <input type="text" name="" value="" class="form-control" v-model="company">
                            </div>

                            <div v-if="message_success==true" class="alert alert-success">
                                <strong>Datos Guardados correctamente !</strong> el siguiente paso es registrar un pagador
                            </div>
                            <!-- botones -->
                              <button v-if="message_success==false" v-on:click="register"  type="button" name="button" class="btn btn-success btn-block" >Enviar</button>
                              <a v-if="message_success==true" v-bind:href="url_pay"  role="button" class="btn btn-info btn-block" >Registrar Pagador</a>
                          </form>
                      </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id_bayer'],
        data :function (){
          return {
            options : true,
            pagar_comprador : "",
            /* array to show list */
            departaments          : [],
            cities                : [],
            types_person          : [],
            /* array select */
            departament           : "",
            city                  : "",
            address               : "",
            type_document         : "",
            documnet              : "",
            email                 : "",
            firstname             : "",
            lastname              : "",
            phone                 : "",
            mobile                : "",
            type_person           : "",
            company               : "",
            /* message form and other arguemtns */
            message_validate_form : "",
            url_bank              : "",
            message_success       : false
          }
        },
        mounted(){
          this.getDepartaments();
          this.getTypePerson();
          this.seturl()
        },
        methods :{
          seturl : function (){
            /* url para pasar a el formulario del banco*/
            this.url_bank = '/bankForm/'+this.id_bayer+'/'+this.id_bayer+'/';
          },

          /** Mandar el formulario  */
          register : function (){
               let valid = this.validateForm();
               if ( !valid ) return valid;
               let data = this.get_form();

               axios.post('/bayer' ,  data ).then( (response) => {

                 if (response.data.result == 1) {
                    this.url_pay = "/bankForm/"+this.id_bayer+"/"+response.data.data.id
                    this.message_success = true
                 }

               })

          },
          /* Obtener el formulario */
          get_form : function (){
            return  {"email"         : this.email,
              "apellido"      : this.lastname,
              "nombre"        : this.firstname ,
              "documnet"      : this.documnet ,
              "type_document" : this.type_document,
              "address"       : this.address,
              "city"          : this.city,
              "phone"         : this.phone,
              "mobile"        : this.mobile,
              "type_person"   : this.type_person,
              "company"       : this.company
            }

          },
          /* Lista de departamentos */
          getDepartaments: function (){

              axios.get('/getDepartaments').then((response) => {
                if (response.data.result == 1) {
                    let states = this.departaments
                    response.data.data.forEach(function( value ){
                      states.push(value)
                    })
                } else {
                    this.message_validate_form = "La lista de departamentos no se cargó correctamente";
                }
              });

          },
          /* Lista de ciudades */
          getCities : function(){

                axios.get('/getCitiesByState/'+this.departament+'/').then((response) => {
                  if (response.data.result == 1) {
                      let city = this.cities
                      response.data.data.forEach(function( value ){
                        city.push(value)
                      })
                  } else {
                    this.message_validate_form = "La lista ciuidad no se cargó correctamente";
                  }

                });
          },
          /* funcion que busca los tipos de persona existene en la base de datos */
          getTypePerson : function (){

                axios.get('/getTypePersonList').then((response) => {
                  if (response.data.result == 1) {
                      let type = this.types_person
                      response.data.data.forEach(function( value ){
                        type.push(value)
                      })
                  } else {
                    this.message_validate_form = "La lista Tipo de persona no se cargó correctamente";
                  }

                });
          },
          /** Validar formulario */
          validateForm : function (){
            let form = this.get_form();
            if( form.email == "" || form.email == null || form.email.length == 0 ) {
                this.message_validate_form = "El campo de Correo Electrónico no es válido";
                return false;
            } else if (form.apellido == "" || form.apellido == null || form.apellido.length == 0) {
                this.message_validate_form = "El campo apellido no es válido";
                return false;
            } else if(form.nombre == "" || form.nombre == null || form.nombre.length == 0) {
                this.message_validate_form = "El campo nómbre no es válido";
                return false;
            } else if(form.documnet == "" || form.documnet == null || form.documnet.length == 0) {
                this.message_validate_form = "El campo documento de identidad no es válido";
                return false;
            } else if(form.type_document == "" || form.type_document == null || form.type_document.length == 0) {
                this.message_validate_form = "El campo Tipo de documento no es válido";
                return false;
            } else if (form.address == "" || form.address == null || form.address.length == 0) {
                this.message_validate_form = "El campo de dirección no es válido";
                return false;
            } else if (form.phone == "" || form.phone == null || form.phone.length == 0) {
                this.message_validate_form = "El campo de teléfono no es válido";
                return false;
            } else if (form.mobile == "" || form.mobile == null || form.mobile.length == 0) {
                this.message_validate_form = "El campo celular no es válido";
                return false;
            } else if(form.type_person == "" || form.type_person == null || form.type_person.length == 0) {
                this.message_validate_form = "El campo tipo de persona no es válido";
                return false;
            } else if(form.company == "" || form.company == null || form.company.length == 0) {
                this.message_validate_form = "El campo compañia no es válido";
                return false;
            } else {
                return true;
            }

          },

        }
    }
</script>
