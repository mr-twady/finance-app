<template>
    <div>
        <nav class="navbar navbar-default bg-white">
            <a class="navbar-brand" v-bind:href="appBaseUrl"><img src="images/logo.svg"> Your<span class="text-finance-primary">Balance</span></a>
            <div class="form-inline">
                <span class="mr-sm-3"><img src="images/alarm.svg"></span>
                <img src="images/avatar.png" height="48" class="mr-sm-3">
                <span class="my-2 my-sm-0 text-secondary">{{userDetails.name}}</span>
            </div>
        </nav>

        <div class="balance-action-area">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-3 col-lg-3 pt-3">
                        <h3 class="text-white">Your Balance</h3>
                    </div>
                    <div class="col-sm-6 col-md-5 col-lg-6 pt-3 action-buttons">
                        <a class="btn btn-finance-primary text-white" data-toggle="modal" data-target="#addEntry"><i class="fa fa-plus" aria-hidden="true"></i> <span>ADD ENTRY</span></a>
                        <a class="btn btn-finance-primary text-white" data-toggle="modal" data-target="#importCsv"><i class="fa fa-upload" aria-hidden="true"></i> <span>IMPORT CSV</span></a>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 text-right">
                        <span class="balance-title">TOTAL BALANCE</span> <br>
                        <h1 class="balance-green">{{userDetails.balance | formatBalance}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {

    data() {
        return {
            appBaseUrl: AppBaseUrl,
            userEndpoint: ApiBaseUrl+'/user',
            userDetails: '',
        }
    },

    filters:{
        formatBalance: function(value){
            if(!value) return ''

            value = value.toString()            
            if(value.charAt(0)=='-') 
            return '-$' + value.substr(1, value.length)

            return '$' + value
        }
    },

    mounted(){
        let self = this
        axios.get(self.userEndpoint)
        .then(function (response) {
            self.userDetails = response.data.data
        })
    }

}
</script>
