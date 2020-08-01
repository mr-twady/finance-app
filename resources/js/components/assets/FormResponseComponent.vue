<template>
    <div>
        <div v-if="hasResponse">
            <div v-if="responseStatus" class="alert alert-success" role="alert">
                <i class="fa fa-check-circle"></i> {{ responseMessage }}
            </div>
            <div v-else class="alert alert-danger" role="alert">
                <i class="fa fa-exclamation-triangle"></i> {{ responseMessage }}
                <br>
                <small>{{ errorDetails }}</small>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    
    props: [
        'hasResponse',
        'responseStatus',
        'responseMessage',
        'errorDetails'
    ]

}
</script>
