<template>
    <div>

        <MainComponent :key="componentKey" v-bind:has-response="hasResponse" v-bind:response-status="responseStatus" v-bind:response-message="responseMessage" v-bind:error-details="errorDetails"></MainComponent> 

        <div class="modal fade" id="addEntry" tabindex="-1" role="dialog" aria-labelledby="addEntryLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="min-width:650px;background: #fff">
                    <form v-on:submit="addBalanceEntry">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Balance Entry</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>LABEL</label>
                                    <input type="text" required class="form-control" v-model="entryData.label" placeholder="e.g Groceries">
                                </div>

                                <div class="col-md-4">
                                    <label>DATE</label>
                                    <input type="date" class="form-control" v-model="entryData.date">
                                </div>

                                <div class="col-md-4">
                                    <label>AMOUNT</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend bg-white">
                                            <span class="input-group-text bg-white border-right-0" id="amount">$</span>
                                        </div>
                                        <input type="text" required class="form-control border-left-0" placeholder="0.00" v-model="entryData.amount" aria-describedby="amount">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-finance-cancel" data-dismiss="modal">CANCEL</button>
                            <button type="submit" class="btn btn-finance-save">SAVE ENTRY <i class="fa fa-spinner" v-if="loading"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="importCsv" tabindex="-1" role="dialog" aria-labelledby="importCsvLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="min-width:650px">
                    <form v-on:submit="importEntry">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import Balance Entries</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>.CSV FILE</label>
                                    <input type="file" class="form-control" v-on:change="displayFileName">
                                    <div class="d-flex browse-file">
                                        <div class="col-md-6">
                                            {{csvFileName}}
                                        </div>
                                        <div class="col-md-6 text-right text-finance-primary text-underline">
                                            <u>Select File</u>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-finance-cancel" data-dismiss="modal">CANCEL</button>
                            <button type="button" class="btn btn-finance-save">SAVE ENTRY <i class="fa fa-spinner" v-if="loading"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        

    </div>
</template>
<script>
import moment from 'moment';
import MainComponent from './MainComponent.vue'

export default {

    components: {
        MainComponent
    },
    
    data() {
        return {
            balanceEntryEndpoint: ApiBaseUrl+'/entries',
            entryData: {
                label: '',
                date: new Date().toISOString().substr(0, 10),
                amount: ''
            },
            csvFileName: null,

            componentKey: 0,
            loading: false,

            hasResponse: false,
            responseStatus: '',
            responseMessage: '',
            errorDetails: '',
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

    methods: {

        addBalanceEntry(e){
            e.preventDefault()
            let self = this
            self.loading = true
            axios.post(self.balanceEntryEndpoint,self.entryData)
            .then(function (response) {
                self.loading = false
                self.entryData.label = self.entryData.amount = ''
                self.responseStatus = self.hasResponse = true
                self.responseMessage = response.data.message                
                self.componentKey += 1 // reload MainComponent
                $('#addEntry').modal('hide') // close modal
                self.$emit('save')
            })
            .catch(function (error) {
                self.loading = false
                alert(error.response.data.message+'\n'+error.response.data.data[0])
            });
        },

        importEntry(){

        },
        
        displayFileName(){
            this.csvFileName = "test.csv"
        },
    }
}
</script>
