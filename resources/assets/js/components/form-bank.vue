<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Formulario Confirmación de pago</div>

                    <div class="card-body">

                    <div v-if="transaction!=null" class="alert alert-info">
                        <strong>Información de la transacción</strong> Estatus : {{transaction}}
                        <br>
                        Fecha de actualización : {{fecha_status}}
                    </div>
                    <div v-else-if="message_saved!=null" class="alert alert-warning">
                        <strong>Información de la transacción</strong>  {{message_saved}}
                    </div>

                      <form class="form" action="index.html" method="post">
                        <div class="form-group">
                            <label for="method">Medio de pago</label>
                            <select class="form-control" name="metodo" v-model="method_pay">
                                <option value="_PSE_">Débito a cuentas corrientes y ahorros (PSE)</option>
                                <option value="_TC_">Tarjeta de Crédito</option>
                            </select>
                        </div>

                          <div class="form-group">
                              <label for="">Tipo de cliente</label>
                              <select class="form-control" name="bankInterface" required="true" v-model="type_client" >
                                <option v-for="value in type_person"
                                        :value="value.id">{{ value.description }} </option>
                              </select>
                          </div>
                          <div class="form-group">
                            <label for="">Lista Bancos</label>
                            <select class="form-control" name="" v-model="banks_selected">
                              <option v-for="value in banks"
                                      :value="value.bankCode">{{ value.bankName }} </option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="">Monto a pagar $</label>
                            <input type="numeric" class="form-control" value="" v-model="mount">
                          </div>

                          <button v-show="url_pse==null" v-on:click="register"  type="button" name="button" class="btn btn-success btn-block" >Enviar</button>

                          <a v-show="url_pse!=null && url_pse!=1" v-bind:href="url_pse" v-on:click="showButtonStatus" role="button" class="btn btn-info btn-block text-white" target="_blank">
                              Pagar en PSE
                          </a>

                          <button v-show="id_transaction != null && url_pse == 1" type="button" name="button" class="btn btn-info btn-block text-white" v-on:click="buscarTransaction" >Verificar estado</button>
                      </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
      props : ["personas"],
        data :function (){
          return {
            banks          : [],
            type_person    : [],
            method_pay     : "",
            type_client    : "",
            banks_selected : "",
            mount          : "",
            url_pse        : null,
            message_saved  : null,
            id_transaction : null,
            transaction    : null,
            fecha_status   : "",
          }
        },
        mounted() {
            this.getBankList()
            this.getTypeClientList()
        },
        methods :{
          showButtonStatus : function (){
              this.url_pse = 1
          },
          /** Mandar el formulario  */
          register : function(){

             let data = this.get_form();
             axios.post('/initTransaction' ,  data ).then( (response) =>{

               if ( response.data.result == 1 ) {
                   this.url_pse = response.data.url
                   this.message_saved = response.data.message
                   this.id_transaction = response.data.transactionId
               } else {
                   this.message_saved = response.data.message
               }

             });

          },
          /** Obtener el formulario */
          get_form : function (){
              return {
                "tipo_cliente" : this.type_client,
                "bank_code"    : this.banks_selected,
                "method_pay"   : this.method_pay,
                "mount"        : this.mount,
                "comprador"    : this.personas.comprador,
                "pagador"      : this.personas.pagador
               };
          },
          /** getBankList */
          getBankList: function (){

            axios.get('/getBankList').then((response) => {
              if (response.data.result == 1) {
                  let bank = this.banks
                  response.data.data.forEach(function( value ){
                    bank.push(value)
                  })
              }

            })
          },
          /** getBankList */
          getTypeClientList: function (){

            axios.get('/getTypeClientList').then((response) => {
              if (response.data.result == 1) {
                  let role = this.type_person
                  response.data.data.forEach(function( value ){
                    role.push(value)
                  })
              }

            })
          },
          /** buscar informacion de la transactino */
          buscarTransaction : function (){

            let data = { transaction_id : this.id_transaction }

            axios.post('/getTransactionstatus' , data  ).then((response) => {

              if (response.data.result == 1) {

                  this.message_saved = "transaction"
                  this.transaction   = response.data.data.responseReasonText
                  this.fecha_status  = response.data.data.requestDate

              } else {
                  this.message_saved = response.data.message
              }

            })

          }
        }
    }
</script>
