<template>
<div class="row clearfix">
    <div class="modal fade" id="addNewModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
            <FormContribution :contribution="contribution"></FormContribution>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="header">
                <h2>Your Saving Accounts</h2>
            </div>
            <div class="body">
                <ul class="nav nav-tabs-new2">                    
                    <li class="nav-item" v-for="(saving, index) in savings" :key="index"><a class="nav-link" data-toggle="tab" :href="'#details'+saving.name">{{saving.name}}</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" v-for="saving in savings" :key="saving.id" :value="saving.id" :id="'details'+saving.name">
                        <DetailSavingsAccount :account="saving" :banks="banks"></DetailSavingsAccount>
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
            contribution:{},
            editMode: false,
            form: new Form({
                
            }),
            savings:{},
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
            $('#addNewModal').modal('show');
        },
        getAllInitials(){
            axios.get('/api/coop/contributions/initials').then(response =>{
                this.accounts = response.data.accounts;
                this.banks = response.data.accounts;
                this.savings = response.data.savings;
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'All Savings Account loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'All Savings Accounts were not loaded successfully',
                })
            });
        },
        refresh(){
            $('#addNewModal').modal('hide');
            this.getAllInitials();
        },
        
    },
    mounted() {
        this.getAllInitials();   
        Fire.$on('editContribution', contribution =>{
                this.editContribution(contribution);
            }); 
        Fire.$on('Refresh', () =>{
                this.refresh();   
            }); 
        },
}
</script>
