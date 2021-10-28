<template>
<div class="col-lg-12">
    <div class="card">
        <div class="modal fade" id="loanModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="largeModalLabel">Loan Guarantors</h4>
                    </div>
                    <div class="modal-body"> 
 <table class="table table-hover js-basic-example dataTable table-custom">
    <thead class="thead-dark">       
        <tr><th>Guarantor</th><th>Status</th><th>Amount</th><th>Date</th><th>Status</th></tr>
    </thead>
    <tbody>
        <tr v-for="guarantor in guarantors" :key="guarantor.id">
            <td>{{guarantor.guarantor.unique_id}}</td>
            <td>{{guarantor.status}}</td>
            <td>&#x20a6; {{guarantor.amount | currency}}</td>
            <td>{{guarantor.status_date | ExcelDate}}</td>
            <td v-if="guarantor.status == 0">Not Yet Guaranteed</td>
            <td v-else-if="guarantor.status == 1">Guaranteed, not yet fixed</td>
            <td v-else-if="guarantor.status == 2">Guaranteed and Fixed</td>
            <td v-else-if="guarantor.status == 3">Completed</td>
            <td v-else-if="guarantor.status == 4">Rejected</td>
        </tr>
    </tbody>
</table>                        

                    </div>
                </div>
            </div>
        </div>
        <div class="header"><h2>Loans Awaiting Approval</h2></div>                        
        <div class="body">
            <div class="table-responsive">
                <table class="table table-hover js-basic-example dataTable table-custom">
                    <thead class="thead-dark">
                        <tr>
                            <th>Cooperator</th>
                            <th>Amount</th>
                            <th>Request Date</th>
                            <th>Bank </th>
                            <th>Account Name </th>
                            <th>Account Number </th>
                            <th>Guarantors</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr  v-for="loan in loans" :key="loan.id">
                            <td>{{loan.user_id != null && loan.user != null && typeof loan.user != 'undefined' ? loan.user.first_name+' '+loan.user.middle_name+' '+loan.user.last_name: 'User not found | Closed Member'}}</td>
                            <td>&#x20a6; {{loan.amount | currency}}</td>
                            <td>{{loan.requested_date | ExcelDate}}</td>
                            <td>{{loan.bank_id != null ? loan.payment_bank.name : 'None Chosen'}}</td>
                            <td>{{loan.acct_name != null ? loan.acct_name : 'None Chosen'}}</td>
                            <td>{{loan.acct_number != null ? loan.acct_number : 'None Chosen'}}</td>
                            <td>{{loan.loan_guarantors.length}}</td>
                            <td>
                                <button class="btn btn-sm btn-success" v-on:click="seeGuarantors(loan.loan_guarantors)" title="See Guarantor Details"><i class="fa fa-eye"></i></button>
                                <button class="btn btn-sm btn-primary" v-on:click="confirmLoan(loan.id)"><i class="fa fa-check"></i></button>
                                <button class="btn btn-sm btn-danger" v-on:click="rejectLoan(loan.id)"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            banks:[],
            branches:[],
            guarantors:[],
            loan_types:[],
            loans:[],
            loanForm: new Form({}),
        }
    },
    methods:{
        confirmLoan(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "This loan would be confirmed and the guarantor's guarantee amount fixed",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Confirm!'
                })
                .then((result) => {
                if(result.value){
                    this.loanForm.put('/api/coop/loans/'+id)
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
            axios.get('/api/coop/loans/pending')
            .then(response =>{
                this.banks = response.data.banks;
                this.branches = response.data.branches;
                this.loans = response.data.loans;
                this.loan_types = response.data.loan_types;
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Pending Loans loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'All Loans were not loaded successfully',
                })
            });
        },
        rejectLoan(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "This Loan would be rejected!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Reject!'
                })
                .then((result) => {
                if(result.value){
                    this.loanForm.delete('/api/coop/loans/'+id)
                    .then(response=>{
                        toast.fire({
                        icon: response.data.status,
                        title: response.data.message,
                        });
                        this.loans = response.data.loans;
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
        seeGuarantors(guarantors){
            this.guarantors = guarantors;
            $('#loanModal').modal('show');
        }
    },
    mounted() {
        this.getAllInitials();
    },
    props:{
      
    }
}
</script>
