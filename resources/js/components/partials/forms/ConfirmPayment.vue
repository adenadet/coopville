<template>
<form @submit.prevent="confirmPayment">
<div class="row">
    <div class="col-md-4 col-sm-12">
        <div class="form-group">
            <label>User</label>
            <input type="text" :value="payment.user == null ? ' ' : payment.user.first_name+' '+payment.user.middle_name+' '+payment.user.last_name" class="form-control" disabled>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="form-group">
            <label>Amount:</label>
            <input type="text" :value="payment.amount" class="form-control" disabled>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="form-group">
            <label>Bank:</label>
            <input type="text" :value="payment.bank == null ? ' ' : payment.bank.name" class="form-control" disabled>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="form-group">
        <label>Trans ID</label>
        <input type="text" class="form-control" id="trans_id" name="trans_id" placeholder="Transaction ID on Statement" v-model="paymentForm.trans_id" required>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="form-group">
        <label>Description</label>
        <input type="text" class="form-control" id="description" name="description" placeholder="Description" v-model="paymentForm.description" required>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
    <input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
    </div>
</div>
</form>
</template>
<script>
export default {
    data(){
        return {
            paymentForm: new Form({
                payment_id: '',
                trans_id: '',
                description: '',
            }),
        }
    },
    methods:{
        confirmPayment(){
            this.$Progress.start();
            this.paymentForm.patch('/api/coop/payments/'+this.paymentForm.payment_id)
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({icon: 'success', title: 'The Payment has been confirmed', showConfirmButton: false, timer: 1500});
                })
            .catch(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                    });
                this.$Progress.fail();
            });  
        }
    },
    mounted(){
        Fire.$on('confirmPayment', payment =>{
                this.paymentForm.payment_id = payment.id;
            });
    },
    props:{
        payment: Object,
    },
}
</script>