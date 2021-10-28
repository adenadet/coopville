<template>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="modal fade" id="WithdrawalModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="title" id="largeModalLabel">Apply For Withdrawal</h4>
                            </div>
                            <div class="modal-body"> 
                                <FormAdminWithdrawal :all_banks="all_banks" :branches="branches"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header">
                    <h2>All Withdrawals</h2> 
                    <ul class="header-dropdown">
                        <li><button class="btn btn-sm btn-primary" v-on:click="addWithdrawal()">Add New</button></li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table m-b-0">
                            <thead>
                                <tr>
                                    <th>Request Date</th>
                                    <th>Cooperator</th>
                                    <th>Savings Account</th>
                                    <th>Amount</th>
                                    <th>Payment Date</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="withdrawal in withdrawals" :key="withdrawal.id" :value="withdrawal.id">
                                    <td><span>{{withdrawal.request_date | ExcelDate}}</span></td>
                                    <td><span>{{withdrawal.user != null ? withdrawal.user.unique_id+' | '+withdrawal.user.first_name+' '+withdrawal.user.last_name : 'Unregistered / Closed Member'}}</span></td>
                                    <td><span class="text-info"><router-link :to="'/member_area/savings#details'+withdrawal.savings.name">{{withdrawal.savings.name}}
                                    </router-link></span></td>
                                    <td>{{withdrawal.amount | currency}}</td>
                                    <td>{{withdrawal.payment_date ? (withdrawal.payment_date | ExcelDate) : ''}}</td>
                                    <td v-show="(withdrawal.status == 0)"><span class="badge badge-warning">Unpaid</span></td>
                                    <td v-show="(withdrawal.status == 3)"><span class="badge badge-success">Confirmed Awaitng</span></td>
                                    <td v-show="(withdrawal.status == 1)"><span class="badge badge-success">Paid</span></td>
                                    <td v-show="(withdrawal.status == 2)"><span class="badge badge-danger">Cancelled</span></td>
                                    <td v-show="(withdrawal.status == 6)"><span class="badge badge-danger">Rejected</span></td>
                                    <td v-show="withdrawal.status == 1 || withdrawal.status == 2">&nbsp;</td>
                                    <td v-show="withdrawal.status == 5 || withdrawal.status == 6">&nbsp;</td>
                                    <td v-show="withdrawal.status == 0 || withdrawal.status == 3">
                                        <button class="btn btn-sm btn-primary" v-on:click="confirmWithdrawal(withdrawal.id)"><i class="fa fa-check"></i></button>
                                        <button class="btn btn-sm btn-danger" v-on:click="rejectWithdrawal(withdrawal.id)"><i class="fa fa-trash"></i></button>
                                    </td>
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
                all_banks:[],
                branches:[],
                confirmForm: new Form({}),
                form: new Form({
                    saving_id:'',
                    bank_id: '',
                    payment_date:'',
                    amount:'',
                    description:'',                    
                }),
                savings:{},
                withdrawals:[],
                withdrawal:{},
            }
        },
        methods:{
            addWithdrawal(){
                $('#WithdrawalModal').modal('show');
            },
            confirmWithdrawal(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This withdrawal would be confirmed and the Cooperator's account debited",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, confirm withdrawal!'
                    })
                    .then((result) => {
                    if(result.value){
                        this.confirmForm.patch('/api/coop/withdrawals/'+id)
                        .then(response=>{
                            toast.fire({
                            icon: response.data.status,
                            title: response.data.message,
                            });
                            this.withdrawals = response.data.withdrawals;
                        })
                    .catch(()=>{
                        this.$Progress.fail();
                        toast.fire({
                            icon: 'error',
                            title: 'Withdrawal was not processed, try again later!',
                            })
                        });
                    }
                });  
            },
            rejectWithdrawal(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This withdrawal would be rejected!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, reject withdrawal!'
                    })
                    .then((result) => {
                    if(result.value){
                        this.confirmForm.delete('/api/coop/withdrawals/'+id)
                        .then(response=>{
                            toast.fire({
                            icon: response.data.status,
                            title: response.data.message,
                            });
                            this.withdrawals = response.data.withdrawals;
                        })
                    .catch(()=>{
                        this.$Progress.fail();
                        toast.fire({
                            icon: 'error',
                            title: 'Withdrawal was not processed, try again later!',
                            })
                        });
                    }
                });
            },
            getAllInitials(){
                axios.get('/api/coop/withdrawals').then(response =>{
                    this.withdrawals = response.data.withdrawals;
                    this.savings = response.data.savings;
                    this.branches = response.data.branches;
                    this.all_banks = response.data.all_banks;
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
