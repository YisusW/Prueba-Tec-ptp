<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header text-center">Registro del comprador</div>

                    <div class="card-body">
                      <div v-if="message_validate_form != null " class="alert alert-warning">
                          <strong>Error en formulario !</strong> {{message_validate_form}}
                      </div>

                      <form class="form" action="index.html" method="post">
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
                        <div class="form-group">
                            <label for="method">Documento</label>
                            <input type="text" name="name" class="form-control" required="true" v-model="documnet" >
                        </div>

                        <div class="form-group">
                            <label for="method">Nómbre</label>
                            <input type="text" name="name" class="form-control" required="true" v-model="firstname" >
                        </div>

                          <div class="form-group">
                              <label for="">Apellido</label>
                              <input type="text" name="last_name" class="form-control" required="true" v-model="lastname" >
                          </div>

                          <div class="form-group">
                            <label for="">Correo Electrónico</label>
                            <input type="email" name="email" value="" v-model="email" class="form-control">
                          </div>


                          <div class="form-group">
                              <label for="method">Departamento</label>
                              <select class="form-control" name="departament" v-model="departament" v-on:change="getCities" >
                               <option v-for="value in departaments"
                                       :value="value.id">{{ value.description }} </option>
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="method">Ciudad</label>
                              <select class="form-control" name="city" v-model="city">
                                <option v-for="value in cities"
                                        :value="value.id">{{ value.description }} </option>
                              </select>
                          </div>

                          <div class="form-group">
                              <label for="">Dirección</label>
                              <textarea name="name" class="form-control" v-model="address"></textarea>
                          </div>

                          <div class="form-group">
                              <label for="">Teéfono</label>
                              <textarea name="name" class="form-control" v-model="phone"></textarea>
                          </div>

                          <div class="form-group">
                              <label for="">Celular</label>
                              <textarea name="name" class="form-control" v-model="mobile"></textarea>
                          </div>


                          <button v-on:click="register"  type="button" name="button" class="btn btn-success btn-block" >Enviar</button>
                      </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data :function (){
          return {
            departaments  : [],
            cities        : [],
            departament   : "",
            city          : "",
            address       : "",
            type_document : "",
            documnet      : "",
            email         : "",
            firstname     : "",
            lastname      : "",
            phone         : "",
            mobile        : "",
            message_validate_form : ""
          }
        },
        mounted(){
          this.getDepartaments();
        },
        methods :{
          /** Validar formulario */
          validateForm : function (){
            let form = this.get_form();
            if( form.email == "" || form.email == null || empty(form.email) ) {
                this.message_validate_form = "El campo de Correo Electrónico no es válido";
                return false;
            } else if (form.apellido == "" || form.apellido == null || empty(form.apellido)) {
                this.message_validate_form = "El campo apellido no es válido";
                return false;
            } else if(form.nombre == "" || form.nombre == null || empty(form.nombre)) {
                this.message_validate_form = "El campo nómbre no es válido";
                return false;
            } else if(form.documnet == "" || form.documnet == null || empty(form.documnet)) {
                this.message_validate_form = "El campo documento de identidad no es válido";
                return false;
            } else if(form.type_document == "" || form.type_document == null || empty(form.type_document)) {
                this.message_validate_form = "El campo Tipo de documento no es válido";
                return false;
            } else if (form.address == "" || form.address == null || empty(form.address)) {
                this.message_validate_form = "El campo de dirección no es válido";
                return false;
            } else if (form.phone == "" || form.phone == null || empty(form.phone)) {
                this.message_validate_form = "El campo de teléfono no es válido";
                return false;
            } else if (form.mobile == "" || form.mobile == null || empty(form.mobile)) {
                this.message_validate_form = "El campo celular no es válido";
                return false;
            } else if (form.departament == "" || form.departament == null || empty(form.departament)) {
                this.message_validate_form = "El campo departamento no es válido";
                return false;
            } else {
                return true;
            }

          },
          /** Mandar el formulario  */
          register : function(){
              let valid = this.validateForm();
              if( !valid ){
                  return valid;
              }

             let data = this.get_form();
             axios.post('/send-person' ,  data ).then( response => function(){

               if (response.result == 1) {
                   response.href = "/getList/"+data.id_pagador
               }

             })

          },
          /* Obtener el formulario */
          get_form : function (){
            return  {"email"         : this.email,
              "apellido"      : this.apellido,
              "nombre"        : this.nombre ,
              "documnet"      : this.documnet ,
              "type_document" : this.type_document,
              "address"       : this.address,
              "city"          : this.city,
              "phone"         : this.phone,
              "mobile"        : this.mobile
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
                }

              });

          },
          /* Lista de ciudades */
          getCities : function(){
              let state = this.departament;
              axios.get('/getCitiesByState/'+state+'/').then((response) => {
                if (response.data.result == 1) {
                    let city = this.cities
                    response.data.data.forEach(function( value ){
                      city.push(value)
                    })
                }

              });
          },

        }
    }
</script>
