<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Formulario enviar data</div>

                    <div class="card-body">

                      <form class="form" action="index.html" method="post">
                          <div class="form-group">
                            <label for=""></label>
                            <input type="text" name="" value="" class="form-control">
                          </div>
                          <div class="form-group">
                            <label for="">Lista Bancos</label>
                            <select class="form-control" name="" v-model="banks">
                              <option v-for="package in banks"
                                      :value="package.bankCode">{{ package.bankName }} </option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for=""></label>
                            <input type="text" name="" value="" class="form-control">
                          </div>

                          <button v-on:click="register"  type="button" name="button" class="btn btn-success" >Enviar</button>
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
            banks : {}
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

               console.log( response );
               if ( response.result == 1 ) {

               }

             })

          },
          /* Obtener el formulario */
          get_form : function (){
            return { };
          },
          getBankList: function (){

            axios.get('/getList').then((response) => {
              if (response.data.result == 1) {
                  
                  this.banks = response.data.data
              }

            })

          }

        }
    }
</script>
