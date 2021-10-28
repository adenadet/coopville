<template>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>Pending Closures</h2> 
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
                                    <td v-show="(closure.status == 3)"><span class="badge badge-success">Confirmed Awaiting</span></td>
                                    <td v-show="(closure.status == 1)"><span class="badge badge-success">Paid</span></td>
                                    <td v-show="(closure.status == 2)"><span class="badge badge-danger">Cancelled</span></td>
                                    <td>
                                        <div class="btn-group">
                                            <!--<button class="btn btn-sm btn-success" @click="seeClosure(closure)">See</button>-->
                                            <button class="btn btn-sm btn-primary" @click="confirmClosure(closure.id)">Confirm</button>
                                            <button class="btn btn-sm btn-danger" @click="rejectClosure(closure.id)">Reject</button>
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
                closure:{},
                closures:[],
            }
        },
        methods:{
            confirmClosure(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This Closure would be confirmed, the user would be deactivated and an SMS sent to notify the Cooperator",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Confirm!'
                    })
                    .then((result) => {
                    if(result.value){
                        this.form.delete('/api/coop/closures/'+id)
                        .then(response=>{
                            toast.fire({
                            icon: response.data.status,
                            title: response.data.message,
                            });
                            this.closures = response.data.closures;
                        })
                    .catch(()=>{
                        this.$Progress.fail();
                        toast.fire({
                            icon: 'error',
                            title: 'Closure was not processed, try again later!',
                            })
                        });
                    }
                });
            },
            getAllInitials(){
                axios.get('/api/coop/closures/pending').then(response =>{
                    this.banks = response.data.banks;
                    this.closures = response.data.closures;
                    //Fire.$emit('loadclosures', this.closures)
                    this.$Progress.finish();
                    toast.fire({icon: 'success',title: 'Closures loaded successfully',});
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({icon: 'error', title: 'Closures not loaded successfully',})
                });
            },
            seeClosure(closure){
                this.closure = closure;
                this.account = closure.savings;
                $('#SavingsModal').modal('show');
            },
        },
        mounted() {
            this.getAllInitials();
        }
    }
</script>