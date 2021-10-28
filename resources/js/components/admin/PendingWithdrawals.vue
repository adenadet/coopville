<template>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="modal fade" id="SavingsModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="title" id="largeModalLabel">Account Details</h4>
                        </div>
                        <div class="modal-body"> 
                            <div class="card invoice1">                        
                                <div class="body">
                                    <div class="invoice-top clearfix">
                                        <div class="logo">
                                            <img src="" alt="user" class="rounded-circle img-fluid">
                                        </div>
                                        <div class="info">
                                            <h6>{{withdrawal != null && typeof withdrawal.user != "undefined" && withdrawal.user != null ? withdrawal.user.first_name+' '+withdrawal.user.middle_name+' '+withdrawal.user.last_name : ''}}</h6>
                                            <p> {{withdrawal != null && typeof withdrawal.user != "undefined" && withdrawal.user != null ? withdrawal.user.unique_id : ''}}<br>
                                            {{withdrawal != null && typeof withdrawal.user != "undefined" && withdrawal.user != null ? withdrawal.user.phone+' | '+withdrawal.user.alt_phone : ''}}
                                            </p>
                                        </div>
                                        <div class="title">
                                            <h4>Withdrawal #{{withdrawal.id}}</h4>
                                            <p>Request Date: {{withdrawal.request_date |ExcelDate}}</p>
                                        </div>
                                    </div>
                                    <DetailSavingsAccount :banks="banks" :account="account"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="header">
                    <h2>Pending Withdrawals</h2> 
                    <ul class="header-dropdown">
                        <li><router-link to="/member_area/withdrawals/create" class="btn btn-info">Add New</router-link></li>
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
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="withdrawal in withdrawals" :key="withdrawal.id" :value="withdrawal.id">
                                    <td><span>{{withdrawal.request_date | ExcelDate}}</span></td>
                                    <td><span>{{withdrawal.user.unique_id}} | {{withdrawal.user.first_name}} {{withdrawal.user.middle_name}} {{withdrawal.user.last_name}}</span></td>
                                    <td><span class="text-info"><router-link :to="'/member_area/savings#details'+withdrawal.savings.name">{{withdrawal.savings.name}}
                                    </router-link></span></td>
                                    <td>{{withdrawal.amount | currency}}</td>
                                    <td>{{withdrawal.payment_date ? (withdrawal.payment_date | ExcelDate) : ''}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-success" @click="seeWithdrawal(withdrawal)">See</button>
                                            <button class="btn btn-sm btn-primary" @click="confirmWithdrawal(withdrawal.id)">Confirm</button>
                                            <button class="btn btn-sm btn-danger" @click="rejectWithdrawal(withdrawal.id)">Reject</button>
                                        </div>
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
                account:{},
                accounts:{},
                all_banks:{},
                banks: [],
                form: new Form({
                    'id': '',                    
                }),
                savings:{},
                withdrawal:{},
                withdrawals:[],
            }
        },
        methods:{
            confirmWithdrawal(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This withdrawal would be confirmed and an SMS sent to notify the Cooperator",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Confirm!'
                    })
                    .then((result) => {
                    if(result.value){
                        this.form.put('/api/coop/withdrawals/'+id)
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
                            title: 'Loan was not processed, try again later!',
                            })
                        });
                    }
                });
            },
            getAllInitials(){
                axios.get('/api/coop/withdrawals/pending').then(response =>{
                    this.banks = response.data.banks;
                    this.withdrawals = response.data.withdrawals;
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
            seeWithdrawal(withdrawal){
                this.withdrawal = withdrawal;
                this.account = withdrawal.savings;
                $('#SavingsModal').modal('show');
            },
        },
        mounted() {
            this.getAllInitials();
        }
    }
</script>