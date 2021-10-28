<template>
<div class="table-responsive">
    <table class="table table-hover js-basic-example dataTable table-custom table-striped m-b-0 c_list">
        <thead class="thead-dark">
            <tr>
                <th>Payment Date</th>
                <th>Amount</th>
                <th>Bank</th>
                <th>Admin</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="repayment in repayments" :key="repayment.id">
                <td>{{repayment.payment_date}}</td>
                <td>{{repayment.amount | currency}}</td>
                <td v-for="bank in banks" :key="bank.id" v-show="bank.id == repayment.bank_id">{{bank.bank_name}}<br />{{bank.name}}<br />{{bank.number}}</td>
                <td>{{repayment.admin_id}}</td>
                <td v-show="(repayment.status == 1)">Pending with Admin</td>
                <td v-show="(repayment.status == 2)">Awaiting Fin. Admin</td>
                <td v-show="(repayment.status == 3)">On Site Confirmed</td>
                <td v-show="(repayment.status == 4)">Confirmed</td>
                <td v-show="(repayment.status == 5)">Rejected</td>
                <td v-show="repayment.status < 3"><div class="btn-group"><button class="btn btn-sm btn-primary" v-on:click="editRepayment(repayment)">Edit</button><button class="btn btn-sm btn-danger"  v-on:click="deleteRepayment(repayment.id)">Delete</button></div></td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script>
export default {
    data(){
        return {
            
        }
    },
    methods:{
        createContribution(){
            this.form.post('/api/coop/contributions').then(response=>{
                toast.fire({
                    icon: 'success',
                    title: 'Contribution was successfully added!',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Contribution was not added try again later!',
                })
            });
        },
        editContribution(contribution){
            Fire.$emit('editContribution', contribution);
        },
        getAllInitials(){
            toast.fire({
                icon: 'success',
                title: 'Customers loaded successfully',
            });
        },
    },
    mounted() {
            
    },
    props: {'banks':Array, 'repayments':Array, 'savings':Array,},
}
</script>