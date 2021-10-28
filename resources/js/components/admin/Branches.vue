<template>
<div class="row clearfix">
    <div class="modal fade" id="addNewModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
            <FormBioData :branches="branches" :states="states" :outside="outside" :editMode="editMode"></FormBioData>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="header">
                <h2>Your Branch Members</h2>
            </div>
            <div class="body">
                <ul class="nav nav-tabs-new2">                    
                    <li class="nav-item" v-for="branch in branches" :key="branch.id" :value="branch.id"><a class="nav-link" data-toggle="tab" :href="'#details'+branch.name">{{branch.name}}</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" v-for="branch in branches" :key="branch.id" :value="branch.id" :id="'details'+branch.name">
                        <DetailBranchMember :account="branch" :banks="banks"></DetailBranchMember>
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
            branches: [],
            states: [],
            outside: false,
            editMode: false,
            route: '',
            user: {},
        }
    },
    methods:{
        editRepayment(user){
            $('#addNewModal').modal('show');
        },
        getAllInitials(){
            this.$Progress.start();
            console.log(this.$route.params.id);
            if (this.$route.params.id != ''){
                this.route = '/api/coop/branches/' + this.$route.params.id
            }
            else{
                this.route = "/api/coop/branches"
            }
            axios.get(this.route).then(response =>{
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
        seeUser(user){
            $('#addNewModal').modal('show');
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