<template>
<div class="row clearfix">
    <div class="modal fade" id="addNewModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
            <FormRepayment :repayment="repayment"></FormRepayment>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="header">
                <h2>Your Loan Accounts</h2>
            </div>
            <div class="body">
                <ul class="nav nav-tabs-new2">                    
                    <li class="nav-item" v-for="loan in loans" :key="loan.id" :value="loan.id"><a class="nav-link" data-toggle="tab" :href="'#details'+loan.name">{{loan.name}}</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" v-for="loan in loans" :key="loan.id" :value="loan.id" :id="'details'+loan.name">
                        <DetailLoansAccount :account="loan" :banks="banks"></DetailLoansAccount>
                    </div>
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
            banks:[],
            loans:{},
            repayment:{},
        }
    },
    methods:{
        editRepayment(repayment){
            $('#addNewModal').modal('show');
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/coop/loans/initials').then(response =>{
                this.accounts = response.data.accounts;
                this.banks = response.data.banks;
                this.loans = response.data.loans;
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Loans not loaded successfully',
                })
            });
        },
        refresh(){
            $('#addNewModal').modal('hide');
            this.getAllInitials();
        },
        updateItems(invoice_items){
            console.log(invoice_items);
            this.form.invoice_items = invoice_items.items;
            this.form.delivery = invoice_items.delivery;
            this.form.vat = invoice_items.vat;
            this.form.sub_total = invoice_items.sub_total;
            this.form.totals = parseFloat(invoice_items.sub_total) + parseFloat(invoice_items.delivery) + parseFloat(invoice_items.vat);
        },
    },
    mounted() {
        this.getAllInitials();   
        Fire.$on('editRepayment', repayment =>{
                this.editRepayment(repayment);
            });  
        Fire.$on('Refresh', () =>{
                this.refresh();   
            }); 
        },
}
</script>
