<template>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>All Closures</h2> 
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table m-b-0">
                            <thead>
                                <tr>
                                    <th>Request Date</th>
                                    <th>Cooperator</th>
                                    <th>Payment Details</th>
                                    <th>Amount</th>
                                    <th>Closure Date</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="closure in closures.data" :key="closure.id" :value="closure.id">
                                    <td><span>{{closure.request_date | ExcelDate}}</span></td>
                                    <td><span class="text-info">{{typeof closure.user != undefined && closure.user != null ? closure.user.first_name+' '+closure.user.middle_name+' '+closure.user.last_name: ''}}</span></td>
                                    <td>{{closure.bank_paid != null && typeof closure.bank_paid != "undefined" ? closure.bank_paid.bank_name : "No Bank Chosen"}}<br />{{closure.acct_name}} <br />{{closure.acct_number}}</td>
                                    <td>{{closure.amount | currency}}</td>
                                    <td>{{closure.admin_date ? closure.admin_date  : '' | ExcelDate}}</td>
                                    <td v-show="(closure.status == 0)"><span class="badge badge-warning">Unpaid</span></td>
                                    <td v-show="(closure.status == 1)"><span class="badge badge-success">Paid</span></td>
                                    <td v-show="(closure.status == 2)"><span class="badge badge-danger">Cancelled</span></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
            closures: {},
            form: new Form({
                saving_id:'',
                bank_id: '',
                payment_date:'',
                amount:'',
                description:'',                    
            }),
            savings:{},
        }
    },
    methods:{
        getAllInitials(){
            axios.get('/api/coop/closures').then(response =>{
                this.closures = response.data.closures;
                this.savings = response.data.savings;
                //Fire.$emit('loadWithdrawals', this.withdrawals)
                this.$Progress.finish();
                toast.fire({icon: 'success',title: 'Closure loaded successfully',});
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Closure not loaded successfully',
                })
            });
        },
    },
    mounted() {
        this.getAllInitials();
    }
}
</script>
