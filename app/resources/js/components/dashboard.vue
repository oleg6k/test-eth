<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-12">
          <table class="table table-bordered small">
            <thead>
            <tr>
              <th>ADDRESS</th>
              <th>TXID</th>
              <th>AMOUNT</th>
              <th>CONFIRMATIONS</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="transaction in transactions">
              <td>{{transaction.wallet.address}}</td>
              <td>{{transaction.txid}}</td>
              <td>{{transaction.amount}}</td>
              <td>{{transaction.confirmations}}</td>
            </tr>
            </tbody>
          </table>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'
  export default {
    name: "dashboard",
    data(){
      return{
        transactions:[]
      }
    },
    created() {
      axios.get('/transactions').then((response)=>{
        this.transactions = response.data.transactions
      })
    }
  }
</script>

<style scoped>

</style>