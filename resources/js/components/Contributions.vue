<template>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header"><h2>All Savings Accounts</h2></div>
                <div class="body">
                    <ul class="nav nav-tabs-new2">                    
                        <li class="nav-item" v-for="saving in savings" :key="saving.id" :value="saving.id"><a class="nav-link" data-toggle="tab" :href="'#details'+saving.name">{{loan.name}}</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" v-for="saving in savings" :key="saving.id" :value="saving.id" :id="'details'+saving.name">
                            <DetailSavingsAccount :account="loan"></DetailSavingsAccount>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        console.log('Component mounted.')
    }
}
</script>
