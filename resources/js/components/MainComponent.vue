<template>
    <div>  
        <div v-show="loading" class="processing-overlay-loading">
            <div class="processing-overlay__inner">
                <div class="processing-overlay__content"><span class="processing-spinner"></span></div>
            </div>
        </div>

        <HeaderComponent :key="componentKey"></HeaderComponent>

        <main v-if="hasBalanceEntries">
            <FormResponse v-bind:has-response="vhasResponse" v-bind:response-status="vresponseStatus" v-bind:response-message="vresponseMessage" v-bind:error-details="verrorDetails"></FormResponse>
            <div v-for="balEntry in balanceEntries">
                <div class="d-flex align-items-center p-3 my-3 row">
                    <div class="col-sm-12 col-md-6">
                        <h5 class="text-secondary">{{balEntry.short_friendly_date | capitalize}}</h5>
                    </div>
                    <div class="col-sm-12 col-md-6 text-right">
                        <h4 v-bind:class="(balEntry.total.toString().charAt(0)=='-')? 'text-dark' : 'balance-green'">{{balEntry.total | formatCurrency}}</h4>
                    </div>
                </div>
                <div v-for="entryDetail, index in balEntry.entries">
                    <div class="d-flex label-card align-items-center p-3 my-3 text-white-50 rounded bg-white shadow-sm row">
                        <div class="col-sm-12 col-md-6">
                            <div class="lh-100">
                                <h6 class="mb-0 text-dark lh-100">{{entryDetail.label}}</h6>
                                <small class="text-secondary">{{entryDetail.created_at | longFormatDate}}</small>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 text-right">
                            <a class="m-2 text-primary" data-toggle="collapse" v-bind:href="'#collapseEditForm'+entryDetail.id" role="button" aria-expanded="false" v-bind:aria-controls="'collapseEditForm'+entryDetail.id" >EDIT</a>
                            <a class="m-2 text-primary" v-on:click="deleteEntry(entryDetail.id)">DELETE </a>
                            <span v-bind:class="(entryDetail.amount.toString().charAt(0)=='-')? 'text-dark' : 'balance-green'">{{entryDetail.amount | formatCurrency }}</span>
                        </div>
                        <div class="col-md-12 p-0 card border-0 collapse multi-collapse" v-bind:id="'collapseEditForm'+entryDetail.id">
                            <br>
                            <div class="card-body border-top">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>LABEL</label>
                                        <input type="text" v-model="entryDetail.label" class="form-control" placeholder="e.g Groceries">
                                    </div>

                                    <div class="col-md-4">
                                        <label>DATE</label>
                                        <input type="date" v-model="entryDetail.created_at.substr(0, 10)" class="form-control">
                                    </div>

                                    <div class="col-md-4">
                                        <label>AMOUNT</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend bg-white">
                                                <span class="input-group-text bg-white border-right-0" id="amount">$</span>
                                            </div>
                                            <input type="text" v-model="entryDetail.amount" class="form-control border-left-0" placeholder="0.00" aria-describedby="amount">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-top p-3 text-right">
                                <button type="button" class="btn btn-finance-cancel" data-toggle="collapse" v-bind:href="'#collapseEditForm'+entryDetail.id">CANCEL</button>
                                <button type="button" v-on:click="updateEntry(entryDetail.id,{label:entryDetail.label,amount:entryDetail.amount,date:entryDetail.created_at})" class="btn btn-finance-save">UPDATE ENTRY</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <main v-else>
            {{responseMessage}}
        </main>

    </div>
</template>
<script>
import moment from 'moment';
import FormResponse from './assets/FormResponseComponent.vue'
import HeaderComponent from './HeaderComponent.vue'

export default {

    props: [
        'hasResponse',
        'responseStatus',
        'responseMessage',
        'errorDetails'
    ],

    components: {
        FormResponse,
        HeaderComponent
    },
    
    data() {
        return {
            balanceEntryEndpoint: ApiBaseUrl+'/entries',
            balanceEntries: [],

            componentKey: 0,
            loading: false,
            hasBalanceEntries: true,
            
            vhasResponse: this.hasResponse,
            vresponseStatus: this.responseStatus,
            vresponseMessage: this.responseMessage,
            verrorDetails: this.errorDetails,
        }
    },

    filters:{
        capitalize: function (value) {
            if (value)
            return value.toUpperCase()

            return ''
        },

        longFormatDate: function(value) {
            if (value) 
            return moment(String(value)).format("D MMMM, Y [at] hh:mm A")
            
            return ''
        }
    },

    created(){
        this.fetchEntries()
    },

    methods: {

        fetchEntries(){
            let self = this
            self.loading = true
            axios.get(self.balanceEntryEndpoint)
            .then(function (response) {
                self.hasBalanceEntries = true
                self.loading = false
                self.balanceEntries = response.data.data.data
            })
            .catch(function (error) {
                self.hasBalanceEntries = false
                self.loading = false
                self.responseMessage = error.response.data.message
            });
        },

        updateEntry(id, entryData){
            let self = this
            axios.patch(self.balanceEntryEndpoint+'/'+id,entryData)
            .then(function (response) {
                self.loading = false
                self.vresponseStatus = self.vhasResponse = true
                self.vresponseMessage = response.data.message   
                self.fetchEntries() // refresh data
                self.componentKey += 1 // reload HeaderComponent (showing balance)
                $('#collapseEditForm'+id).collapse('hide')
            })
            .catch(function (error) {
                self.loading = false
                alert(error.response.data.message+'\n')
            });
        },

        deleteEntry(id){
            if (confirm("Do you really want to delete it?")) {
                let self = this;
                self.loading = true
                axios.delete(self.balanceEntryEndpoint+'/'+id)
                .then(function (response) {
                    self.loading = false
                    self.vresponseStatus = self.vhasResponse = true
                    self.vresponseMessage = response.data.message   
                    self.fetchEntries() // refresh data
                    self.componentKey += 1 // reload HeaderComponent (showing balance)
                })
                .catch(function (error) {
                    self.loading = false
                    alert(error.response.data.message+'\n'+error.response.data.data[0])
                });
            }
        }

    }
}
</script>
<style>
.processing-overlay-loading {
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  position: fixed;
  z-index: 9999999;
  background: #fff;
  opacity: 0.7;
}

.processing-overlay__inner {
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  position: absolute;
}

.processing-overlay__content {
  left: 50%;
  position: absolute;
  top: 50%;
  transform: translate(-50%, -50%);
}

.processing-spinner {
  width: 75px;
  height: 75px;
  display: inline-block;
  border-width: 2px;
  border-color: rgba(255, 255, 255, 0.05);
  border-top-color: #0552f5;
  animation: spin 1s infinite linear;
  border-radius: 100%;
  border-style: solid;
}

@-webkit-keyframes spin {
  100% {
    transform: rotate(360deg);
  }
}

@keyframes spin {
  100% {
    transform: rotate(360deg);
  }
}
</style>
