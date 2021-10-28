<template>
<div class="table-responsive">
    <table class="table table-hover js-basic-example dataTable table-custom table-striped m-b-0 c_list">
        <thead>
            <tr>
                <th>Cooperator: </th>
                <th colspan=3>{{account.user.first_name}} {{account.user.last_name}}</th>
                <th>Branch</th>
                <th>{{account.branch.name}}</th>
                <th>Loan Name:</th>
                <th>{{account.name}}</th>
            </tr>
            <tr>
                <th>Collected: </th>
                <th>&#x20a6; {{account.amount | currency}}</th>
                <th>Repaid:</th>
                <th>&#x20a6; {{account.total_paid | currency}}</th>
                <th>Balance:</th>
                <th>&#x20a6; {{account.balance | currency}}
                </th>
                <th>Total Payable:</th>
                <th>&#x20a6; {{account.payable | currency}}
                </th>
            </tr>
        </thead>
    </table>
    <DetailUserRepayments :repayments="account.repayments" :banks="banks"/>
</div>

</template>

<script>
export default {
    data(){
        return {
            accounts:{},
            loans:{},
        }
    },
    methods:{
        deleteRayment(id){

        },
        editRepayment(repayment){
            console.log('Repayment Started');
            Fire.$emit('editRepayment', repayment);
        },
        getAllInitials(){
        },
    },
    mounted() {
        this.getAllInitials();    
    },
    props: {'account': Object, 'banks': Array,},
}
</script>
