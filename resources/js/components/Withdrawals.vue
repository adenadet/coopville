<template>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>All Withdrawals</h2> 
                    <ul class="header-dropdown">
                        <li><router-link to="/member_area/withdrawals/create" class="btn btn-info">Add New</router-link></li>
                    </ul>
                </div>
                <div class="body">
                    <DetailUserWithdrawals :withdrawals="withdrawals" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                accounts:{},
                all_banks:{},
                form: new Form({
                    saving_id:'',
                    bank_id: '',
                    payment_date:'',
                    amount:'',
                    description:'',                    
                }),
                savings:{},
                withdrawals:[],
            }
        },
        methods:{
            getAllInitials(){
                axios.get('/api/coop/withdrawals/initials').then(response =>{
                    this.withdrawals = response.data.withdrawals;
                    this.savings = response.data.savings;
                    Fire.$emit('loadWithdrawals', this.withdrawals)
                    this.$Progress.finish();
                    toast.fire({icon: 'success',title: 'Withdrawal loaded successfully',});
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Withdrawal not loaded successfully',
                    })
                });
            },
        },
        mounted() {
            this.getAllInitials();
        }
    }
</script>
