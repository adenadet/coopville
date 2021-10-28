<template>
<div class="col-lg-12">
    <div class="card">
        <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="largeModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body"> 
                        <FormConfirmPayment :payment="Payment"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="header">
            <h2>Payments</h2>
        </div>                        
        <div class="body">
            <div class="table-responsive">
                <table class="table table-hover js-basic-example dataTable table-custom">
                    <thead class="thead-dark">
                        <tr>
                            <th>User</th>
                            <th>For</th>
                            <th>Date</th>
                            <th>Bank</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="payment in payments.data" :key="payment.id">
                            <td>
                                <h6 class="mb-0">{{typeof payment.user != 'undefined' && payment.user !== null ? payment.user.first_name+' '+payment.user.middle_name+' '+payment.user.last_name : 'Loading...'}}</h6>
                                <span>{{payment.user !== null ? payment.user.unique_id: 'Inactive member'}}</span>
                            </td>
                            <td v-if="payment.payment_type == 'Contributions payment'">
                                {{((payment.contribution !== null) && (typeof payment.contribution !== 'undefined') && (typeof payment.contribution.savings !== 'undefined') ? payment.contribution.savings.name : payment.ref_id)}}    
                            </td> 
                            <td v-else-if="payment.payment_type == 'Contribution payment'">
                                {{((payment.contribution !== null) && (typeof payment.contribution !== 'undefined') && (typeof payment.contribution.savings !== 'undefined') ? payment.contribution.savings.name : payment.ref_id)}}
                            </td> 
                            <td v-else-if="payment.payment_type == 'Loan repayment'">
                                {{((payment.repayment !== null) && (typeof payment.repayment !== 'undefined') && (typeof payment.repayment.loan !== 'undefined') && payment.repayment.loan  !== 'null' ? payment.repayment.loan.name : payment.ref_id)}}
                            </td>
                            <td v-else-if="payment.payment_type == 'Repayment'">
                                {{((payment.repayment !== null) && (typeof payment.repayment !== 'undefined') && (typeof payment.repayment.loan !== 'undefined') ? payment.repayment.loan.name : payment.ref_id)}}
                            </td>
                            <td v-else>
                                Unknown Payment
                            </td>
                            <td>{{payment.date | ExcelDate}}</td>
                            <td>{{((typeof payment.bank !== 'undefined') && (payment.bank !== null)) ? payment.bank.bank_name+' '+payment.bank.number: payment.bank_id}}
                            </td>
                            <td>{{payment.amount | currency}}</td>
                            <td v-show="payment.status == 1">Awaiting Admin Payment</td>
                            <td v-show="payment.status == 2">Awaiting Confirmation</td>
                            <td v-show="payment.status == 3">Onsite Confirmed</td>
                            <td v-show="payment.status == 4">Admin Confirmed</td>
                            <td v-show="payment.status == 5">Rejected</td>
                            <td v-if="payment.status == 2">
                                <button class="btn btn-sm btn-primary" v-on:click="confirmPayment(payment)"><i class="fa fa-check"></i></button>
                                <button class="btn btn-sm btn-danger" v-on:click="deletePayment(payment.id)"><i class="fa fa-trash"></i></button>
                            </td>
                            <td v-else>&nbsp;</td>
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
            form: new Form({}),
            payments: {},
            states: [],
            outside: false,
            editMode: false,
            route: '',
            user: {},
            active_id : '',
            Payment:{},
        }
    },
    methods:{
        confirmPayment(payment){
            this.$Progress.start();
            this.Payment = payment;
            Fire.$emit('confirmPayment', payment);
            $('#paymentModal').modal('show');
        },
        deletePayment(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                })
            .then((result) => {
                if(result.value){
                    this.form.delete('/api/coop/payments/'+id)
                    .then(response=>{
                        Swal.fire('Deleted!', 'Payment has been deleted.', 'success');
                        this.payments = response.data.payments;
                        this.$Progress.finish();   
                    })
                    .catch(()=>{
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });  
        },
        getAllInitials(){
            this.$Progress.start();
            this.route = ((this.$route.params.id == null) || (this.$route.params.id == ''))
            ? '/api/coop/payments'
            : '/api/coop/payments/' + this.$route.params.id;

            axios.get(this.route).then(response =>{
                this.payments = response.data.payments;
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Members not loaded successfully',
                })
            });
        },
    },
    mounted(){
        this.getAllInitials();
        Fire.$on('Reload', response =>{
            this.payments = response.data.payments;
            $('#paymentModal').modal('hide');
        });
    },
}
</script>