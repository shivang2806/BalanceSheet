import { createApp } from 'vue';

<template>
    <button 
    class="btn btn-primary mb-3 popup-close-button" 
    data-toggle="modal" 
    data-target="#exampleModal" 
    style="float:right;" 
    @click.prevent="closeModal">
    Add Transaction</button>
   <table class="table myTable" id="sample_1">
    <thead>
        <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Credit</th>
            <th>Debit</th>
            <th>Running Balance</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="(single, key) in list" :key='key'>
            <td>{{single.formatted_date}}</td>
            <td>{{single.description}}</td>
            <td>{{(single.type == 1) ? single.amount : ''}}</td>
            <td>{{(single.type == 2) ? single.amount : ''}}</td>
            <td>{{single.balance}}</td>
        </tr>   
    </tbody>
</table>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        
            <div class="form-group">
                <label for="example1">Transaction Type</label>
                <select class="form-control" id="example1" v-model="form_data.transaction_type" required aria-label="Default select example">
                    <option value="1">Credit</option>
                    <option value="2">Debit</option>
                </select>
            </div>
            <div class="form-group">
                <label for="example2">Amount</label>
                <input type="number" class="form-control" required id="example2" v-model="form_data.amount" name="amount">
            </div>
            <div class="form-group">
                <label for="example3">Description</label>
                <textarea class="form-control" id="example3" required name="description" v-model="form_data.description" rows="3"></textarea>
            </div>
            <button type="button" class="btn btn-secondary mr-3" data-dismiss="modal">Close</button>
            <button @click="submit" class="btn btn-primary">Save</button>
        
      </div>

    </div>
  </div>
</div>

</template>
<script>
  export default {
    data() {
      return {
        form_data : {
            transaction_type : '',
            amount : '',
            description : ''
        },
        list : []

      }
    },
    mounted() {
        this.getList()
    },
    methods: {
        async  submit() {
            const response = await axios.post(`/api/add-transaction/`, this.form_data)
            this.getList()
        },

        async getList() {
            this.list = await axios.get(`/api/transaction-list`)
            this.list= this.list.data.list;
        }
    }
  }
</script>