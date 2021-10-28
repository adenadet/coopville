<template>
<div>
    <FormAdminLoansAccount :all_banks="all_banks" :branches="branches" :loan_types="loan_types" :guarantors="guarantors"/>
</div>
</template>

<script>
    export default {
        data(){
            return {
                all_banks: [],
                branches:[],
                guarantors:[],
                loan_types:[],
                users:[],
            }
        },
        methods:{
            getAllInitials(){
                this.route = ((this.$route.params.id == null) || (this.$route.params.id == ''))? 
                '/api/coop/loans':
                '/api/coop/loans/branch/' + this.$route.params.id;
            
                axios.get(this.route)
                .then(response =>{
                    this.all_banks = response.data.all_banks;
                    this.branches = response.data.branches;
                    this.loan_types = response.data.loan_types;
                    this.users = response.data.users;
                    let guarantors = [];
                    for (let i = 0; i < this.users.length; i++) {
                        guarantors.push({
                            'id' : this.users[i].id, 
                            'name' : this.users[i].unique_id+' | '+this.users[i].first_name+' '+this.users[i].last_name,
                            'value' : this.users[i].unique_id,
                            });
                        }
                    this.guarantors = guarantors;
                    
                    Fire.$emit('userFill', this.branches)
                    this.$Progress.finish();
                    toast.fire({
                        icon: 'success',
                        title: 'Loans Account Form loaded successfully',
                    });
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'All Loans Accounts were not loaded successfully',
                    })
                });
            },
        },
        mounted() {
            this.getAllInitials();
        }
    }
</script>
