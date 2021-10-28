<template>
<div>
    <FormAdminSavingsAccount :branches="branches" :saving_types="saving_types"/>
</div>
</template>

<script>
    export default {
        data(){
            return {
                branches:[],
                saving_types:[],

            }
        },
        methods:{
            getAllInitials(){
                this.route = ((this.$route.params.id == null) || (this.$route.params.id == ''))? 
                '/api/coop/savings':
                '/api/coop/savings/branch/' + this.$route.params.id;
            
                axios.get(this.route)
                .then(response =>{
                    this.branches = response.data.branches;
                    Fire.$emit('userFill', this.branches)
                    this.saving_types = response.data.saving_types;
                    this.$Progress.finish();
                    toast.fire({
                        icon: 'success',
                        title: 'Savings Account Form loaded successfully',
                    });
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'All Savings Accounts were not loaded successfully',
                    })
                });
            },
        },
        mounted() {
            this.getAllInitials();
        }
    }
</script>
