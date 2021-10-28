<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">
                <div class="user-profile layout-spacing">
                    <div class="widget-content widget-content-area">
                        <div class="d-flex justify-content-between">
                            <h3 class="">User Details</h3>
                        </div>
                        <div class="user-info-list">
                            <div class="text-center user-info">
                                <img :src="'/img/profile/'+user.image" class="img-fluid" width="300" height="auto" alt="avatar">
                                <p class=""></p>
                            </div>
                            <div class="">
                                <ul class="contacts-block list-unstyled">
                                    <li class="contacts-block__item">
                                        <i class="fa fa-user" width="24" height="24"></i> {{user.first_name}} {{user.middle_name}} {{user.last_name}}
                                    </li>
                                    <li class="contacts-block__item">
                                        <i class="fa fa-calendar" width="24" height="24"></i> {{user.dob | ExcelDate}}
                                    </li>
                                    <li class="contacts-block__item">
                                        <i class="fa fa-map-marker" width="24" height="24"></i> 
                                        {{user.street}} <br />
                                        {{user.street2 ? ', '+user.street2: ''}}<br v-if="user.street2 != null" />
                                        {{user.city}}.  
                                    </li>
                                    <li class="contacts-block__item">
                                        <a :href="'mailto:'+user.email"><i class="fa fa-envelope" width="24" height="24"></i> {{user.email}}</a>
                                    </li>
                                    <li class="contacts-block__item">
                                        <i class="fa fa-phone" width="24" height="24"></i> {{user.phone}} {{user.alt_phone ? ', '+user.alt_phone: ''}} 
                                    </li>
                                </ul>
                            </div>                                    
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#contributions" data-toggle="tab">Contributions</a></li>
                        <li class="nav-item"><a class="nav-link" href="#withdrawals" data-toggle="tab">Withdrawals</a></li>
                        <li class="nav-item"><a class="nav-link" href="#repayments" data-toggle="tab">Repayments</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="contributions">
                                <DetailUserContributions :contributions="contributions" :banks="banks"/>
                            </div>
                            <div class="tab-pane" id="withdrawals">
                                <DetailUserWithdrawals :withdrawals="withdrawals" :banks="banks"/>
                            </div>
                            <div class="tab-pane" id="repayments">
                                <DetailUserRepayments :repayments="repayments" :banks="banks"/>
                            </div>
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
            return  {
                areas:[],  
                contributions:[],
                banks:[],
                branches:[],  
                nok:{},
                repayments: [],
                states:[],  
                user:{}, 
                withdrawals:[],
            }
        },
        mounted() {
            /*Fire.$on('viewUser', user=>{
                //this.viewUser(user);
                this.getUser(user);
            }); 
        },
        created() {*/
            this.getInitials();
            Fire.$on('Reload', response =>{
                this.areas = response.data.areas;
                this.banks = response.data.banks;
                this.branches = response.data.branches;
                this.states = response.data.states;
                this.user = response.data.user;
                
                Fire.$emit('BioDataFill', this.user);
                Fire.$emit('NextOfKinFill', this.nok);
            });
        },
        methods:{
            editContribution(contribution){
                this.editMode = true;
                this.form.fill(contribution);
            },
            getInitials(){
                this.$Progress.start();
                console.log(this.$route.params.id);
                axios.get('/api/coop/users/'+this.$route.params.id).then(response =>{
                    this.banks = response.data.banks;
                    this.contributions = response.data.contributions;
                    this.repayments = response.data.repayments;
                    this.user = response.data.user;
                    this.withdrawals = response.data.withdrawals;
                    this.$Progress.finish();   
                })
                .catch(()=>{this.$Progress.fail();});
            },
            getUser(user){
                this.$Progress.start();
                axios.get('/api/coop/users/'+user.id).then(response =>{
                    this.banks = response.data.banks;
                    this.contributions = response.data.contributions;
                    this.repayments = response.data.repayments;
                    this.user = response.data.user;
                    this.withdrawals = response.data.withdrawals;
                    this.$Progress.finish();   
                })
                .catch(()=>{this.$Progress.fail();});
            },
            getProfilePic(){
                let photo = (this.user.image.length >= 150) ? this.user.image : "./"+this.user.image;
                return photo;
            },
            updateProfilePic(e){
                let file = e.target.files[0];
                let reader = new FileReader();
                if (file['size'] < 2000000){
                    reader.onloadend = (e) => {this.user.image = reader.result;}
                    reader.readAsDataURL(file)
                    }
                else{swal.fire({type: 'error', title: 'File is too large'});}
                },
        },
    }
</script>
