<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Formulario Registro del comprador</div>

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
                            <input type="text" name="name" class="form-control" required="true" v-model="nombre" >
                        </div>

                          <div class="form-group">
                              <label for="">Apellido</label>
                              <input type="text" name="last_name" class="form-control" required="true" v-model="apellido" >
                          </div>

                          <div class="form-group">
                            <label for="">Correo Electrónico</label>
                            <input type="email" name="email" value="" v-model="email" class="form-control">
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
            type_document : "",
            documnet      : "",
            email         : "",
            nombre        : "",
            apellido      : ""
          }
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
              return { "email" : this.email, "apellido" : this.apellido, "nombre":this.nombre , "documnet" : this.documnet , "type_document" : this.type_document };
          },
          getBankList: function (){

            axios.get('/getList').then((response) => {
              if (response.data.result == 1) {
                  let bank = this.banks
                  response.data.data.forEach(function( value ){
                    bank.push(value)
                  })
              }

            })

          }

        }
    }
</script>
