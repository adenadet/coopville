<template>
<div class="table-responsive">
    <table class="table table-hover js-basic-example dataTable table-custom table-striped m-b-0 c_list">
        <thead class="thead-dark">
            <tr>
                <th>Payment Date</th>
                <th>Savings</th>
                <th>Amount</th>
                <th>Bank</th>
                <th>Admin</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="contribution in contributions" :key="contribution.id">
                <td>{{contribution.savings.name}}</td>
                <td>{{contribution.payment_date}}</td>
                <td>&#x20a6; {{contribution.amount | currency}}</td>
                <td v-for="bank in banks" :key="bank.id" v-show="bank.id == contribution.bank_id">{{bank.bank_name}}<br />{{bank.name}}<br />{{bank.number}}</td>
                <td>{{contribution.admin_id}}</td>
                <td v-show="contribution.status == 1">Awaiting Admin Payment</td>
                <td v-show="contribution.status == 2">Awaiting Confirmation</td>
                <td v-show="contribution.status == 3">Onsite Confirmed</td>
                <td v-show="contribution.status == 4">Admin Confirmed</td>
                <td v-show="contribution.status == 5">Rejected</td>
                <td v-show="contribution.status < 3"><div class="btn-group"><button class="btn btn-sm btn-primary" v-on:click="editContribution(contribution)">Edit</button><button class="btn btn-sm btn-danger">Delete</button></div></td>
                <td v-show="contribution.status >= 3">&nbsp;</td>
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
        this.getAllInitials();    
    },
    props: {'banks':Array, 'contributions':Array, 'savings':Array,},
}
</script>