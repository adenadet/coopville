<template>
<div class="table-responsive">
    <table class="table m-b-0">
        <thead>
            <tr>
                <th>Request Date</th>
                <th>Savings Account</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="withdrawal in withdrawals" :key="withdrawal.id" :value="withdrawal.id">
                <td><span>{{withdrawal.request_date | ExcelDate}}</span></td>
                <td><span class="text-info"><router-link :to="'/member_area/savings#details'+withdrawal.savings.name">{{withdrawal.savings.name}}
                </router-link></span></td>
                <td>{{withdrawal.amount | currency}}</td>
                <td>{{withdrawal.payment_date ? (withdrawal.payment_date | ExcelDate) : ''}}</td>
                <td v-show="(withdrawal.status == 0)"><span class="badge badge-warning">Unpaid</span></td>
                <td v-show="(withdrawal.status == 3)"><span class="badge badge-success">Confirmed Awaitng</span></td>
                <td v-show="(withdrawal.status == 1)"><span class="badge badge-success">Paid</span></td>
                <td v-show="(withdrawal.status == 2)"><span class="badge badge-danger">Cancelled</span></td>
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
        editWithdrawal(withdrawal){
            Fire.$emit('editContribution', contribution);
        },
        getAllInitials(){},
    },
    mounted() {
        this.getAllInitials(); 
        //Fire.$on('loadWithdrawals', withdrawals =>{this.withdrawals = withdrawals;});     
    },
    props: {'banks':Array, 'withdrawals':Array, 'savings':Array,},
}
</script>