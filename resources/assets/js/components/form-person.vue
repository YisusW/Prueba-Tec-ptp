<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header text-center">Registro del comprador</div>

                    <div class="card-body">

                      <form class="form" action="index.html" method="post">
                        <div class="form-group">
                            <label for="method">Tipo de Documento</label>
                            <select class="form-control" name="type_documnet" v-model="type_document">
                              <option value="ce">Cédula</option>
                              <option value="cf">Céduala de extranjería</option>
                              <option value="pa">Pasaporte</option>
                              <option value="pe">Permiso Especial de Permanencia</option>
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
            lastname      : ""
          }
        },
        mounted(){
          this.getDepartaments();
        },
        methods :{
          /** Mandar el formulario  */
          register : function(){

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
              "city"          : this.city
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
