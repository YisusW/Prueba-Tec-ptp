<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Formulario Confirmación de pago</div>

                    <div class="card-body">

                      <form class="form" action="index.html" method="post">
                        <div class="form-group">
                            <label for="method">Medio de pago</label>
                            <select class="form-control" name="metodo" v-model="method_pay">
                                <option value="_PSE_">Débito a cuentas corrientes y ahorros (PSE)</option>
                                <option value="_TC_">Tarjeta de Crédito</option>
                            </select>
                        </div>

                          <div class="form-group">
                              <label for="">Tipo de persona</label>
                              <select class="form-control" name="bankInterface" required="true" v-model="type_person" >
                                  <option value="0">Natural</option>
                                  <option value="1">Juridica</option>
                              </select>
                          </div>
                          <div class="form-group">
                            <label for="">Lista Bancos</label>
                            <select class="form-control" name="" v-model="banks_select">
                              <option v-for="package in banks"
                                      :value="package.bankCode">{{ package.bankName }} </option>
                            </select>
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
            banks       : [],
            type_person : [],
            method_pay  : "",
            banks_select: ""
          }
        },
        mounted() {
            console.log('Component mounted.')
            this.getBankList()
        },
        methods :{
          /** Mandar el formulario  */
          register : function(){

             let data = this.get_form();
             axios.post('/send' ,  data ).then( response => function(){

               if ( response.result == 1 ) {

               }

             })

          },
          /* Obtener el formulario */
          get_form : function (){
              return { "tipo_persona" : this.type_person, "bank" : this.banks, "method_pay":method_pay };
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
