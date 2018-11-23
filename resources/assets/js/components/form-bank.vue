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
      props : ["personas"],
        data :function (){
          return {
            banks         : [],
            type_person   : [],
            method_pay    : "",
            type_client   : "",
            banks_selected: ""
          }
        },
        mounted() {
            this.getBankList()
            this.getTypeClientList()
        },
        methods :{

          /** Mandar el formulario  */
          register : function(){

             let data = this.get_form();
             axios.post('/initTransaction' ,  data ).then( response => function(){

               if ( response.result == 1 ) {

               }

             });

          },
          /** Obtener el formulario */
          get_form : function (){
              return {
                "tipo_cliente" : this.type_client,
                "bank_code"    : this.banks_selected,
                "method_pay"   : this.method_pay,
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
          }
        }
    }
</script>
